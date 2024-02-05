<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Secretary;
use Illuminate\Http\Request;
use App\Http\Services\UserService;

class SecretaryController extends Controller
{
    protected $userModel;
    protected $userService;

    public function __construct(
        User $userModel,
        UserService $userService
    ) {
        $this->userModel = $userModel;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $user = auth()->user();

    // Use the Secretary model to query the 'secretaries' table
    $secretaries = Secretary::join('users', 'secretaries.user_id', '=', 'users.id')
        ->leftJoin('users as doctors', 'secretaries.doctors_id', '=', 'doctors.id') // Left join with users table for doctors
        ->where('users.type', 'secretary')
        ->orderBy('users.name')
        ->get(['users.*', 'secretaries.*', 'doctors.name as doctor_name','users.id as userd']); // Include the doctor's name in the result

    return view('admin.secretaries', compact('user', 'secretaries'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->type === 'admin') {
            // Retrieve the list of users with type 'doctor'
            $doctors = User::where('type', 'doctor')->orderBy('name')->get(['id', 'name']);

            return view('admin.secretaries-create', compact('user', 'doctors'));
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->type !== 'admin') {
            return redirect(route('secretaries.index'))->withError('User without permissions!');
        }

        $storeResponse = $this->userService->store($request, 'secretary');

        if (!$storeResponse->success) {
            return redirect(route('secretaries.index'))->withError('Error creating user!');
        }
        
        return redirect(route('secretaries.index'))->withSuccess('User created successfully!');
    }

    /**
     * Display and show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = auth()->user();

        $secretary = $this->userModel->find($id);
        // dd($secretary);

        if ($user->type === 'admin') {
            return view('admin.secretary', compact('user', 'secretary'));
        }

        return view('secretaries', compact('user', 'secretary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    
    {
        // dd($request->all());
        $updateResponse = $this->userService->update($id, $request);

        if (!$updateResponse->success) {
            return redirect(route('secretaries.show', $id))->withError('Error editing user!');
        }

        return redirect(route('secretaries.show', $id))->withSuccess('User edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = auth()->user();

        if ($user->type !== 'admin') {
            return redirect(route('secretaries.index'))->withError('User without permissions!');
        }

        $destroyResponse = $this->userService->destroy($id);

        if (!$destroyResponse->success) {
            return redirect(route('secretaries.index'))->withError('Error removing user!');
        }

        return redirect(route('secretaries.index'))->withSuccess('User removed successfully!');
    }
}
