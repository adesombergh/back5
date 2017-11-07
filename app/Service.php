<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Service extends Model
{
    protected $fillable = ['qui','quand'];

    public function bonus_schema()
    {
    	return $this->belongsTo('\App\Bonus','schema_bonus');
    }

    public function caisse()
    {
    	return $this->hasOne('\App\Caisse');
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

    public function user()
    {
    	return $this->belongsTo('\App\User','qui');
    }

    public function comments()
    {
    	return $this->hasMany('\App\Comment','service');
    }

	public function getStatusAttribute()
	{
		$status = 0;
		if( $this->horaires()->count() && $this->caisse->chiffre()){
			$status = 3;
		} elseif ( !$this->horaires()->count() && $this->caisse->chiffre()) {
			$status = 2;
		} elseif ( $this->horaires()->count() && !$this->caisse->chiffre()) {
			$status = 1;
		} 
	    return $status;
	}

	public function getEtatAttribute()
	{
		if( $this->horaires()->count() && $this->caisse->chiffre()){
			$etat = "Fini";
		} elseif ( !$this->horaires()->count() && $this->caisse->chiffre()) {
			$etat = "Caisse Complète, Horaires Incomplets";
		} elseif ( $this->horaires()->count() && !$this->caisse->chiffre()) {
			$etat = "Caisse Incomplète, Horaires Complets";
		} else{
			$etat = "Vide";
		}
	    return $etat;
	}

	public function getPrettyDateAttribute()
	{
		$date = new Date($this->quand);
	    return ucfirst($date->format('D., j M'));
	}

	public function getDateAttribute()
	{
		$date = new Date($this->quand);
	    return ucfirst($date->format('j/m'));
	}

	public function getDateTypeAttribute()
	{
		if (strpos($this->quand,"08:00:00")) {
			return "jour";
		}
	    return "soir";
	}

	public function getServiceTypeAttribute()
	{
		$date = new Date($this->quand);
		$weekday = $date->format('N');

		$suffix = 'semaine';
		if ($this->date_type == "soir") {
			if ($weekday == 5 || $weekday == 6) {
				$suffix = 'weekend';
			}
		} else {
			if ($weekday == 6 || $weekday == 7) {
				$suffix = 'weekend';
			}
		}
		return $this->date_type.$suffix;
	}

	public function getFiniAttribute()
	{
		return ($this->horaires()->count() && $this->caisse->chiffre());
	}

	public function storeSchemaBonus($b_id)
	{
		$this->schema_bonus = $b_id;
		$this->save();
	}

	public function calcBonus()
	{
		return $this->bonus_schema->calcBonus( $this->caisse->chiffre() );
	}


}
