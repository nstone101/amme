<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'description', 'status'];

}
