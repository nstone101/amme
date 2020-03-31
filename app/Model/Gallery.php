<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name', 'category_id', 'description', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class,'category_id');
    }

    public function getImageAttribute($photo){
        $p = asset('assets/images/avater.jpg');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }
}
