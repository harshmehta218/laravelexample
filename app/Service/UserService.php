<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $model;

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    public function register($request)
    {
        $data = [];
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $data['user'] = $user;
        return $data;
    }


    public function logIn($request)
    {
        $data = [];
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $data = [
                'user' => $user,
                'token' => $user->createToken("Api_token")->plainTextToken
            ];
        } else {
            $data['message']['userNotFound'] = __('validation.usernotfound');
        }
        return $data;
    }
}
