<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_comment_id',
        'comment',
        'image'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'user_id',
        'post_id',
        'parent_comment_id',
    ];

    public function getImageAttribute($value)
    {
        return url('storage/comment/image/' . $value);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parent()
    {
        return $this->hasMany(Comment::class, 'id','parent_comment_id');
    }

    public function children()
    {
        return $this->belongsTo(Comment::class, 'id','parent_comment_id');
    }
}
