<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\Create;
use App\Http\Requests\Comment\Update;
use Illuminate\Http\Request;
use App\Service\CommentService;

class CommentController extends Controller
{
    private $service;

    public function __construct(CommentService $commentService)
    {
        $this->service = $commentService;
    }

    public function store(Create $request)
    {
        $data = $this->service->store($request);
        return $data;
    }

    public function update(Update $request, $id)
    {
        $data = $this->service->update($request, $id);
        return $data;
    }

    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return $data;
    }
}
