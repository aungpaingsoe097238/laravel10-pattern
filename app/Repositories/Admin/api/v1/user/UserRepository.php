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

    public function userCreate(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->syncRoles($data['roles']);
        return $user;
    }

    public function userUpdate(User $user, array $data)
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
     * force delete to user
     */
    public function userForceDelete($id)
    {
        return User::onlyTrashed()->findOrFail($id)->forceDelete(); 
    }

    /**
     * return reject user
     */
    public function userReturnReject($id)
    {
        return User::onlyTrashed()->findOrFail($id)->restore();
    }
}
