<?php
namespace App\Console\Commands;

class Fabbrica
{
	function __construct()
	{
		define("DB_PREFIX","fabbrica");
		define("PANIC","https://fr.wiktionary.org/wiki/panique");
		define("BONUS",false);
		define("CASE_POINTE",true);
		define("IMPAYES",false);
		define("NOTES",true);
		define("MESSAGES",true);
		define("BONUS_CUISINE",false);
		define("ROLE_SECU",false);
		define("SOHEIL",false);
		define("COMPTA_DILLENS", false);
		define("RECAP_FRANZ",false);
		define("POCHETTE", false);
		define("JETONS", false);
		define("DEBUT", "8:00");
		define("TRANSITION", "17:00");
		define("AFACTURER", true);
		define("FONDDECOFFRE", true);
		define("NOM_SERVICE_SOIR", 'Event');
		define("NOM_ROLE_BAR", 'Salle');
		define("RESPO_ACCES_EKIP", true);
		define("SALAIRES_EN_VRAC", true);
		define("MODULES_SOUCHES", true);
		define("PAYE_EN_CHEQUES_REPAS", false);
		define("MODULE_COFFRE", false);
		define("ACCESS_GERANT_BILAN", false);
		define("EKIP_MINIMUM", 0);
		define("EKIP_MAXIMUM", 0);

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
				'id'			=> 'courses',
				'text'			=> 'Courses',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'taxi',
				'text'			=> 'Taxi',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'offerts',
				'text'			=> 'Offerts',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'rpi',
				'text'			=> 'RPIs',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'fleurs',
				'text'			=> 'Fleurs',
				'type'			=> 'none',
				'options'		=> '',
			),
			array(
				'id'			=> 'autre',
				'text'			=> 'Autre',
				'type'			=> 'text',
				'options'		=> '',
			),
		);

		$GLOBALS['PLASTIQUES'] = array(
			'cartes1'		=>	'Cartes',
			'chequesrepas'	=>	'Chèques-repas',
		);


		$GLOBALS['REMARQUES'] = array();
	}

}
	?>
