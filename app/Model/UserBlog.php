<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserBlog extends Model
{
    protected $fillable = ['ip', 'blog_id', 'status'];
}
