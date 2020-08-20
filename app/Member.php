<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	 protected $fillable = [
						     'group_id', 'name'
						   ];
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

	public function memberposts()
	{
	return $this->hasMany(MemberPost::class, 'member_id', 'id');
	}
}
