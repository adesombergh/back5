<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{

    protected $fillable = ['amount','service_id'];

    public function sorties()
    {
    	return $this->hasMany('\App\Sortie');
    }

    public function entrees()
    {
        return $this->hasMany('\App\Entree');
    }

    public function service()
    {
    	return $this->belongsTo('\App\Service');
    }

    public function chiffre()
    {
    	$sorties = $this->totalSorties();
        $entrees = $this->totalEntrees();
    	$total = $sorties + $entrees;
    	return $total;
    }

    public function totalSorties()
    {
    	return $this->sorties->sum('value');
    }

    public function totalEntrees()
    {
        $total = 0;
        foreach ($this->entrees as $entree) {
            $total += ($entree->getType()->facteur * $entree->value);
        }
        return $total;
    }

    public function getAvances()
    {
        return $this->sorties->where('type', \App\SortieType::where('name','Avance')->get()->first()->id );
    }
}
