<?php

class GamesController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('index'));
	}

	public function gm_all() {
		$this->set('title_for_layout', 'All Games');

		$this->set('games', $this->Game->find('all'));
	}

	public function gm_createMissionCycle($game_id = NULL) {
		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$assassins = $this->Game->Assassin->find('all', array(
								'conditions' => array(
									'Assassin.game_id' => $game_id
								),
								'order' => 'rand()',
								'recursive' => -1
							)
						);

		if ( !$assassins ) {
			throw new CakeException("No assassin found in active game ($game_id).");
		}

		$active_game = $this->Game->findById($game_id);

		if ( $active_game['Game']['status'] ) {
			throw new CakeException("Mission cycle has already been created before for active game ($game_id)");
		} else {
			$this->Game->id = $game_id;
			$this->Game->saveField('status', 1);
		}

		$assassin_count = count($assassins);
		$previous_assassin_id = $assassins[$assassin_count-1]['Assassin']['id'];

		for ( $i = 0; $i < $assassin_count; $i++ ) {
			$current_assassin_id = $assassins[$i]['Assassin']['id'];

			$this->Game->Mission->add($current_assassin_id, $previous_assassin_id);

			$previous_assassin_id = $current_assassin_id;
		}

		$this->Session->setFlash(__("Mission cycle created for active game ($game_id)."));
		CakeLog::write('games', "Mission cycle created for active game ($game_id).");
		return $this->redirect(array('action' => 'all'));
	}

	public function gm_deleteMissionCycle($game_id = NULL) {
		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$this->Game->Mission->deleteAll(array(
					'Mission.game_id' => $game_id
					), false);

		$this->Game->id = $game_id;
		$this->Game->saveField('status', 0);

		$this->Session->setFlash(__("Mission cycle deleted for active game ($game_id)."));
		CakeLog::write('games', "Mission cycle deleted for active game ($game_id).");
		return $this->redirect(array('action' => 'all'));
	}

	public function gm_printMissionCycle($game_id = NULL) {
		$this->set('title_for_layout', 'Mission Cycle');

		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$active_game = $this->Game->findById($game_id);

		if ( !$active_game['Game']['status'] ) {
			throw new CakeException("No mission cycle created for active game ($game_id).");
		}

		$assassin = $this->Game->Assassin->findByGameIdAndStatus($game_id, '1');

		if ( !$assassin ) {
			throw new CakeException("No assassin still alive found in active game ($game_id).");
		}

		$first_assassin_id = $assassin['Assassin']['id'];
		$cycle = '';

		do {
			$cycle .= "|<br />|<br />v<br />";
			$cycle .= $assassin['Assassin']['name'] . ' (' . $assassin['Assassin']['crsid'] . ')<br />';

			$current_mission = $this->Game->Assassin->getCurrentMission($assassin['Assassin']['id']);
			$assassin = $this->Game->Assassin->findById($current_mission['Mission']['target_id']);
		} while ( $first_assassin_id != $current_mission['Mission']['target_id'] );

		$this->set('cycle', $cycle);
	}

	public function gm_reverseMissionCycle($game_id = NULL) {
		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$active_missions = $this->Game->Mission->findAllByStatus('Open');

		foreach ( $active_missions as $active_mission ) {
			$assassin_id = $active_mission['Mission']['assassin_id'];

			$this->Game->Mission->id = $active_mission['Mission']['id'];
			$this->Game->Mission->saveField('assassin_id', $active_mission['Mission']['target_id']);
			$this->Game->Mission->saveField('target_id', $assassin_id);
		}

		$this->Session->setFlash(__("Mission cycle for active game ($game_id) reversed."));
		CakeLog::write('games', "Mission cycle for active game ($game_id) reversed.");
		return $this->redirect(array('action' => 'all'));
	}

	public function gm_changeAllAssassinStatus($status, $game_id = NULL) {
		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$assassins = $this->Game->Assassin->findAllByGameId($game_id);

		foreach ( $assassins as $assassin ) {
			$this->Game->Assassin->id = $assassin['Assassin']['id'];
			$this->Game->Assassin->saveField('status', $status);
		}

		$this->Session->setFlash(__("Status of all assassins changed to $status."));
		CakeLog::write('games', "Status of all assassins changed to $status.");
		return $this->redirect(array('action' => 'all'));
	}

	public function gm_changeAllMissionStatus($status, $game_id = NULL) {
		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		if ( !$game_id ) {
			$game_id = $this->Game->getActiveGameId();
		}

		$missions = $this->Game->Mission->findAllByGameId($game_id);

		foreach ( $missions as $mission ) {
			$this->Game->Mission->id = $mission['Mission']['id'];
			$this->Game->Mission->saveField('status', $status);
		}

		$this->Session->setFlash(__("Status of all missions changed to $status."));
		CakeLog::write('games', "Status of all missions changed to $status.");
		return $this->redirect(array('action' => 'all'));
	}

	public function gm_leaderboard($game_id) {
		$this->set('title_for_layout', 'Leaderboard');

		$assassins = $this->Game->Assassin->findAllByGameId($game_id);

		foreach ( $assassins as $key => $assassin ) {
			$kills = $this->Game->Mission->find('count', array(
							'conditions' => array(
								'Mission.game_id' => $game_id,
								'Mission.assassin_id' => $assassin['Assassin']['id'],
								'Mission.status' => 'Success'
							)
						)
					);
			$assassins[$key]['Assassin']['kills'] = $kills;
		}

		$this->set('assassins', $assassins);
	}

	public function index() {
		$game_id = $this->Game->getActiveGameId();

		$completed_missions = $this->Game->Mission->find('all', array(
							'conditions' => array (
								'Mission.game_id' => $game_id,
								'Mission.status' => 'Success'
							),
							'order' => array('Mission.modified' => 'desc')
						)
					);

		foreach ( $completed_missions as $key => $mission ) {
			$assassin = $this->Game->Assassin->findById($mission['Mission']['assassin_id']);
			$target = $this->Game->Assassin->findById($mission['Mission']['target_id']);
			$completed_missions[$key]['Mission']['assassin_name'] = $assassin['Assassin']['name'];
			$completed_missions[$key]['Mission']['target_name'] = $target['Assassin']['name'];
		}

		$this->set('completed_missions', $completed_missions);
	}
}

?>
