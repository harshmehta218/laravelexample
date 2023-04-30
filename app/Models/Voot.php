<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'up_voot',
        'down_voot',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'user_id',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
