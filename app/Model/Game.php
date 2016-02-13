<?php

class Game extends AppModel {
	public $hasMany = array('Assassin', 'Mission');

	public function getActiveGameId() {
		$active_game = $this->findByActive('1');
		if ( $active_game ) {
			return $active_game['Game']['id'];
		} else {
			throw new CakeException('No active game found.');
		}
	}
}

?>
