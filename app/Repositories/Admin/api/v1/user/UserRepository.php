<?php

namespace App\Repositories\Admin\api\v1\user;

use App\Http\Resources\Admin\api\v1\user\UserResource;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     *  Create new User with assign Roles
     */
    public function userCreate(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->syncRoles($data['roles']);
        return $user;
    }

    /**
     *  Update User and assign Roles
     */
    public function userUpdate(User $user, array $data) : User
    {
        $data['name']  = $data['name'] ?? $user->name;
        $data['email'] = $data['email'] ?? $user->email;

        $user->update([
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Force Delete User
     */
    public function userForceDelete($id) : bool
    {
        return User::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    /**
     * Reutrn Reject User
     */
    public function userReturnReject($id) : bool
    {
        return User::onlyTrashed()->findOrFail($id)->restore();
    }
}
