<?php

namespace App\Http\Controllers\Admin\api\v1\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\api\v1\user\StoreUserRequest;
use App\Repositories\Admin\api\v1\user\UserRepository;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->userCreate($request->validated());
        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->userRepository->get($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return $this->userRepository->userUpdate($user, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $this->userRepository->delete($user);
    }
}
