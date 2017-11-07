<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntreeType extends Model
{
    public function entrees()
    {
    	$this->hasMany('\App\Entree');
    }
}
