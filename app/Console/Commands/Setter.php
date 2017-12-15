<?php 

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;

class Setter
{
	
	function __construct()
	{
		$this->roles_conversion();

		try
		{
		   	$this->back = DB::connection('mysql')->getPdo();
		    $this->back->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		}
		catch (Exception $e)
		{
		    die('Erreur : ' . $e->getMessage());
		}
	}


	public function options_from_db($get)
	{
		$options = array(
			//WP 						=> Laravel
			"bonus-max" 				=> "bonus-max",
			"bonus-config-type" 		=> "bonus-unite",
			"bonus-config-remise" 		=> "bonus-remise",
			"bonus-config-affichage"	=> "bonus-affichage",
			"bonus-config-demibonus" 	=> "bonus-demi-valeur",
			"compter-pieces" 			=> "compta-compter-pieces",
			"arrondir-curseur" 			=> "compta-arrondir-curseur",
			"delai-expiration" 			=> "delai-expiration",
			// "delai-suppression" 		=> "delai-suppression",
			"delai-services" 			=> "delai-services",
			"panic" 					=> "panic"
		);
		foreach ($options as $old_key => $new_key) {
		    $value = $get->option_by_name($old_key);
		    if ($value=="") continue;
			$sql="
			INSERT INTO
				options (`key`, `value`)
			VALUES
				(:key, :value)
			";
			$stmt = $this->back->prepare($sql);

		    $stmt->bindParam(':key', 	$new_key);
		    $stmt->bindParam(':value', 	$value);

		    $stmt->execute();
		}
	}

	public function options_from_config()
	{
		$options = array(
			"panic_to" => constant("PANIC"),

			"compta_par_dix" => constant("COMPTA_DILLENS"), // compta par 10 jours au lieu par lundi
			"recap_franz" => constant("RECAP_FRANZ"), // résumé mensuel de XavierSDry et Sophie CSS
			"gerants_bilan" => constant("ACCESS_GERANT_BILAN"),

			"nom_service_soir" => constant("NOM_SERVICE_SOIR"),
			"nom_role_bar" => constant("NOM_ROLE_BAR"),
			"debut_journee" => constant("DEBUT"),
			"debut_transition" => constant("TRANSITION"),
			"equipe_min" => constant("EKIP_MINIMUM"),
			"equipe_max" => constant("EKIP_MAXIMUM"),

			"module_bonus" => constant("BONUS"),
			"module_paye_cheques" => constant("PAYE_EN_CHEQUES_REPAS"),
			"module_coffre" => constant("MODULE_COFFRE"),
			"module_impayes" => constant("IMPAYES"),
			"module_tickets" => constant("JETONS"),
			"module_jetons" => constant("JETONS"), //?
			"module_afacturer" => constant("AFACTURER"),
			"module_fdc" => constant("FONDDECOFFRE")
		);
		foreach ($options as $new_key => $value) {
			$sql="
			INSERT INTO
				options (`key`, `value`)
			VALUES
				(:key, :value)
			";
			$stmt = $this->back->prepare($sql);

		    $stmt->bindParam(':key', 	$new_key);
		    $stmt->bindParam(':value', 	$value);

		    $stmt->execute();
		}
	}

	public function types_comments()
	{
		foreach ($GLOBALS['REMARQUES'] as $r_id => $r_name) {

			$sql = "
			INSERT INTO
				comment_types (name)
			VALUES
				(:name)
			;";
			$stmt = $this->back->prepare($sql);

			$stmt->bindParam( ':name', $name );
			$name = $this->strOrNull($r_name);

			$stmt->execute();
		}
	}

	public function types_sorties()
	{
		foreach ($GLOBALS['SORTIES'] as $sortie_type) {
			$sql = "
			INSERT INTO
				sortie_types (name, type, options, old_id)
			VALUES
				(:name, :type, :options, :old_id);
			";
			$stmt = $this->back->prepare($sql);

			$stmt->bindParam( ':name',		$name, 		\PDO::PARAM_STR);
			$stmt->bindParam( ':type',		$type,		\PDO::PARAM_STR);
			$stmt->bindParam( ':options',	$options,	\PDO::PARAM_STR);
			$stmt->bindParam( ':old_id',	$old_id,	\PDO::PARAM_STR);

			$name =			$this->strOrNull($sortie_type['text']);
			$type =			$this->strOrNull($sortie_type['type']);
			$options =		$this->strOrNull($sortie_type['options']);
			$old_id =		$this->strOrNull($sortie_type['id']);

			$stmt->execute();
		}
	}

	public function types_tickets()
	{
		foreach ($GLOBALS['TICKETS'] as $ticket) {
			$sql = "
			INSERT INTO
				ticket_types (name, factor)
			VALUES
				(:name, :factor)
			;";
			$stmt = $this->back->prepare($sql);

			$stmt->bindParam( ':name', $name );
			$stmt->bindParam( ':factor', $factor );

			$name = $this->strOrNull($ticket['text']);
			$factor = $this->floatOrNull($ticket['value']);

			$stmt->execute();
		}
	}

	public function bonus($get, $bar)
	{
		$types_service = array(
			'journee', 'brunch','soirsemaine','soirweekend'
		);
		$min = EKIP_MINIMUM;
		$max = EKIP_MAXIMUM;

		foreach ($types_service as $type) {
			for ($nb=$min; $nb <= $max; $nb++) { 
		    	$sql="
				INSERT INTO
					bonuses (taille_equipe, seuil_initial, bonus_initial, paliers_suivants, supplement, concerne, actif, type_de_service, created_at, updated_at)
				VALUES
					(:taille_equipe, :seuil_initial, :bonus_initial, :paliers_suivants, :supplement, 'bar,cuisine', 1, :type_de_service, NOW(), NOW())
		    	";
		    	$stmt = $this->back->prepare($sql);

			    $stmt->bindParam(':taille_equipe', 		$nb);
			    $stmt->bindParam(':seuil_initial', 		$seuil_i);
			    $stmt->bindParam(':bonus_initial', 		$bonus_i);
			    $stmt->bindParam(':paliers_suivants', 	$paliers);
			    $stmt->bindParam(':supplement',			$supp);
			    $stmt->bindParam(':type_de_service', 	$type);

		    	$seuil_i 	= $this->intOrNull($get->option_by_name("bonus-".$type."-seuil-".$nb));
		    	$bonus_i 	= $this->floatOrNull($get->option_by_name("bonus-".$type."-initial-".$nb));
		    	$paliers 	= $this->intOrNull($get->option_by_name("bonus-".$type."-palier-".$nb));
		    	$supp 		= $this->floatOrNull($get->option_by_name("bonus-".$type."-supplement-".$nb));
		    	
		    	if (empty($seuil_i)) continue;

			    $stmt->execute();
            	$bar->advance();

		    }
		}
	}


	public function users($user)
	{
		$sql =
		"
		INSERT INTO
			users (id, fullname, username, password, taux_horaire, fixe, created_at, updated_at)
		VALUES
			(:id, :fullname, :username, :password, :taux_horaire, :fixe, :created_at, NOW())
		";
		$stmt = $this->back->prepare($sql);

		$stmt->bindParam( ':id',			$id, 			\PDO::PARAM_INT);
		$stmt->bindParam( ':fullname',		$fullname,		\PDO::PARAM_STR);
		$stmt->bindParam( ':username',		$username,		\PDO::PARAM_STR);//unique
		$stmt->bindParam( ':password',		$password,		\PDO::PARAM_STR);
		$stmt->bindParam( ':taux_horaire',	$taux_horaire );
		$stmt->bindParam( ':fixe',			$fixe);
		$stmt->bindParam( ':created_at',	$created);


		$id =			$this->intOrNull($user->ID);
		$fullname =		$this->strOrNull($user->display_name);
		$username =		$this->strOrNull($this->makeUniqueUsername($user->user_login));
		$password =		$this->strOrNull($user->user_pass);
		$taux_horaire =	$this->floatOrNull($user->taux_horaire);
		$fixe = 		$this->floatOrNull($user->fixe);
		$created = 		$user->user_registered;

		$stmt->execute();


		
	}

	public function role_user($user)
	{
		$champ = DB_PREFIX."_capabilities";
		foreach ($user->$champ as $role => $v) {
			if (isset($this->roles[$role])) { // Si l'user a un role equivalent
				$sql = "
				INSERT INTO
					role_user (role_id, user_id)
				VALUES
					(:role_id, :user_id);
				";
				$stmt = $this->back->prepare($sql);

				$stmt->bindParam( ':role_id',	$role_id );
				$stmt->bindParam( ':user_id',	$user_id);

				$role_id = $this->intOrNull($this->roles[$role]['id']);
				$user_id = $this->intOrNull($user->ID);

				$stmt->execute();
			}
		}
	}

	public function horaires($horaire)
	{
        if (empty($horaire->meta_value['forfait'])&&empty($horaire->meta_value['debut'])) {
            return;
        }
        $sql =  "
        INSERT INTO
            horaires (service_id, user_id, role, debut, fin, taux, prestation, created_at, updated_at)
        VALUES
            (:service_id, :user_id, :role, :debut, :fin, :taux, :prestation, :created_at, NOW());
        ";
        $stmt = $this->back->prepare($sql);

        $stmt->bindParam(':service_id',     $service_id,	\PDO::PARAM_INT);
        $stmt->bindParam(':user_id',        $user_id,		\PDO::PARAM_INT);
        $stmt->bindParam(':role',           $role,			\PDO::PARAM_INT);
        $stmt->bindParam(':debut',          $debut,			\PDO::PARAM_STR);
        $stmt->bindParam(':fin',            $fin,			\PDO::PARAM_STR);
        $stmt->bindParam(':taux',           $taux);
        $stmt->bindParam(':prestation',     $prestation);
        $stmt->bindParam(':created_at',     $created);

        $service_id = intval($horaire->ID);
        $role       = $this->intOrNull($this->getRoleID($horaire->meta_value['role']));
        $debut      = $this->strOrNull($horaire->meta_value['debut']);
        $fin        = $this->strOrNull($horaire->meta_value['fin']);
        $prestation = $this->floatOrNull(isset($horaire->meta_value['forfait'])?$horaire->meta_value['forfait']:null);
        $taux       = $this->floatOrNull(isset($horaire->meta_value['th'])?$horaire->meta_value['th']:null);
        $created    = $horaire->post_date;

        if ($this->inDB($horaire->meta_value['ID'])) {
            $user_id = $this->intOrNull($horaire->meta_value['ID']);
        } else {
            $user_id = null;
        }

        $stmt->execute();
   	}

	public function horaires_en_vrac($horaires)
	{
        if (isset($horaire->meta_value['delete'])) return;
    	$sql = 	"
    	INSERT INTO
    		horaires (service_id, user_id, role, debut, fin, `by`, created_at, updated_at)
    	VALUES
    		(:service_id, :user_id, :role, :debut, :fin, :by, :created_at, NOW());
    	";
    	$stmt = $this->back->prepare($sql);

        $stmt->bindParam(':service_id', 	$service_id,	\PDO::PARAM_INT);
        $stmt->bindParam(':user_id', 		$user_id,		\PDO::PARAM_INT);
        $stmt->bindParam(':role', 			$role,			\PDO::PARAM_INT);
        $stmt->bindParam(':debut', 			$debut,			\PDO::PARAM_STR);
        $stmt->bindParam(':fin', 			$fin,			\PDO::PARAM_STR);
        $stmt->bindParam(':by',             $by,			\PDO::PARAM_INT);
        $stmt->bindParam(':created_at',     $created);

        $service_id	= intval($horaire->ID);
        $role 		= $this->intOrNull($this->getRoleID($horaire->meta_value['role']));
        $debut 		= $this->strOrNull($horaire->meta_value['debut']);
        $fin 		= $this->strOrNull($horaire->meta_value['fin']);
        $created    = $horaire->post_date;

        if ($this->inDB($horaire->meta_value['ID'])) {
        	$user_id = $this->intOrNull($horaire->meta_value['ID']);
        } else {
        	$user_id = null;
        }
        if (isset($horaire->meta_value['qui'])&&$this->inDB($horaire->meta_value['qui'])) {
       		$by = $this->intOrNull(isset($horaire->meta_value['qui'])?$horaire->meta_value['qui']:null);
        } else {
        	$by = null;
        }

    	$stmt->execute();
	}

	public function coffre($coffre)
	{
		$sql="
		INSERT INTO
			coffres (qui, vrac, depenses, cents10, cents20, cents50, euro1, euro2, billet5, billet10, billet20, billet50, billet100, created_at, updated_at)
		VALUES
			(:qui, :vrac, :depenses, :cents10, :cents20, :cents50, :euro1, :euro2, :billet5, :billet10, :billet20, :billet50, :billet100, :created_at, NOW())
		";
		$stmt = $this->back->prepare($sql);

		$stmt->bindParam(':qui', 			$qui); 
		$stmt->bindParam(':vrac', 			$vrac); 
		$stmt->bindParam(':depenses', 		$depenses); 
		$stmt->bindParam(':cents10', 		$cents10); 
		$stmt->bindParam(':cents20', 		$cents20); 
		$stmt->bindParam(':cents50', 		$cents50); 
		$stmt->bindParam(':euro1', 			$euro1); 
		$stmt->bindParam(':euro2', 			$euro2); 
		$stmt->bindParam(':billet5', 		$billet5); 
		$stmt->bindParam(':billet10', 		$billet10); 
		$stmt->bindParam(':billet20', 		$billet20); 
		$stmt->bindParam(':billet50', 		$billet50); 
		$stmt->bindParam(':billet100', 		$billet100);
		$stmt->bindParam(':created_at', 	$created);


		$qui = intval($coffre->post_author); 
		$vrac = floatval($coffre->vrac); 
		$depenses = floatval($coffre->depenses); 
		$cents10 = intval($coffre->{'10cent'}); 
		$cents20 = intval($coffre->{'20cent'}); 
		$cents50 = intval($coffre->{'50cent'}); 
		$euro1 = intval($coffre->{'1euro'}); 
		$euro2 = intval($coffre->{'2euro'}); 
		$billet5 = intval($coffre->{'5euro'}); 
		$billet10 = intval($coffre->{'10euro'}); 
		$billet20 = intval($coffre->{'20euro'}); 
		$billet50 = intval($coffre->{'50euro'}); 
		$billet100 = intval($coffre->{'100euro'});
		$created = $coffre->post_date;

	    $stmt->execute();

	}

	public function impayes($impaye)
	{
		$due = ($impaye->post_status=="publish")?0:1;

		$sql="
		INSERT INTO
			impayes (client, qui, combien, due, created_at, updated_at)
		VALUES
			(:client, :qui, :combien, :due, :created_at, NOW())
		";
		$stmt = $this->back->prepare($sql);

	    $stmt->bindParam(':client', 	$client );
	    $stmt->bindParam(':qui', 		$qui );
	    $stmt->bindParam(':combien', 	$combien );
	    $stmt->bindParam(':due', 		$due );
	    $stmt->bindParam(':created_at', $create );

	    $client 	= $this->strOrNull($impaye->client);
	    $qui		= $this->intOrNull($impaye->prispar);
	    $combien	= $this->floatOrNull($impaye->combien);
	    $create		= $impaye->post_date;

	    $stmt->execute();
	}

	public function messages($message)
	{
		$sql = "
			INSERT INTO
				messages (content, actif, qui, created_at, updated_at)
			VALUES
				(:content, :actif, :qui, :created_at, NOW())
		";
		$stmt = $this->back->prepare($sql);

		$actif = $message->post_status=='trash'?0:1;

	    $stmt->bindParam(':content', 	$message->post_content);
	    $stmt->bindParam(':actif', 		$actif );
	    $stmt->bindParam(':qui', 		$message->post_author);
	    $stmt->bindParam(':created_at', $message->post_date);

		$stmt->execute();
	}

	public function notes($notes)
	{
		if ($notes){
			$sql="
			INSERT INTO
				options (`key`, `value`)
			VALUES
				('notes', :value)
			";
			$stmt = $this->back->prepare($sql);
			$stmt->bindParam(':value', 	$notes[0]->meta_value);
			$stmt->execute();
		}
	}

	public function services($service)
	{
	    $date = date('Y-m-d',$service->date_timestamp).' '.(date('a',$service->date_timestamp)=='am' ? '08:00:00' : '20:00:00');
	    $brunch = $service->date_brunch=='on'?1:0;
	    $verified = $service->verified?1:0;

	    $sql =  "INSERT INTO services (id, qui, quand, type, brunch, verified, pieces, billet5, billet10, billet20, billet50, billet100, z_service, z_jour, banque, schema_bonus, created_at, updated_at) VALUES (:id, :qui, :quand, :type, :brunch, :verified, :pieces, :billet5, :billet10, :billet20, :billet50, :billet100, :z_service, :z_jour, :banque,  NULL, :created_at, NOW());";
	    $stmt = $this->back->prepare($sql);

	    $stmt->bindParam(':id', $service->ID);
	    $stmt->bindParam(':qui', $service->date_de_id);
	    $stmt->bindParam(':quand', $date);
	    $stmt->bindParam(':type', $service->date_service);
	    $stmt->bindParam(':brunch', $brunch);
	    $stmt->bindParam(':verified', $verified);
	    $stmt->bindParam(':pieces', $pieces);
	    $stmt->bindParam(':billet5', $billet5);
	    $stmt->bindParam(':billet10', $billet10);
	    $stmt->bindParam(':billet20', $billet20);
	    $stmt->bindParam(':billet50', $billet50);
	    $stmt->bindParam(':billet100', $billet100);
	    $stmt->bindParam(':z_service', $z_service);
	    $stmt->bindParam(':z_jour', $z_jour);
	    $stmt->bindParam(':banque', $banque);
	    $stmt->bindParam(':created_at', $created);


	    $pieces =       $this->floatOrNull($service->caisse_pieces);
	    $billet5 =      $this->intOrNull($service->caisse_5euros['nb']);
	    $billet10 =     $this->intOrNull($service->caisse_10euros['nb']);
	    $billet20 =     $this->intOrNull($service->caisse_20euros['nb']);
	    $billet50 =     $this->intOrNull($service->caisse_50euros['nb']);
	    $billet100 =    $this->intOrNull($service->caisse_100euros['nb']);
	    $z_service =    $this->floatOrNull($service->pointe);
	    $z_jour =       $this->floatOrNull($service->pointe_total);
	    $banque =       $this->floatOrNull($service->banque);
	    $created =      $service->post_date;

	    $stmt->execute();
		
	}
	public function tickets($service)
	{
		foreach ($GLOBALS['TICKETS'] as $ticket) {
			if ( $service->{'tickets_'.$ticket['id']}['nb'] ) {
				$sql="
				INSERT INTO
					tickets (service_id, type, nombre, created_at, updated_at)
				VALUES
					(:service_id, :type, :nombre, :created_at, NOW())
				";

				$stmt = $this->back->prepare($sql);
				$stmt->bindParam(':service_id', $service->ID);
				$stmt->bindParam(':type', 		$type);
				$stmt->bindParam(':nombre', 	$nombre);
				$stmt->bindParam(':created_at', $created);

				$created = $service->post_date;
				$type = $ticket['id'] == "regies" ? 2 : 1;
				$nombre = $service->{'tickets_'.$ticket['id']}['nb'];

				$stmt->execute();
			}
		}
	}
	public function afacturer($service)
	{
		if (isset($service->caisse_groupe_afacturer['zero'])) unset($service->caisse_groupe_afacturer['zero']);
		if (empty($service->caisse_groupe_afacturer)) return;
		foreach ($service->caisse_groupe_afacturer as $k => $afacturer) {
			if (empty($afacturer['combien'])) return;  // Au cas où on aurait encoder une vide

			$sql = 
			"
			INSERT INTO
				afacturers (`service_id`, `desc`, `value`, `qui`,`created_at`, `updated_at`)
			VALUES
				(:service_id, :desc, :value, :qui, :created_at, NOW())
			";

			$stmt = $this->back->prepare($sql);

			$stmt->bindParam(':service_id',	$service_id,	\PDO::PARAM_INT);
			$stmt->bindParam(':desc',		$desc,			\PDO::PARAM_STR);
			$stmt->bindParam(':value',		$value);
			$stmt->bindParam(':qui',		$qui,			\PDO::PARAM_INT);
			$stmt->bindParam(':created_at',	$created);

			$service_id	= $this->intOrNull($service->ID);
			$desc		= $this->strOrNull($this->cleanStr($afacturer['quoi']));
			$value 		= $this->floatOrNull($afacturer['combien']);
			$qui 		= $this->intOrNull( isset($afacturer['qui'])?$afacturer['qui']:0 );
			$created 	= $service->post_date;

			$stmt->execute();
		}
	}
	public function sorties($service)
	{
		if (isset($service->caisse_groupe_sortie['zero'])) unset($service->caisse_groupe_sortie['zero']);
		if (empty($service->caisse_groupe_sortie)) return;
		foreach ($service->caisse_groupe_sortie as $k => $sortie) {
			if (empty($sortie['type'])) return; // Au cas où on aurait encoder une sortie vide
			if (empty($sortie['combien'])) return;  // Au cas où on aurait encoder une sortie vide
			$sql = 
			"
			INSERT INTO
				sorties (`service_id`, `type`, `desc`, `value`, `facture`, `qui`, `created_at`, `updated_at`)
			VALUES
				(:service_id, :type, :desc, :value, :facture, :qui, :created_at, NOW())
			";

			$stmt = $this->back->prepare($sql);

			$stmt->bindParam(':service_id',	$service_id,	\PDO::PARAM_INT);
			$stmt->bindParam(':type',		$type,			\PDO::PARAM_INT);
			$stmt->bindParam(':desc',		$desc,			\PDO::PARAM_STR);
			$stmt->bindParam(':value',		$value);
			$stmt->bindParam(':facture',	$facture,		\PDO::PARAM_BOOL);
			$stmt->bindParam(':qui',		$qui,			\PDO::PARAM_INT);
			$stmt->bindParam(':created_at',	$created);

			$type = $this->getSortieType($sortie['type']);

			$service_id	= $this->intOrNull($service->ID);
			$type 		= $this->intOrNull(empty($type)?null:$type->id);
			$desc		= $this->strOrNull($this->cleanStr(isset($sortie[$sortie['type']])?$sortie[$sortie['type']]:$sortie['type']));
			$value 		= $this->floatOrNull($sortie['combien']);
			$facture 	= $this->intOrNull( isset($sortie['facture_cash'])?1:0 );
			$qui 		= $this->intOrNull( isset($sortie['qui'])?$sortie['qui']:0 );
			$created 	= $service->post_date;

			$stmt->execute();
		}
	}
	public function comments($service)
	{
		foreach ($GLOBALS['REMARQUES'] as $rem_id => $rem_name) {
			if (isset($service->$rem_id)&&!empty($service->$rem_id)) {
				$type = $this->getCommentType($rem_name);
				$sql = "INSERT INTO comments (`type`, `service`, `content`, `created_at`, `updated_at`) VALUES (".$type->id.", ".$service->ID.", '". htmlentities($service->$rem_id,ENT_QUOTES) ."', '".$service->post_date."', NOW())";
				$this->back->exec($sql);
			}
		}
	}

	public function intOrNull($var)
	{
		$answer = null;
		if (isset($var)&&!empty($var)) {
			$answer = intval($var);
		}
		return $answer;
	}

	public function floatOrNull($var)
	{
		$answer = null;
		if (isset($var)&&!empty($var)) {
			$answer = floatval($var);
		}
		return $answer;
	}

	public function strOrNull($var)
	{
		$answer = null;
		if (isset($var)&&!empty($var)) {
			$answer = strval($var);
		}
		return $answer;
	}

	public function cleanStr($var)
	{
		$answer = null;
		if (isset($var)&&!empty($var)) {
			$answer = htmlentities( $var ,ENT_QUOTES);
		}
		return $answer;
	}

	public function roles_conversion()
	{
		$this->roles = array(
			"administrator" => array("id"=>1,"name"=>"admin"),
			"boss" => array("id"=>2,"name"=>"boss"),
			"respo" => array("id"=>3,"name"=>"respo"),
			"gerant" => array("id"=>4,"name"=>"gerant"),
			"bar" => array("id"=>5,"name"=>"bar"),
			"cuisine" => array("id"=>6,"name"=>"cuisine"),
			"secu" => array("id"=>7,"name"=>"secu"),
			"heure" => array("id"=>8,"name"=>"horaire"),
			"fixe" => array("id"=>9,"name"=>"fixe"),
			"prestation" => array("id"=>10,"name"=>"prestation"),
			"salarie" => array("id"=>11,"name"=>"banque"),
			"bonus" => array("id"=>12,"name"=>"hasBonus"),
			"fired" => array("id"=>13,"name"=>"fired")
		);
	}

	public function makeUniqueUsername($username){
		$isUnique = false;
		$original = $username;

		$sth = $this->back->prepare("SELECT * FROM users WHERE username = :username");
		$sth->bindParam(':username',$username);
		$sth->execute();
		$response = $sth->fetch(\PDO::FETCH_OBJ);
		
		if ($response) {
			$username .= "-2nd";
		}
		return $username;
	}

	public function getSortieType($old_id) {
		$sth = $this->back->prepare("SELECT * FROM sortie_types WHERE old_id = :old_id");
		$sth->bindParam(':old_id',$old_id);
		$sth->execute();
		$response = $sth->fetch(\PDO::FETCH_OBJ);
		return $response;
	}

	public function getCommentType($name){
		$sth = $this->back->prepare("SELECT * FROM comment_types WHERE name = :name");
		$sth->bindParam(':name',$name);
		$sth->execute();
		$response = $sth->fetch(\PDO::FETCH_OBJ);
		return $response;
	}

	public function getRoleID($name){
		$sth = $this->back->prepare("SELECT * FROM roles WHERE name = :name");
		$sth->bindParam(':name',$name);
		$sth->execute();
		$response = $sth->fetch(\PDO::FETCH_OBJ);
	    if(!$name) return false;
		return $response->id;
	}

	public function inDB($id){
		$sth = $this->back->prepare("SELECT * FROM users WHERE id = :id");
		$sth->bindParam(':id',$id);
		$sth->execute();
		$response = $sth->fetch(\PDO::FETCH_OBJ);
		return $response;
	}
}

 ?>