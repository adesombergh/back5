<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    public function caisse()
    {
    	return $this->belongsTo('\App\Caisse');
    }
    public function type()
    {
    	return $this->belongsTo('\App\SortieType');
    }

    public function getType()
    {
    	//\App\SortieType::where('id',$sortie->type)->get()->first()->name;
    	return \App\SortieType::where('id',$this->type)->get()->first();
    }

    public function getAvances()
    {
        return $this->sorties->where('type', \App\SortieType::where('name','Avance')->get()->first()->id );
    }

}