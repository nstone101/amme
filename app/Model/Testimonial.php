<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name','profession', 'messages', 'image', 'status'];

    public function getImageAttribute($photo) {
        $p = asset('assets/images/avater.jpg');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }
}
