<?php

namespace App\Service;

use App\Models\Post;
use App\Models\Voot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostService
{
    private $model;

    public function __construct(Post $postModel)
    {
        $this->model = $postModel;
    }

    public function collection($request)
    {
        $collection = '';
        $posts = $this->model->with('postFile', 'voots', 'comments');

        if (isset($request->search)) {
            $search = $request->search;
            $collection = $posts->where('title', 'LIKE', '%' . $search . '%');
        }

        if (isset($request->page) && $request->page == -1) {
            $collection = $posts->get();
        } else {
            $collection = $posts->paginate(10);
        }
        return $collection;
    }

    public function show($id)
    {
        $voot = new Voot();
        $response = [];
        $post = $this->model->with('postFile', 'comments.parent', 'comments.children')->findOrFail($id);
        $postVoots = $voot->where('post_id', $post->id)->get();
        if ($postVoots != null) {
            $upVoots = $voot->where('post_id', $post->id)->where('up_voot', '!=', NULL)->count();
            $downVoots = $voot->where('post_id', $post->id)->where('down_voot', '!=', NULL)->count();
            $response['post'] = [
                'post' => $post,
                'voots' => [
                    'upVoot' => $upVoots,
                    'downVoot' => $downVoots,
                ],
            ];
        }
        return $response;
    }

    public function resource($id)
    {
        $post = $this->model->with('postFile', 'voots', 'comments')->findOrFail($id);
        return $post;
    }

    public function store($request)
    {
        $data = [];
        $createPost =  $this->model->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random(4) . '-' . $file->getClientOriginalName();
                $file->storeAs('public/post/file', $filename);
                $createPost->postFile()->create([
                    'post_id' => $createPost->id,
                    'file' => $filename

                ]);
            }
        }

        $postData = $this->resource($createPost->id);
        $data['post'] = $postData;

        return $data;
    }

    public function update($request, $id)
    {
        $data = [];
        $post = $this->resource($id);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random(4) . '-' . $file->getClientOriginalName();
                $file->storeAs('public/post/file', $filename);
                $post->postFile()->create([
                    'post_id' => $post->id,
                    'file' => $filename
                ]);
            }
        }
        $data['updatedPost'] = $this->resource($post->id);
        return $data;
    }

    public function delete($id)
    {
        $data = [];
        $post = $this->resource($id);
        if ($post->postFile() != null) {
            foreach ($post->postFile as $file) {
                $tst =  Storage::delete('public/post/file/' . $file->getRawOriginal('file'));
            }
            $post->postFile()->delete();
        }
        if ($post->delete()) {
            $data['message']['deletdsucessfully'] = __('validation.deleted');
            return $data;
        }
    }
}
