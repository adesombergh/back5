<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortieType extends Model
{
    public function sorties()
    {
    	$this->hasMany('\App\Sortie');
    }
}
