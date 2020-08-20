<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPost extends Model
{
    protected $fillable = [
    	'group_id', 'post_id', 'member_id','timestamp','posted'
    ];

   public function post()
	{
	return $this->belongsTo(Post::class, 'post_id', 'id');
	}

	public function member()
	{
	return $this->belongsTo(Member::class, 'member_id', 'id');
	}
}
