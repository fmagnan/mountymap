<?php

require_once 'LocatedObjectFactory.class.php';
require_once 'Troll.class.php';

class TrollPositionFactory extends LocatedObjectFactory {
	
	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function getDataColumnsDescr() {
		return array(
			'mise_a_jour' => 'date',
			'position_x' => 'int',
			'position_y' => 'int',
			'position_n' => 'int',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'troll_position';
	}
	
	function getInstanceClassName() {
		return 'troll';
	}
	
	function getInstancesBetweenLevels($minLevel, $maxLevel, $race, $limit=false) {
		$min_level = is_numeric($minLevel) ? intval($minLevel) : 1;
		$max_level = is_numeric($maxLevel) ? intval($maxLevel) : 80;
		if ($race) {
			$troll_races = unserialize(TROLLS_RACES);
			$race_clause = ' AND `identity`.`race`=\''.mysql_real_escape_string($troll_races[$race-1], $this->db->getLink()).'\'';
		} else {
			$race_clause = '';
		}
		$query = '	SELECT `position`.`id` FROM `'.$this->getTableName(). '` AS `position`, `troll_identity` as `identity`
					WHERE `position`.`id` = `identity`.`id` AND `identity`.`niveau` BETWEEN '.$min_level . ' AND ' . $max_level.
					$race_clause .
					' ORDER BY `identity`.`niveau`';
		if (is_numeric($limit)) {
			$query .= ' LIMIT ' . $limit;
		}
		return $this->getInstancesWithQuery($query);
	}
	
	function getDataWithPosition($start_x, $end_x, $start_y, $end_y, $start_n, $end_n) {
		$loggedInUser = getLoggedInUser();
		$diplomacy_id = $loggedInUser->getDiplomacyId();
		$query = '	SELECT 	`position`.`id`, `position`.`mise_a_jour`, `position`.`position_x`, `position`.`position_y`, `position`.`position_n`, 
							`identity`.`nom`, `identity`.`race`, `identity`.`niveau`, `identity`.`id_guilde`, `guilde`.`nom` AS `nom_guilde`
					FROM `'.$this->getTableName().'` AS `position`, `troll_identity` AS `identity` LEFT JOIN `guilde` ON
					`identity`.`id_guilde`=`guilde`.`id`
					WHERE (`position`.`position_x` BETWEEN '.intval($start_x). ' AND ' .intval($end_x). ') 
					AND (`position`.`position_y` BETWEEN '.intval($start_y). ' AND ' .intval($end_y). ')
					AND (`position`.`position_n` BETWEEN ' . intval($end_n). ' AND ' .intval($start_n) . ')
					AND `position`.`id`=`identity`.`id`';
		$trolls = $this->db->executeRequeteAvecDonneesDeRetourMultiples($query);
		foreach ($trolls as $key => $troll) {
			$diplomacy_query = 'SELECT `diplomacy`.`side` FROM `diplomacy`
				WHERE `diplomacy`.`target_type`=\'T\' AND `diplomacy`.`target_id`='.$troll['id'].' AND `diplomacy`.`id`='.$diplomacy_id;
			$side = $this->db->executeRequeteAvecDonneeDeRetourUnique($diplomacy_query, 'side');
			if ($side) {
				$trolls[$key]['side'] = $side;
			} else {
				$diplomacy_query = 'SELECT `diplomacy`.`side` FROM `diplomacy`, `troll_identity`
					WHERE `diplomacy`.`target_type`=\'G\' AND `diplomacy`.`id`='.$diplomacy_id.'
					AND `diplomacy`.`target_id`=`troll_identity`.`id_guilde` AND `troll_identity`.`id`='.$troll['id'];
				$side = $this->db->executeRequeteAvecDonneeDeRetourUnique($diplomacy_query, 'side');
				if ($side) {
					$trolls[$key]['side'] = $side;
				}
			}
		}
		return $trolls;
	}
	
	function getSearchTableHeaders() {
		return array(
			'Id' => 'getId', 'Nom' => 'getSimpleIdentity', 'Race' => 'getRace', 'Niveau' => 'getLevel', 'Guilde' => 'getGuildIdentity',
			'X' => 'getPositionX', 'Y' => 'getPositionY', 'N' => 'getPositionN', 'Date' => 'getUpdate', 'Actions' => 'getLinkToMap'
		);
	}
	
}
?>