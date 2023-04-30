<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Voot\Create;
use App\Http\Requests\Voot\DownVoot;
use App\Http\Requests\Voot\UpVoot;
use App\Service\VootService;
use Illuminate\Http\Request;

class VootController extends Controller
{
    private $service;

    public function __construct(VootService $vootService)
    {
        $this->service = $vootService;
    }

    public function upVoot(UpVoot $request)
    {
        $data = $this->service->upVoot($request);
        return $data;
    }

    public function downVoot(DownVoot $request)
    {
        $data = $this->service->downVoot($request);
        return $data;
    }
}
