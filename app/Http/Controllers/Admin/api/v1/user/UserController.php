<?php

namespace App\Http\Controllers\Admin\api\v1\user;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\api\v1\user\StoreUserRequest;
use App\Http\Requests\Admin\api\v1\user\UpdateUserRequest;
use App\Http\Resources\Admin\api\v1\user\UserCollection;
use App\Http\Resources\Admin\api\v1\user\UserResource;
use App\Repositories\Admin\api\v1\user\UserRepository;

class UserController extends Controller
{
    protected $userRepository;
    protected $with = [];

    public function __construct(UserRepository $userRepository)
    {
        $this->with = ['roles'];
        $this->userRepository = $userRepository;
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userRepository->getAll();
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->userCreate($request->validated());
        return new UserResource($user->load($this->with));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $this->userRepository->get($user);
        return new UserResource($user->load($this->with));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->userRepository->userUpdate($user, $request->validated());
        return new UserResource($user->load($this->with));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = $this->userRepository->delete($user);
        return new UserResource($user);
    }
}
