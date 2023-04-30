<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login;
use Illuminate\Http\Request;
use App\Service\UserService;
use App\Http\Requests\User\Register;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function register(Register $request)
    {
        $data = $this->service->register($request);
        return response()->json($data);
    }

    public function logIn(Login $request)
    {
        $data = $this->service->logIn($request);
        return response()->json($data);
    }
}
