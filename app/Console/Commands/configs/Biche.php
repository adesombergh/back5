<?php
namespace App\Console\Commands;

class Biche
{
	function __construct()
	{
		define("DB_PREFIX","labiche");
		define("PANIC","https://www.wikipedia.org");
		define("BONUS", true);
		define("CASE_POINTE", true);
		define("IMPAYES", false);
		define("BONUS_CUISINE",true);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS",false);
		define("RECAP_FRANZ",false);
		define("JETONS", false);
		define("DEBUT", "9:00");
		define("TRANSITION", "17:00");
		define("AFACTURER", false);
		define("FONDDECOFFRE", false);
		define("NOM_SERVICE_SOIR", 'Soir');
		define("NOM_ROLE_BAR", 'Bar');
		define("RESPO_ACCES_EKIP", false);
		define("SALAIRES_EN_VRAC", false);
		define("PAYE_EN_CHEQUES_REPAS", false);
		define("MODULE_COFFRE", false);
		define('EKIP_MINIMUM', 1);
		define('EKIP_MAXIMUM', 3);
		define("ACCESS_GERANT_BILAN", false);

		$GLOBALS['SORTIES'] = array(
			array(
				'id'			=> 'avance',
				'text'			=> 'Avance',
				'type'			=> 'select',
				'options'		=> 'liste_all',
			),
			array(
				'id'			=> 'extra_bar',
				'text'			=> 'Extra Bar',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'extra_cuisine',
				'text'			=> 'Extra Cuisine',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'divers',
				'text'			=> 'Divers',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'cq',
				'text'			=> 'Sécu',
				'type'			=> 'none',
				'options'		=> '',
			),
		);


		$GLOBALS['PLASTIQUES'] = array(
			'cartes'		=>	'Cartes',
			'chequesrepas'	=>	'Chèques-repas',
		);

		$GLOBALS['CBs'] = array(
			'cartes'
		);

		$GLOBALS['REMARQUES'] = array(
			'caisse_infodj'		=>	'DJ',
			'caisse_infocq'		=>	'Sécu',
			'caisse_infoall'		=>	'Divers',
		);
	}
}


?>