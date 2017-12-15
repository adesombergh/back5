<?php
namespace App\Console\Commands;
class Bota
{
	function __construct()
	{
		define("DB_PREFIX","bota");
		define("PANIC","http://google.be");
		define("BONUS", false);
		define("CASE_POINTE", true);
		define("IMPAYES", false);
		define("BONUS_CUISINE",false);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS", false);
		define("RECAP_FRANZ",false);
		define("JETONS", true);
		define("DEBUT", "10:00");
		define("TRANSITION", "17:00");
		define("AFACTURER", true);
		define("FONDDECOFFRE", false);
		define("NOM_SERVICE_SOIR", 'Soir');
		define("NOM_ROLE_BAR", 'Bar');
		define("RESPO_ACCES_EKIP", false);
		define("SALAIRES_EN_VRAC", false);
		define("PAYE_EN_CHEQUES_REPAS", true);
		define("MODULE_COFFRE", false);
		define('EKIP_MINIMUM', 1);
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
				'id'			=> 'cq',
				'text'			=> 'Sécu',
				'type'			=> 'none',
				'options'		=> '',
			),
			array(
				'id'			=> 'dj',
				'text'			=> 'DJ',
				'type'			=> 'none',
				'options'		=> '',
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
				'id'			=> 'journaux',
				'text'			=> 'Journaux',
				'type'			=> 'none',
				'options'		=> '',
			),
		);

		$GLOBALS['PLASTIQUES'] = array(
			'cartes1'		=>	'Cartes',
			'chequesrepas'	=>	'Chèques-repas',
			'afacturer'		=>	'A facturer',
		);

		$GLOBALS['CBs'] = array(
			'cartes1',
		);

		$GLOBALS['TICKETS'] = array(
			array(
				"id"=>"artistes",
				"value"=>16.16,
				"text"=>"Artistes"
			),
			array(
				"id"=>"regies",
				"value"=>12.07,
				"text"=>"Régies"
			)
		);

	}
}
?>