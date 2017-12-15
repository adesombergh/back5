<?php
namespace App\Console\Commands;
class Franz
{
	function __construct()
	{
		define("DB_PREFIX","wor5314");
		define("PANIC","https://www.wikipedia.org");
		define("BONUS", true);
		define("CASE_POINTE", true);
		define("IMPAYES", true);
		define("BONUS_CUISINE",true);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS",false);
		define("RECAP_FRANZ",true);
		define("JETONS", false);
		define("DEBUT", "8:00");
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
		define('EKIP_MAXIMUM', 5);
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
				'id'			=> 'jazz',
				'text'			=> 'Jazz',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'clopes',
				'text'			=> 'Clopes',
				'type'			=> 'none',
				'options'		=> '',
			),
			array(
				'id'			=> 'bonus',
				'text'			=> 'Bonus',
				'type'			=> 'none',
				'options'		=> '',
			)
		);

		$GLOBALS['PLASTIQUES'] = array(
			'cartes1'		=>	'Cartes 1',
			'cartes2'		=>	'Cartes 2',
			'cartesvisa'	=>	'Visa',
			'chequesrepas'	=>	'Chèques-repas',
			'impayes'		=>	'Impayés',
			'xavier'		=>	'Xavier SD',
			'sophie'		=>	'Sophie CTS',
		);

		$GLOBALS['CBs'] = array(
			'cartes1',
			'cartes2',
			'cartesvisa',
		);

		$GLOBALS['REMARQUES'] = array(
			'caisse_infodj'		=>	'DJ',
			'caisse_infocq'		=>	'Sécu',
			'caisse_infoall'		=>	'Divers',
		);
	}
}

	?>
