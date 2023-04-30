<?php

namespace App\Service;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CommentService
{
    private $model;

    public function __construct(Comment $commentModel)
    {
        $this->model = $commentModel;
    }

    public function resource($id)
    {
        return $this->model->with(['post', 'parent', 'children'])->findOrFail($id);
    }

    public function store($request)
    {
        $data = [];
        $post = Post::find($request->post_id);
        if ($post == null) {
            $data['message']['postNotFound'] = __('validation.postNotFound');
            return $data;
        }

        if (isset($request->parent_comment_id) || $request->parent_comment_id) {
            $comment = $this->model->find($request->parent_comment_id);
            if ($comment == null) {
                $data['message']['commentNotFound'] = __('validation.commentNotFound');
                return $data;
            }
        }

        $parentCommentId = $request->parent_comment_id;
        $comment = $this->model->create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'parent_comment_id' => isset($parentCommentId) ? $parentCommentId : NULL,
            'comment' => $request->comment
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(4) . '-' . $file->getClientOriginalName();
            $file->storeAs('public/comment/image', $filename);
            $comment->image = $filename;
            $comment->save();
        }

        $data['comments'] = $this->model->with(['post', 'children', 'parent'])->find($comment->id);
        return $data;
    }

    public function update($reques, $id)
    {
        $comment = $this->resource($id);

        $data = [];
        $updateComment = $comment->update([
            'user_id' => Auth::id(),
            'comment' => $reques->comment
        ]);

        $data['comments'] = $this->model->with(['post', 'children'])->find($comment->id);
        return $data;
    }

    public function delete($id)
    {
        $comment = $this->resource($id);

        if (isset($comment->parent) || $comment->parent != null) {
            foreach ($comment->parent as $parent) {
                $parent->delete();
            }
        }

        if (isset($comment->children) || $comment->children != null) {
            $comment->children->delete();
        }

        if ($comment->image != null) {
            Storage::delete('public/comment/image/' . $comment->getRawOriginal('image'));
        }

        if ($comment->delete()) {
            $data['message']['deleted'] = __('validation.commentDeletedSucessfully');
            return $data;
        }
    }
}
