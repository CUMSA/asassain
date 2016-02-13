<?php

class MissionsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		$this->set('title_for_layout', 'Missions');

		$game_id = $this->Mission->Game->getActiveGameId();

		if ( !$game_id ) {
			$this->Session->setFlash(__('There is no active game at the moment.'));
			return $this->redirect(array('controller' => 'games', 'action' => 'index'));
		}

		if ( !$this->Mission->Assassin->getStatus($this->Auth->user('id')) ) {
			$this->Session->setFlash(__('You are already dead. Better luck next time!'));
			return $this->redirect(array('controller' => 'games', 'action' => 'index'));
		}

		$missions = $this->Mission->find('all', array(
						'conditions' => array (
							'assassin_id' => $this->Auth->user('id'),
						),
						'order' => array('Mission.modified' => 'desc')
					)
				);

		foreach ( $missions as $key => $mission ) {
			$missions[$key]['Target'] = $this->Mission->Assassin->findById($mission['Mission']['target_id']);
		}

		$this->set('missions', $missions);
	}

	public function complete() {
		$this->set('title_for_layout', 'Complete Mission');

		if ( $this->request->is('get') ) {
			throw new MethodNotAllowedException();
		}

		$game_id = $this->Mission->Game->getActiveGameId();

		if ( $this->request->is('post') ) {
			$target_crsid = $this->request->data['Mission']['crsid'];
			$target_password = $this->request->data['Mission']['password'];
			$target_password = Security::hash($target_password, 'sha256', true);
			$target_report = $this->request->data['Mission']['report'];

			$target = $this->Mission->Assassin->findByCrsidAndPassword($target_crsid, $target_password);

			$current_mission = $this->Mission->Assassin->getCurrentMission($this->Auth->user('id'));

			if ( $target ) {
				if ( $target['Assassin']['id'] === $current_mission['Mission']['target_id'] ) {
					if ( $target['Assassin']['status'] ) {
						$this->Mission->Assassin->id = $target['Assassin']['id'];
						$this->Mission->Assassin->saveField('status', 0);

						$next_target_id = $this->Mission->Assassin->getNextTargetId($this->Auth->user('id'));

						$this->Mission->id = $current_mission['Mission']['id'];
						$this->Mission->saveField('status', 'Success');
						$this->Mission->saveField('report', $target_report);

						$this->Mission->id = $this->Mission->Assassin->getCurrentMission($target['Assassin']['id']);
						$this->Mission->saveField('status', 'Failure');

						$email = new CakeEmail('default');
						$email->to($target['Assassin']['crsid'] . '@cam.ac.uk');
						$email->subject('CUMSA Assassin: Killed');
						$message = "Assassin " . $target['Assassin']['name'] . ",\r\n\r\nYou have been killed. Better luck next time!\r\n\r\nGame Master";
						$email->send($message);

						CakeLog::write('missions', $this->Mission->Assassin->getCRSID($this->Auth->user('id')) . ' killed ' . $target['Assassin']['crsid']);

						if ( $this->Auth->user('id') == $next_target_id ) {
							$this->Mission->Game->id = $game_id;
							$this->Mission->Game->saveField('status', 0);
							return $this->redirect(array('action' => 'win'));
						}

						$this->Mission->add($this->Auth->user('id'), $next_target_id);

						$this->Session->setFlash(__('Your kill has been confirmed. A new mission has been assigned to you.'));
						return $this->redirect(array('action' => 'index'));
					} else {
						throw new CakeException('Target already killed.');
					}
				} else {
					$this->Session->setFlash(__('This was not your mission.'));
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('The CRSID and password entered do not match.'));
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function win() {
		$this->set('title_for_layout', 'Victory!');

		$game_id = $this->Mission->Game->getActiveGameId();

		$survivors = $this->Mission->Assassin->findAllByGameIdAndStatus($game_id, '1');

		if ( count($survivors) == 1 && $this->Auth->user('id') == $survivors[0]['Assassin']['id'] ) {
			$this->Session->setFlash(__('Congratulations! You have won CUMSA Assassin!'));

			$email = new CakeEmail('default');
			$email->to($survivors[0]['Assassin']['crsid'] . '@cam.ac.uk');
			$email->subject('CUMSA Assassin: Victory!');
			$message = "Assassin " . $survivors[0]['Assassin']['name'] . ",\r\n\r\nYou have won CUMSA Assassin! Well done on surviving to the end.\r\n\r\nGame Master";
			$email->send($message);

			$email = new CakeEmail('default');
			$email->to('gamemaster@assassin.cumsa.org');
			$email->subject('CUMSA Assassin: End');
			$email->send($survivors[0]['Assassin']['name'] . ' has won CUMSA Assassin.');

			CakeLog::write('missions', $survivors[0]['Assassin']['name'] . ' has won CUMSA Assassin.');
		}

		return $this->redirect(array('controller' => 'games', 'action' => 'index'));
	}

	public function gm_all() {
		$game_id = $this->Mission->Game->getActiveGameId();

		$this->set('title_for_layout', 'All Missions');

		$this->set('missions', $this->Mission->find('all', array('conditions' => array (
								'Mission.game_id' => $game_id
							))));
	}
}

?>
