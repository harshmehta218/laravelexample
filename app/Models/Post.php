<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function postFile()
    {
        return $this->hasMany(Post_file::class);
    }

    public function voots()
    {
        return $this->hasMany(Voot::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
