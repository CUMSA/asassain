<?php

class AssassinsController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('register', 'login', 'logout', 'reset'));
	}

	public function register() {
		$this->set('title_for_layout', 'Register');

		$game_id = $this->Assassin->Game->getActiveGameId();
		$active_game = $this->Assassin->Game->findById($game_id);

		if ( $active_game['Game']['status'] ) {
			$this->Session->setFlash(__('A game has already started. Registrations have been closed.'));
			return $this->redirect(array('controller' => 'games', 'action' => 'index'));
		}

		if ( $this->request->is('post') ) {
			$this->Assassin->create();

			$this->request->data['Assassin']['game_id'] = $this->Assassin->Game->getActiveGameId();
			$this->request->data['Assassin']['status'] = 1;

			if ( $this->Assassin->save($this->request->data) ) {
				$email = new CakeEmail('default');
				$email->to($this->request->data['Assassin']['crsid'] . '@cam.ac.uk');
				$email->subject('CUMSA Assassin: Registration successful');
				$message = "Assassin " . $this->request->data['Assassin']['name'] . ",\r\n\r\nYour registration as a CUMSA Assassin player has been successful. You will receive an e-mail when the game commences; check the CUMSA Assassin website for updates.\r\n\r\nGame Master";
				$email->send($message);

				$this->Session->setFlash(__('Registration successful.'));

				CakeLog::write('assassins', $this->request->data['Assassin']['crsid'] . ' registered.');

				return $this->redirect(array('action' => 'login'));
			}

			$this->Session->setFlash(__('Registration unsuccessful'));
		}
	}

	public function login() {
		$this->set('title_for_layout', 'Login');

		if ( $this->Auth->user('id') ) {
			return $this->redirect(array('controller' => 'games', 'action' => 'index'));
		}

		if ( $this->request->is('post') ) {
			if ( $this->Auth->login() ) {
				CakeLog::write('assassins', $this->Assassin->getCRSID($this->Auth->user('id')) . ' logged in.');
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('Invalid CRSID or password, try again'));
		}
	}

	public function logout() {
		$this->set('title_for_layout', 'Logout');
		CakeLog::write('assassins', $this->Assassin->getCRSID($this->Auth->user('id')) . ' logged out.');
		return $this->redirect($this->Auth->logout());
	}

	public function reset() {
		$this->set('title_for_layout', 'Reset Password');

		$game_id = $this->Assassin->Game->getActiveGameId();

		if ( $this->request->is('post') ) {
			$assassin = $this->Assassin->findByGameIdAndCrsid($game_id, $this->request->data['Assassin']['crsid']);
			if ( !$assassin ) {
				$this->Session->setFlash(__('Invalid CRSID'));
				return $this->redirect(array('action' => 'reset'));
			}

			$new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8 );

			$this->Assassin->id = $assassin['Assassin']['id'];
			$this->Assassin->saveField('password', Security::hash($new_password, 'sha256', true));

			$email = new CakeEmail('default');
			$email->to($this->request->data['Assassin']['crsid'] . '@cam.ac.uk');
			$email->subject('CUMSA Assassin: New password');
			$message = "Assassin " . $assassin['Assassin']['name'] . ",\r\n\r\nYour new password is " . $new_password . ".\r\n\r\nGame Master";
			$email->send($message);

			$this->Session->setFlash(__('Your new password has been sent to your e-mail.'));

			CakeLog::write('assassins', $this->request->data['Assassin']['crsid'] . ' reset password.');
			return $this->redirect(array('controller' => 'games', 'action' => 'index'));
		}
	}

	public function gm_all() {
		$game_id = $this->Assassin->Game->getActiveGameId();
		$this->set('title_for_layout', 'All Assassins');
		$this->set('assassins', $this->Assassin->find('all', array('conditions' => array (
								'Assassin.game_id' => $game_id
							))));
	}

	public function gm_view($id) {
		$this->set('title_for_layout', 'View Assassin');

		if ( !$id ) {
			throw new NotFoundException(__('Invalid assassin'));
		}

		$assassin = $this->Assassin->findById($id);
		$missions = $this->Assassin->Mission->findAllByAssassinId($id);

		if ( !$assassin ) {
			throw new NotFoundException(__('Invalid assassin'));
		}

		$this->set('assassin', $assassin);
		$this->set('missions', $missions);
	}

	public function gm_change() {
		$this->set('title_for_layout', 'Change Password');

		$game_id = $this->Assassin->Game->getActiveGameId();

		if ( $this->request->is('post') ) {
			$assassin = $this->Assassin->findByGameIdAndCrsid($game_id, $this->request->data['Assassin']['crsid']);
			if ( !$assassin ) {
				$this->Session->setFlash(__('Invalid CRSID'));
				return $this->redirect(array('action' => 'reset'));
			}

			$new_password = $this->request->data['Assassin']['password'];

			$this->Assassin->id = $assassin['Assassin']['id'];
			$this->Assassin->saveField('password', Security::hash($new_password, 'sha256', true));

			$this->Session->setFlash(__('Password changed for ' . $this->request->data['Assassin']['crsid'] . '.'));

			CakeLog::write('assassins', $this->request->data['Assassin']['crsid'] . ' changed password.');
			return $this->redirect(array('controller' => 'games', 'action' => 'all'));
		}
	}
}

?>
