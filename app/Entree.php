<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    public function caisse()
    {
    	return $this->belongsTo('\App\Caisse');
    }
    public function type()
    {
    	return $this->belongsTo('\App\EntreeType');
    }

    public function getType()
    {
    	return \App\EntreeType::where('id',$this->type)->get()->first();
    }
}
