<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_file extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'file',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function getFileAttribute($value)
    {
        return url('storage/post/file/' . $value);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
