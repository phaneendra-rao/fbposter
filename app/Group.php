<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function members()
    {
        return $this->hasMany('App\Member');
    }
}
