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
        $this->middleware('permission:user-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * all users
     */
    public function index(): UserCollection
    {
        $users = $this->userRepository->getAll();
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->userRepository->userCreate($request->validated());
        return new UserResource($user->load($this->with));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $user = $this->userRepository->get($user);
        return new UserResource($user->load($this->with));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user = $this->userRepository->userUpdate($user, $request->validated());
        return new UserResource($user->load($this->with));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): UserResource
    {
        $user = $this->userRepository->delete($user);
        return new UserResource($user);
    }

    /**
     * Removes a resource from storage
     * force delete
     */
    public function userForceDelete($id): UserResource
    {
        $user = $this->userRepository->userForceDelete($id);
        return new UserResource($user);
    }

    /**
     * Removes a resource from storage
     */
    public function userReturnReject($id)
    {
        $user = $this->userRepository->userReturnReject($id);
        return new UserResource($user);
    }
}
