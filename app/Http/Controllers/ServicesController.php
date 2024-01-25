<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Services\ServiceService;

class ServicesController extends Controller
{
    protected $serviceModel;
    protected $serviceService;

    public function __construct(
        Service $serviceModel,
        ServiceService $serviceService
    ) {
        $this->serviceModel = $serviceModel;
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $user = auth()->user();
        $services = Service::all();
        return view('admin.services', compact('user','services'));
        }

    public function create()
    {
        $user = auth()->user();
        return view('admin.service-create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->type !== 'admin') {
            return redirect(route('service.index'))->withError('User without permissions!');
        }
        $storeResponse = $this->serviceService->store($request);

        if (!$storeResponse->success) {
            return redirect(route('service.index'))->withError('Error creating service!');
        }

        return redirect(route('service.index'))->withSuccess('Service created successfully!');
    }

    public function show(int $id)
    {
        
       
        $user = auth()->user();

        $services = $this->serviceModel->find($id);

        return view('admin.service', compact('user', 'services'));
    }

    public function edit(int $id)
    {
        $service = $this->serviceModel->find($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, int $id)
    {
        $updateResponse = $this->serviceService->update($id, $request);

        if (!$updateResponse->success) {
            return redirect(route('service.show', $id))->withError('Error editing service!');
        }

        return redirect(route('service.show', $id))->withSuccess('Service edited successfully!');
    }

    public function destroy(int $id)
    {
        $destroyResponse = $this->serviceService->destroy($id);

        if (!$destroyResponse->success) {
            return redirect(route('service.index'))->withError('Error removing service!');
        }

        return redirect(route('service.index'))->withSuccess('Service removed successfully!');
    }
}
