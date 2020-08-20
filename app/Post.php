<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    'group_id', 'name', 'url','comment','days_after_post','day','image'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

   	public function memberposts()
	{
	return $this->hasMany(MemberPost::class, 'post_id', 'id');
	}
}
