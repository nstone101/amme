<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'category_id', 'designation', 'image', 'bio', 'email', 'facebook', 'google',
        'twitter', 'skype', 'linkedin', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function getImageAttribute($photo){
        $p = asset('assets/images/avater.jpg');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }
}
