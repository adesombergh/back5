<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    public function calcBonus($chiffre)
    {
		if ($chiffre >= $this->seuil_initial){
			if (!empty($this->paliers_suivants)){
				$value = floatval($this->bonus_initial + floor(($chiffre-$this->seuil_initial)/$this->paliers_suivants)*$this->supplement);
			} else {
				$value = floatval($this->bonus_initial);
			}
		} else {
			$value =  0;
		}
		return $value;
    }
}
