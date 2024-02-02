<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\AppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService;
    protected $appointmentModel;

    public function __construct(AppointmentService $appointmentService, Appointment $appointmentModel)
    {
        $this->appointmentService = $appointmentService;
        $this->appointmentModel = $appointmentModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->type === 'admin') {
            return view('admin.appointments', compact('user'));
        }

        return view('appointments', compact('user'));
    }

    public function load(Request $request)
    {
        $appointments = $this->appointmentService->loadAppointments(
            $request->start,
            $request->end
        );

        return response()->json($appointments);
    }

    public function loadAll(Request $request)
    {
        $appointments = $this->appointmentService->loadAllAppointments(
            $request->start,
            $request->end
        );

        return response()->json($appointments);
    }

    public function loadDoctor(Request $request)
    {
        $appointments = $this->appointmentService->loadDoctorAppointments(
            $request->id,
            $request->start,
            $request->end
        );

        return response()->json($appointments);
    }

    public function getDoctorsAvailableByDate(Request $request)
    {
        $appointments = $this->appointmentService->getDoctorsAvailableByDate(
            $request->date
        );

        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   // AppointmentController.php

   public function store(Request $request)
   {
       try {
           // Check for soft-deleted records as well
           $doctor = Doctor::where('user_id', $request->doctor)->withTrashed()->firstOrFail();
   
           // Access the roomName attribute from the doctor record
           $roomName = $doctor->roomName;
   
           // Pass all the required data to the AppointmentService
           $storeResponse = $this->appointmentService->store(
               $request->date,
               $request->doctor,
               $request->patient,
               $roomName
           );
   
           // Check the success status of the storeResponse
           if (!$storeResponse->success) {
               return redirect()->back()->withError('Error scheduling appointment');
           }
   
           // Return a success response
           return redirect()->back()->withSuccess('Appointment scheduled!');
       } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           // Log the exception
           Log::error('ModelNotFoundException: ' . $e->getMessage());
   
           // Handle the exception and return an error response
           return redirect()->back()->withError('Doctor not found');
       } catch (\Exception $e) {
           // Log the exception
           Log::error('Exception: ' . $e->getMessage());
   
           // Return an error response in case of an exception
           return redirect()->back()->withError('An unexpected error occurred');
       }
   }
   
                        
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = auth()->user();

        $query = $this->appointmentModel->where('id', $id);

        if ($user->type === 'admin') {
            $appointment = $query->first();

            return view('admin.appointment', compact('user', 'appointment'));
        }

        $appointment = $query
            ->where(function ($query) use ($user) {
                $query->where('patient_id', $user->id)
                    ->orWhere('doctor_id', $user->id);
            })
            ->first();

        if (is_null($appointment)) {
            abort(404);
        }

        return view('appointment', compact('user', 'appointment'));
    }

    /**
     * Cancel the appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(int $id)
    {
        $cancelResponse = $this->appointmentService->cancel($id);

        if (!$cancelResponse->success) {
            return redirect()->route('appointments.index')->withError('Error canceling appointment');
        }

        return redirect()->route('appointments.index')->withSuccess('Appointment canceled!');
    }

    /**
     * Confirm the appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(int $id)
    {
        $confirmResponse = $this->appointmentService->confirm($id);

        if (!$confirmResponse->success) {
            return redirect()->route('dashboard')->withError('Error confirming appointment');
        }

        return redirect()->route('dashboard')->withSuccess('Appointment confirmed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $destroyResponse = $this->appointmentService->destroy($id);

        if (!$destroyResponse->success) {
            return redirect()->route('appointments.index')->withError('Error deleting appointment');
        }

        return redirect()->route('appointments.index')->withSuccess('Appointment deleted!');
    }
}
