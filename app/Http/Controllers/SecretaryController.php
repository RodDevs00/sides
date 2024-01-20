<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $secretaries = User::where('type', 'secretary')->orderBy('name')->get();

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
            return view('admin.secretaries-create', compact('user'));
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
