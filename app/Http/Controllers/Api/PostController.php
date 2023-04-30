<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\PostService;
use App\Http\Requests\Post\Create;
use App\Http\Requests\Post\Update;
use App\Http\Resources\Post\PostCollection;

class PostController extends Controller
{
    private $service;

    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    public function index(Request $request)
    {
        $data = $this->service->collection($request);
        return new PostCollection($data);
    }

    public function store(Create $request)
    {
        $data = $this->service->store($request);
        return $data;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
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
