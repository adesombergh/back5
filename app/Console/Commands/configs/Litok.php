<?php
namespace App\Console\Commands;

class Litok
{
	function __construct()
	{
		define("DB_PREFIX","lt");
		define("PANIC","http://google.be");
		define("BONUS", false);
		define("CASE_POINTE", true);
		define("IMPAYES", false);
		define("BONUS_CUISINE",false);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS", false);
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
		define('EKIP_MINIMUM', 2);
		define('EKIP_MAXIMUM', 6);
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
				'id'			=> 'autre',
				'text'			=> 'Autre',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'fournisseurs',
				'text'			=> 'Fournisseurs',
				'type'			=> 'text',
				'options'		=> '',
			),
		);

		$GLOBALS['PLASTIQUES'] = array(
			'cartes1'		=>	'Cartes',
			'chequesrepas'	=>	'Chèques-repas',
		);

		$GLOBALS['CBs'] = array(
			'cartes1',
		);

		$GLOBALS['REMARQUES'] = array();
	}

}
	?>
