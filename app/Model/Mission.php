<?php

class Mission extends AppModel {
	public $belongsTo = array('Game', 'Assassin');

	public function add($assassin_id, $target_id, $game_id = NULL) {
		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$this->create();

		$save_data = array('Mission' => array(
				'game_id' => $game_id,
				'assassin_id' => $assassin_id,
				'target_id' => $target_id,
				'status' => 'Open'
				));

		$this->save($save_data);
		CakeLog::write('missions', $this->Assassin->getCRSID($assassin_id) . ' assigned to kill ' . $this->Assassin->getCRSID($target_id));
	}
}

?>
