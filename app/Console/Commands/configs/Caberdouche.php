<?php
namespace App\Console\Commands;
class Caberdouche
{
	function __construct()
	{
		define("DB_PREFIX","cbd");
		define("PANIC","https://fr.wiktionary.org/wiki/panique");
		define("BONUS", true);
		define("CASE_POINTE", true);
		define("IMPAYES", false);
		define("BONUS_CUISINE",true);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS", false);
		define("RECAP_FRANZ",false);
		define("JETONS", false);
		define("DEBUT", "8:00");
		define("TRANSITION", "17:00");
		define("AFACTURER", true);
		define("FONDDECOFFRE", false);
		define("NOM_SERVICE_SOIR", 'Soir');
		define("NOM_ROLE_BAR", 'Bar');
		define("RESPO_ACCES_EKIP", false);
		define("SALAIRES_EN_VRAC", false);
		define("PAYE_EN_CHEQUES_REPAS", false);
		define("MODULE_COFFRE", false);
		define("EKIP_MINIMUM", 3);
		define("EKIP_MAXIMUM", 6);
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
				'type'			=> 'select',
				'options'		=> 'liste_cq',
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
				'id'			=> 'courses',
				'text'			=> 'Courses Cuisine',
				'type'			=> 'none',
				'options'		=> '',
			),
			array(
				'id'			=> 'concert',
				'text'			=> 'Concert',
				'type'			=> 'text',
				'options'		=> '',
			),
		);
		$GLOBALS['PLASTIQUES'] = array(
			'cartes1'		=>	'Cartes 1',
			'cartes2'		=>	'Cartes 2',
			'chequesrepas'	=>	'Chèques-repas',
		);

		$GLOBALS['CBs'] = array(
			'cartes1',
			'cartes2',
		);

		$GLOBALS['REMARQUES'] = array(
			'caisse_infodj'		=>	'DJ',
			'caisse_infocq'		=>	'Sécu',
			'caisse_infoall'	=>	'Divers',
		);		
	}
}
?>