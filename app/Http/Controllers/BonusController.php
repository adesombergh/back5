<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Service;
use \App\Bonus;

class BonusController extends Controller
{
	public function __construct(Service $service)
	{
		$this->service = $service;
	}

	public function handleBonus() 
	{
		if ($this->service->fini  && !$this->service->bonus_schema){
			if ($this->findMyBonusRow()){
				$this->service->storeSchemaBonus( $this->findMyBonusRow()->id );
			}
		}
	}

	public function findMyBonusRow()
	{
		return Bonus::where('actif','1')
			->where('type_de_service', $this->service->service_type )
			->where('taille_equipe', $this->service->horaires('bar')->count() )
			->firstOrFail();
	}

}
