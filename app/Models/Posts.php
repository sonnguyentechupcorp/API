<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = "posts";

    protected $fillable = [
        'title',
        'body',
        'feature_img',
        'author_id',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
