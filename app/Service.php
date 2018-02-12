<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Service extends Model
{
    protected $fillable = ['qui','quand'];

	/********************************************************
	 * 						RELATIONS
	 ********************************************************/
    public function bonus_schema()
    {
    	return $this->hasOne('\App\Bonus','schema_bonus');
    }

    public function sorties()
    {
    	return $this->hasMany('\App\Sortie');
	}
	
    public function tickets()
    {
    	return $this->hasMany('\App\Tickets');
	}
	
    public function user()
    {
    	return $this->belongsTo('\App\User','qui');
    }

    public function comments()
    {
    	return $this->hasMany('\App\Comment','service');
    }

    public function horaires($role = "*")
    {
    	$horaires = $this->hasMany('\App\Horaire');
    	if ($role != "*") {
    		$role = \App\Role::where('name',$role)->first()->id;
    		$horaires->where('role', $role );
    		return $horaires->get();
    	}
    	return $horaires;
    }




	/********************************************************
	 * 						GETTERS
	 ********************************************************/
	static function getServicesBetween($start,$end)
	{
		return Service::
			whereDate('quand','>=',$start)
			->whereDate('quand','<',$end)
			->get();
	}
	public function getFiniAttribute()
	{
		return ($this->horaires()->count() && $this->caisse->chiffre());
	}
	public function getAvances()
    {
        return $this->sorties->where('type', \App\SortieType::where('name','Avance')->get()->first()->id );
    }
	/********************************************************
	 * 						CALCULATIONS
	 ********************************************************/
	public function chiffre()
    {
    	$sorties = $this->totalSorties();
        $entrees = $this->totalEntrees();
        $tickets = $this->totalTickets();
    	return $sorties + $entrees;
	}
	public function totalTickets()
	{
		dd($this);
		// echo($this->tickets->count());
		die();
	}

	public function totalSorties()
    {
    	return $this->sorties->sum('value');
	}
	
    public function totalEntrees()
    {
		$entrees = [	
			'pieces' => 1,
			'billet5' => 5,
			'billet10' => 10,
			'billet20' => 20,
			'billet50' => 50,
			'billet100' => 100,
		];
		$total = 0;
		foreach ($entrees as $champ => $facteur) {
			$total += $this->$champ * $facteur;
		}
        return $total;
	}
	
	public function calcBonus()
	{
		return $this->bonus_schema->calcBonus( $this->caisse->chiffre() );
	}
	/********************************************************
	 * 						SETTERS
	 ********************************************************/
	public function storeSchemaBonus($b_id)
	{
		$this->schema_bonus = $b_id;
		$this->save();
	}
}
