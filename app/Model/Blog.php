<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title', 'slug', 'description', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getImageAttribute($photo){
        $p = asset('assets/images/default-product.jpg');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }

    public static function get_comment_count($id)
    {
        $item = BlogComment::join('blogs','blogs.id','=','blog_comments.blog_id')
            ->where(['blogs.id'=>$id])
            ->count();
        return $item;
    }
}
