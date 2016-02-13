<?php

class Assassin extends AppModel {
	public $hasMany = array('Mission');
	public $belongsTo = array('Game');

	public $validate = array(
		'crsid' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'A CRSID is required.'
				),
			'unique' => array(
				'rule' => 'checkCRSIDDuplicate',
				'message' => 'This CRSID has already been registered.'
				)
			),
		'password' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'A password is required.'
				)
			)
		);

	public function checkCRSIDDuplicate($check) {
		$existing = $this->findAllByCrsid($check);
		return !$existing;
	}

	public function beforeSave($options = array()) {
		if ( !$this->id ) {
			$this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha256', true);
		}
		return true;
	}

	public function getCRSID($id) {
		$assassin = $this->findById($id);
		return $assassin['Assassin']['crsid'];
	}

	public function getStatus($id) {
		$assassin = $this->findById($id);
		return $assassin['Assassin']['status'];
	}

	public function getCurrentMission($id) {
		$current_mission = $this->Mission->findByAssassinIdAndStatus($id, 'Open');
		return $current_mission;
	}

	public function getNextTargetId($id) {
		$current_mission = $this->getCurrentMission($id);
		$target_id = $current_mission['Mission']['target_id'];

		if ( $this->getStatus($target_id) ) {
			return $target_id;
		} else {
			return $this->getNextTargetId($target_id);
		}
	}
}

?>
