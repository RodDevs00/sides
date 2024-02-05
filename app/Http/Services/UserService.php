<?php

namespace App\Http\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Secretary; // Add the missing import for Secretary
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Responses\ServiceResponse;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function store(Request $request, string $type): ServiceResponse
    {
        try {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'type'      => $type,
                'password'  => Hash::make($request->password)
            ]);

            // Check if the file is provided and valid
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Generate a random name for the file based on the current timestamp
                $name = Str::random(6);
                $extension = $request->image->extension();
                $nameFile = "{$name}.{$extension}";

                // Perform the upload
                $upload = $request->image->storeAs('img/pictures', $nameFile);

                // If the upload fails, return with an error
                if (!$upload) {
                    return redirect()
                        ->back()
                        ->withError('Failed to upload the image')
                        ->withInput();
                }

                $user->image = $nameFile;
                $user->save();
            }

            if ($type === 'patient') {
                Patient::create([
                    'user_id' => $user->id
                ]);
                $user->refresh();

                $patient = $user->patient;
                $patient->blood_type = $request->blood;
                $patient->social_number = $request->social;
                $patient->save();
            }

            if ($type === 'secretary') {
                // dd($request->doctor_id); // Debugging to check the value being passed
            
                Secretary::create([
                    'user_id' => $user->id,
                    'doctors_id' => $request->doctor_id,
                    // Add additional fields for Secretary model here
                ]);
            
                $user->refresh();
            
                $secretary = $user->secretary;
            
                // dd($secretary->doctors_id); // Debugging to check the value after creation
            
                // Populate additional fields for Secretary model here
            
                $secretary->save();
            }
            

            if ($type === 'doctor') {
                Doctor::create([
                    'user_id' => $user->id
                ]);
                $user->refresh();

                $doctor = $user->doctor;
                $doctor->specialty = $request->specialty;
                $doctor->roomName = $request->roomName;
                $doctor->save();
            }

            if ($type === 'admin') {
                $user->api_token = Str::random(80);
                $user->save();
            }
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error creating user!',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'User created successfully!',
            $user
        );
    }

    public function update(int $userId, Request $request): ServiceResponse
    {
        try {
            $user = $this->userModel->find($userId);

            if ($user->type === 'patient' && is_null($user->patient)) {
                Patient::create([
                    'user_id' => $user->id
                ]);
                $user->refresh();
            }

            if ($user->type === 'doctor' && is_null($user->doctor)) {
                Doctor::create([
                    'user_id' => $user->id
                ]);
                $user->refresh();
            }

                // Check if the user type is 'secretary' and create a secretary if not exists
            if ($user->type === 'secretary' && is_null($user->secretary)) {
                Secretary::create([
                    'user_id' => $user->id
                    // Add other fields specific to the Secretary model if needed
                ]);
                $user->refresh();
            }

            // Check if the file is provided and valid
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Generate a random name for the file based on the current timestamp
                $name = Str::random(6);
                $extension = $request->image->extension();
                $nameFile = "{$name}.{$extension}";

                // Perform the upload
                $upload = $request->image->storeAs('img/pictures', $nameFile);

                // If the upload fails, return with an error
                if (!$upload) {
                    return redirect()
                        ->back()
                        ->withError('Failed to upload the image')
                        ->withInput();
                }

                $user->image = $nameFile;
            }

            // Update fields specific to the user type
        if ($user->type === 'patient') {
            $patient = $user->patient;
            $patient->blood_type = $request->blood;
            $patient->social_number = $request->social;
            $patient->save();
        } elseif ($user->type === 'doctor') {
            $doctor = $user->doctor;
            $doctor->specialty = $request->specialty;
            $doctor->roomName = $request->roomName;
            $doctor->save();
        } elseif ($user->type === 'secretary') {
            $secretary = $user->secretary;  
           
            $secretary->save();
        }
    
             
            $user->name = $request->name;
            $user->email = $request->email;
           
            $user->save();
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error editing user!',
                null,
                $th
            );
        }

        return new ServiceResponse(
            true,
            'User edited successfully!',
            $user
        );
    }

    public function destroy(int $userId): ServiceResponse
    {
        try {
            // Find the user by ID
            $user = $this->userModel->find($userId);
    
            if (!$user) {
                throw new \Exception('User not found.');
            }
    
            // Find the secretary by user_id and delete it
            $secretary = Secretary::where('user_id', $userId)->first();
    
            if ($secretary) {
                $secretary->delete();
            }
    
            // Delete the user
            $user->delete();
        } catch (\Throwable $th) {
            return new ServiceResponse(
                false,
                'Error removing user!',
                null,
                $th
            );
        }
    
        return new ServiceResponse(
            true,
            'User and Secretary removed successfully!',
            $user
        );
    }
    
}
