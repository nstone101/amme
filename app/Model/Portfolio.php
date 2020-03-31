<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['title', 'category_id', 'description', 'image', 'experience', 'client', 'date', 'demo', 'status'];

    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class,'category_id');
    }

    public function getImageAttribute($img)
    {
        $p=[asset('assets/images/default-product.jpg')];
        if(!empty($img)){
            $p=[];
            $temp = array_filter(explode('|',$img));
            for($i=1;$i<=count($temp);$i++){
                array_push($p,asset(path_image().$temp[$i]));
            }
        }
        return $p;
    }
}
