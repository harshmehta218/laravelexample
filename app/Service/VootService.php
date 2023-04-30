<?php

namespace App\Service;

use App\Models\Voot;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class VootService
{
    private $vootModel;
    private $postModel;

    public function __construct(Voot $voot, Post $post)
    {
        $this->postModel = $post;
        $this->vootModel = $voot;
    }

    public function upVoot($request)
    {
        $post = $this->postModel->with('voots')->findOrFail($request->post_id);
        if ($post != null) {
            $upVoot = $this->vootModel->create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'up_voot' => $request->up_voot
            ]);
        } else {
            $data['message']['postnotfound'] = __('validation.postNotFound');
        }
        $upVootResponse = $this->vootModel->with('post')->find($upVoot->id);
        $upVootResponse->up_voot = $this->vootModel->where('up_voot', '!=', NULL)->count();
        $data['Up_voot'] = $upVootResponse;
        return $data;
    }

    public function downVoot($request)
    {
        $post = $this->postModel->with('voots')->findOrFail($request->post_id);
        if ($post != null) {
            $upVoot = $this->vootModel->create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'down_voot' => $request->down_voot
            ]);
        } else {
            $data['message']['postnotfound'] = __('validation.postNotFound');
        }
        $upVootResponse = $this->vootModel->with('post')->find($upVoot->id);
        $upVootResponse->down_voot = $this->vootModel->where('down_voot', '!=', NULL)->count();
        $data['Down_Voot'] = $upVootResponse;
        return $data;
    }
}
