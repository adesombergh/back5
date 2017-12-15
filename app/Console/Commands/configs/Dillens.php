<?php
namespace App\Console\Commands;
class Dillens
{
	function __construct()
	{
		define("DB_PREFIX","le_dillens");
		define("PANIC","https://www.ledillens.be");
		define("BONUS", true);
		define("CASE_POINTE", true);
		define("IMPAYES", false);
		define("BONUS_CUISINE",true);
		define("ROLE_SECU",false);
		define("COMPTA_DILLENS",true);
		define("RECAP_FRANZ",false);
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
		define("EKIP_MINIMUM", 2);
		define("EKIP_MAXIMUM", 5);
		define("ACCESS_GERANT_BILAN", false);

		$GLOBALS['SORTIES'] = array(
			array(
				'id'			=> 'avance',
				'text'			=> 'Avance',
				'type'			=> 'select',
				'options'		=> 'liste_all',
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
				'id'			=> 'divers',
				'text'			=> 'Divers',
				'type'			=> 'text',
				'options'		=> '',
			),
			array(
				'id'			=> 'concert',
				'text'			=> 'Concert',
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
			'visa'			=>	'Visa',
			'mastercard'	=>	'MasterCard',
			'bancontact'	=>	'Bancontact',
			'chequesrepas'	=>	'Chèques-repas',
		);

		$GLOBALS['CBs'] = array(
			'visa',
			'mastercard',
			'bancontact',
		);

		$GLOBALS['REMARQUES'] = array(
			'caisse_infodj'		=>	'DJ',
			'caisse_infocq'		=>	'Sécu',
			'caisse_infoall'		=>	'Divers',
		);
		
	}
}


	?>