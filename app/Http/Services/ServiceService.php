<?php

namespace App\Http\Services;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Services\Responses\ServiceResponse;

class ServiceService
{
    protected $serviceModel;

    public function __construct(Service $serviceModel)
    {
        $this->serviceModel = $serviceModel;
    }

    public function store(Request $request): ServiceResponse
    {
        try {
            $service = $this->serviceModel->create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
            ]);

            return new ServiceResponse(true, 'Service created successfully!', $service);
        } catch (\Throwable $th) {
            \Log::error('Error creating service: ' . $th->getMessage());
            return new ServiceResponse(false, 'Error creating service!', null, $th);
        }
    }

    public function update(int $id, Request $request): ServiceResponse
    {
        try {
            $service = $this->serviceModel->find($id);

            if (!$service) {
                return new ServiceResponse(false, 'Service not found!', null);
            }

            $service->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
            ]);

            return new ServiceResponse(true, 'Service updated successfully!', $service);
        } catch (\Throwable $th) {
            return new ServiceResponse(false, 'Error updating service!', null, $th);
        }
    }

    public function destroy(int $id): ServiceResponse
    {

        try {
            $service = $this->serviceModel->find($id);
           
            $service->delete();
        } 
        catch (\Throwable $th) {
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
            $service
        );
    }
}
