<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'image', 'status'];

    public function getImageAttribute($photo){
        $p = asset('assets/images/default-product.jpg');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }

}
