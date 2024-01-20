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
                Secretary::create([
                    'user_id' => $user->id,
                    // Add additional fields for Secretary model here
                ]);

                $user->refresh();

                $secretary = $user->secretary;
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

            if ($user->type === 'patient') {
                $patient = $user->patient;
                $patient->blood_type = $request->blood;
                $patient->social_number = $request->social;
                $patient->save();
            }

            if ($user->type === 'doctor') {
                $doctor = $user->doctor;
                $doctor->specialty = $request->specialty;
                $doctor->save();
            }

            $user->name = $request->name;
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
            $user = $this->userModel->find($userId);
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
            'User removed successfully!',
            $user
        );
    }
}
