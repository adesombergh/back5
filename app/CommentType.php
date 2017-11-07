<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentType extends Model
{
	public $timestamps = false;
    public function comments()
    {
    	return $this->hasMany('\App\Comment');
    }
}
