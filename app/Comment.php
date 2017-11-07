<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function service()
    {
    	return $this->belongsTo('\App\Service');
    }
    public function user()
    {
    	return $this->belongsTo('\App\User');
    }

    public function getType()
    {
    	return \App\CommentType::where('id',$this->type)->get()->first();
    }

}
