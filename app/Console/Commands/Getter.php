<?php 

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;

class Getter
{
	
	function __construct()
	{
		$this->users_meta_keys();
		$this->services_meta_keys();
		try
		{
			$this->wp = DB::connection('mysql2')->getPdo();
		    $this->wp->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
		    die('Erreur : ' . $e->getMessage());
		}
	}

	public function get($sql)
	{
		$sth = $this->wp->prepare($sql);
		$sth->execute();
		$array = $sth->fetchAll(\PDO::FETCH_OBJ);
		foreach ($array as $arr_k => $arr_v) {
			foreach ($arr_v as $cle => $valeur) {
				$data = @unserialize($valeur);
				if ($valeur === 'b:0;' || $data !== false) {
					$array[$arr_k]->$cle = unserialize($valeur);
				}
			}
		}
		return $array; 
	}

	public function users_meta_keys()
	{
		$users_data_keys = array(
			'ID',
			'user_login',
			'user_pass',
			'display_name',
			'user_registered'
		);
		$users_meta_keys = array(
			'fixe',
			'taux_horaire',
			DB_PREFIX.'_capabilities'
		);

		$this->users_data = "";
		foreach ($users_data_keys as $i => $key) {
			$this->users_data .= $key.(isset($users_data_keys[$i+1])?', ':'');
		}

		$this->users_columns = "";
		foreach ($users_meta_keys as $i => $key) {
			$this->users_columns .= 'MAX(CASE WHEN `meta_key` = "'. $key .'" THEN `meta_value` END) AS `'. $key .(isset($users_meta_keys[$i+1])?'`, ':'`');
		}
	}

	public function services_meta_keys()
	{
		$services_meta_keys = array(
			'date_date',
			'date_service',
			'date_de',
			'date_de_id',
			'date_annee',
			'date_mois',
			'date_jour',
			'date_timestamp',
			'date_brunch',
			'bonus_mois_completed',
			'caisse_completed',
			'horaire_completed',
		//	'options_users',
		//	'history',
			'caisse_pieces',
			'caisse_5euros',
			'caisse_10euros',
			'caisse_20euros',
			'caisse_50euros',
			'caisse_100euros',
			'caisse_groupe_sortie',
			'caisse_groupe_afacturer',
			'caisse_grand_total',
			'caisse_total_afacturer',
			'caisse_total_cash',
			'caisse_total_non_afacturer',
			'caisse_total_sorties',
			'bonus',
			'banque',
			'pointe',
			'pointe_total',
			'verified'
		);
		foreach ($GLOBALS['PLASTIQUES'] as $plastique_id => $value) {
			$services_meta_keys[] = "caisse_p_".$plastique_id;
		}
		if (isset($GLOBALS['REMARQUES'])) {
			foreach ($GLOBALS['REMARQUES'] as $remarque_id => $value) {
				$services_meta_keys[] = $remarque_id;
			}
		}
		if (isset($GLOBALS['TICKETS'])) {
			foreach ($GLOBALS['TICKETS'] as $ticket) {
				$services_meta_keys[] = "tickets_".$ticket['id'];
			}
		}


		$this->services_columns = "";
		foreach ($services_meta_keys as $i => $key) {
			$this->services_columns .=
			'MAX(CASE WHEN `meta_key` = "'. $key .'" THEN `meta_value` END) AS `'. $key .(isset($services_meta_keys[$i+1])?'`, ':'`');
		}

		$this->services_data = 'ID, post_date';
	}

	public function users()
	{
		$sql = "
			SELECT 
				$this->users_data, $this->users_columns
			FROM
				`".USERS_TABLE."` u
			INNER JOIN
				`".USERMETA_TABLE."` m
					ON 
				u.ID = m.user_id
			GROUP BY
				u.ID
		";
		return $this->get($sql);
	}

	public function messages()
	{
		$sql = "
			SELECT 
				*
			FROM
				`".POSTS_TABLE."` p
			WHERE
				post_type = 'post' AND post_status != 'auto-draft'
		";
		return $this->get($sql);
	}

	public function coffre()
	{
		$sql = "
			SELECT
				p.ID,
				p.post_author,
				p.post_date,
				MAX(CASE WHEN m.meta_key = '10cent' THEN m.meta_value END) AS `10cent`,
				MAX(CASE WHEN m.meta_key = '20cent' THEN m.meta_value END) AS `20cent`,
				MAX(CASE WHEN m.meta_key = '50cent' THEN m.meta_value END) AS `50cent`,
				MAX(CASE WHEN m.meta_key = '1euro' THEN m.meta_value END) AS `1euro`,
				MAX(CASE WHEN m.meta_key = '2euro' THEN m.meta_value END) AS `2euro`,
				MAX(CASE WHEN m.meta_key = '5euro' THEN m.meta_value END) AS `5euro`,
				MAX(CASE WHEN m.meta_key = '10euro' THEN m.meta_value END) AS `10euro`,
				MAX(CASE WHEN m.meta_key = '20euro' THEN m.meta_value END) AS `20euro`,
				MAX(CASE WHEN m.meta_key = '50euro' THEN m.meta_value END) AS `50euro`,
				MAX(CASE WHEN m.meta_key = '100euro' THEN m.meta_value END) AS `100euro`,
				MAX(CASE WHEN m.meta_key = 'vrac' THEN m.meta_value END) AS `vrac`,
				MAX(CASE WHEN m.meta_key = 'depenses' THEN m.meta_value END) AS `depenses`
			FROM
			".POSTS_TABLE." p
				INNER JOIN
					".POSTMETA_TABLE." m
					ON
					p.ID = m.post_id
			WHERE
			post_type = 'coffre'
			GROUP BY p.ID
		";
		return $this->get($sql);
	}

	public function horaires()
	{
		$sql = "
			SELECT 
				ID, post_date,  meta_key, meta_value
			FROM
				`".POSTS_TABLE."` p
			INNER JOIN
				`".POSTMETA_TABLE."` m
					ON 
				p.ID = m.post_id
			WHERE post_type = 'service' AND m.`meta_key` LIKE '%horaire%' AND m.`meta_value` LIKE '%a:%' AND Length(p.post_title) = 15
		";
		return $this->get($sql);
	}

	public function impayes()
	{
		$sql = "
			SELECT
				p.ID,
				p.post_status,
				p.post_date,
				MAX(CASE WHEN m.meta_key = 'prispar' THEN m.meta_value END) AS `prispar`,
				MAX(CASE WHEN m.meta_key = 'client' THEN m.meta_value END) AS `client`,
				MAX(CASE WHEN m.meta_key = 'combien' THEN m.meta_value END) AS `combien`
			FROM
			".POSTS_TABLE." p
				INNER JOIN
					".POSTMETA_TABLE." m
					ON
					p.ID = m.post_id
			WHERE
			post_type = 'impayes'
			GROUP BY p.ID
		";
		return $this->get($sql);
	}

	public function notes()
	{
		$sql = "
			SELECT
				m.meta_value
			FROM
				".POSTS_TABLE." p 
				INNER JOIN
					".POSTMETA_TABLE." m
				ON
				p.ID = m.`post_id`
			WHERE p.post_type = 'page' AND p.`post_title` = 'notes' AND m.`meta_key` = 'notes'
		";
		return $this->get($sql);
	}

	public function option_by_name($option_name)
	{
		$sql = "
			SELECT
				option_name, option_value
			FROM
				".OPTIONS_TABLE."
			WHERE 
				option_name = '$option_name'
		";
		$res = $this->get($sql);
		if (empty($res)) {
			return "";
		}
		return $res[0]->option_value;
	}

	public function services()
	{
		$sql = "
			SELECT 
				$this->services_data, $this->services_columns
			FROM
				`".POSTS_TABLE."` p
			INNER JOIN
				`".POSTMETA_TABLE."` m
					ON 
				p.ID = m.post_id
			WHERE
				post_type = 'service' AND Length(post_title) = 15
			GROUP BY
				p.ID
		";
		return $this->get($sql);
	}
}

 ?>