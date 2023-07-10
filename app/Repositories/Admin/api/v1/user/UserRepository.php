<?php

namespace App\Repositories\Admin\api\v1\user;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /*
     *  create user
     */
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

    /*
    * update user
    */
    public function userUpdate(User $user, $request)
    {
        //
    }
}
