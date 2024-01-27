<?php

namespace App\Http\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use App\Http\Services\Responses\ServiceResponse;
use App\Http\Services\Params\Appointments\StoreServiceParams;

class AppointmentService
{
    protected $userModel;
    protected $appointmentModel;

    public function __construct(Appointment $appointmentModel, User $userModel)
    {
        $this->userModel = $userModel;
        $this->appointmentModel = $appointmentModel;
    }

    public function getPendingAppointments()
    {
        $appointments = $this->appointmentModel
            ->where('status', 'pending')
            ->where('end_date', '>', Carbon::now()->toDateTimeString())
            ->orderBy('start_date')
            ->get();

        return $appointments;
    }

    public function getNextAppointments(?int $limit = null)
    {
        $user = auth()->user();

        $query = $user
            ->appointments()
            ->where('end_date', '>', Carbon::now()->toDateTimeString())
            ->orderBy('start_date');

        if (!is_null($limit)) {
            $query = $query->limit(4);
        }

        return $query->get();
    }

    public function getEndedAppointments(?int $userId = null, ?int $limit = null, bool $isCount = false)
    {
        $query = $this->appointmentModel
            ->where('status', 'confirmed')
            ->where('end_date', '<', Carbon::now()->toDateTimeString())
            ->orderBy('end_date', 'desc');

        if (!is_null($userId)) {
            $user = $this->userModel->find($userId);
            $query->where($user->type . '_id', $userId);
        }

        if ($isCount) {
            return $query->count();
        }

        if (!is_null($limit)) {
            $query = $query->limit(4);
        }

        return $query->get();
    }

    public function getNextAppointmentDate()
    {
        $user = auth()->user();

        $query = $user
            ->appointments()
            ->where('status', 'confirmed')
            ->where('end_date', '>', Carbon::now()->toDateTimeString())
            ->orderBy('start_date')
            ->first();

        if (is_null($query)) {
            return '-';
        }

        return $query->start_date->format('d/m H:i');
    }

    public function getConfirmedAppointments(?int $userId = null, bool $isCount = false)
    {
        $query = $this->appointmentModel
            ->where('status', 'confirmed');

        if (!is_null($userId)) {
            $user = $this->userModel->find($userId);
            $query->where($user->type . '_id', $userId);
        }

        if ($isCount) {
            return $query->count();
        }

        return $query->orderBy('start_date', 'desc')->get();
    }

    public function loadAppointments(?string $startDate = null, ?string $endDate = null)
    {
        $user = auth()->user();

        $query = $user->appointments()->where('status', '!=', 'cancelled');

        if (!is_null($startDate)) {
            $query = $query->where(
                'start_date',
                '>=',
                Carbon::parse($startDate)->toDateTimeString()
            );
        }

        if (!is_null($endDate)) {
            $query = $query->where(
                'end_date',
                '<=',
                Carbon::parse($endDate)->toDateTimeString()
            );
        }

        if ($user->type === 'patient') {
            return $query
                ->join('users', 'users.id', 'appointments.doctor_id')
                ->get([
                    'appointments.id',
                    'users.name as title',
                    'start_date as start',
                    'end_date as end',
                    DB::raw('CONCAT("bg-c-", color, " border-none") AS classNames'),
                    DB::raw('CONCAT("/appointments/", appointments.id) AS url'),
                ]);
        }

        return $query
            ->join('users', 'users.id', 'appointments.patient_id')
            ->get([
                'appointments.id',
                'users.name as title',
                'start_date as start',
                'end_date as end',
                DB::raw('CONCAT("bg-c-", color, " border-none") AS classNames'),
                DB::raw('CONCAT("/appointments/", appointments.id) AS url'),
            ]);
    }

    public function loadAllAppointments(?string $startDate = null, ?string $endDate = null)
    {
        $user = auth()->user();

        if ($user->type !== 'admin') {
            return null;
        }

        $query = $this->appointmentModel->where('status', '!=', 'cancelled');

        if (!is_null($startDate)) {
            $query = $query->where(
                'start_date',
                '>=',
                Carbon::parse($startDate)->toDateTimeString()
            );
        }

        if (!is_null($endDate)) {
            $query = $query->where(
                'end_date',
                '<=',
                Carbon::parse($endDate)->toDateTimeString()
            );
        }

        return $query
            ->join('users', 'users.id', 'appointments.doctor_id')
            ->get([
                'appointments.id',
                'users.name as title',
                'start_date as start',
                'end_date as end',
                DB::raw('CONCAT("bg-c-", color, " border-none") AS classNames'),
                DB::raw('CONCAT("/appointments/", appointments.id) AS url'),
            ]);
    }

    public function loadDoctorAppointments(
        int $doctorId,
        ?string $startDate = null,
        ?string $endDate = null
    ) {
        $doctor = $this->userModel->find($doctorId);

        $query = $doctor->appointments()->where('status', '!=', 'cancelled');

        if (!is_null($startDate)) {
            $query = $query->where(
                'start_date',
                '>=',
                Carbon::parse($startDate)->toDateTimeString()
            );
        }

        if (!is_null($endDate)) {
            $query = $query->where(
                'end_date',
                '<=',
                Carbon::parse($endDate)->toDateTimeString()
            );
        }

        return $query
            ->get([
                'appointments.id',
                DB::raw('"Reserved" AS title'),
                'start_date as start',
                'end_date as end',
                DB::raw('CONCAT("bg-c-gray border-none") AS classNames')
            ]);
    }

    public function store(string $startDate, int $doctorId, ?int $patientId)
    {
        try {
            $user = auth()->user();

            $endDate = Carbon::parse($startDate)->addHours(1)->toDateTimeString();
            $startDate = Carbon::parse($startDate)->toDateTimeString();

            $storeParams = new StoreServiceParams(
                $patientId ?? $user->id,
                $doctorId,
                $startDate,
                $endDate
            );

            $appointment = $this->appointmentModel->create($storeParams->toArray());
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error creating schedule',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'Schedule created successfully',
            $appointment
        );
    }

    public function cancel(int $appointmentId)
    {
        try {
            $user = auth()->user();

            $query = $this->appointmentModel->where('id', $appointmentId);

            if ($user->type !== 'admin') {
                $query = $query->where(function ($query) use ($user) {
                    $query->where('patient_id', $user->id)
                        ->orWhere('doctor_id', $user->id);
                });
            }

            $appointment = $query->first();

            if (is_null($appointment)) {
                return new ServiceResponse(
                    false,
                    'User is not allowed to cancel appointment'
                );
            }

            $appointment->status = 'cancelled';
            $appointment->color = 'red';
            $appointment->save();
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error canceling appointment',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'Appointment canceled successfully',
            $appointment
        );
    }

    public function confirm(int $appointmentId)
    {
        try {
            $user = auth()->user();

            if ($user->type !== 'admin') {
                return new ServiceResponse(
                    false,
                    'User does not have permission to confirm appointment'
                );
            }

            $appointment = $this->appointmentModel->find($appointmentId);
            $appointment->status = 'confirmed';
            $appointment->color = 'green';
            $appointment->save();
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error confirming appointment',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'Appointment confirmed successfully',
            $appointment
        );
    }

    public function destroy(int $appointmentId)
    {
        try {
            $user = auth()->user();

            $query = $this->appointmentModel->where('id', $appointmentId);

            if ($user->type !== 'admin') {
                $query = $query->where(function ($query) use ($user) {
                    $query->where('patient_id', $user->id)
                        ->orWhere('doctor_id', $user->id);
                });
            }

            $appointment = $query->first();

            if (is_null($appointment)) {
                return new ServiceResponse(
                    false,
                    'User does not have permission to delete schedule'
                );
            }

            $appointment->delete();
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error when deleting schedule',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'Deleted schedule successfully',
            $appointment
        );
    }
}
