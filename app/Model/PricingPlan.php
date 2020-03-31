<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = ['title', 'description', 'price', 'duration', 'status'];
}
