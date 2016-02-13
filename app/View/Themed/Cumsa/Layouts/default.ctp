<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php
			if ( $this->params['controller'] == 'games' && $this->action == 'index' ) {
				echo 'CUMSA Assassin';
			} else {
				echo $title_for_layout . ' - CUMSA Assassin';
			}
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('main');

		echo $this->fetch('meta');
		echo $this->fetch('css');

		$credentials = $this->Session->read('Auth');
		$logged_in = isset($credentials['User']);
		if ( $logged_in ) {
			$crsid = $credentials['User']['crsid'];
		}
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>
				<a href="http://assassin.cumsa.org/"><?php echo $this->Html->image('logo_assassin.png'); ?></a>
			</h1>
		</div>

		<div id="topbar">
			<?php
				if( $logged_in ) {
					$topbar_list = array(
					$this->Html->link('Home', array('gm' => false, 'controller' => 'games', 'action' => 'index')),
					$this->Html->link('Missions', array('gm' => false, 'controller' => 'missions', 'action' => 'index')),
					$this->Html->link('Rules', array('gm' => false, 'controller' => 'pages', 'action' => 'display', 'rules')),
					$this->Html->link("Logout ($crsid)", array('gm' => false, 'controller'=>'assassins', 'action'=>'logout'))
					);
				} else {
					$topbar_list = array(
					$this->Html->link('Home', array('gm' => false, 'controller' => 'games', 'action' => 'index')),
					$this->Html->link('Register', array('gm' => false, 'controller' => 'assassins', 'action' => 'register')),
					$this->Html->link('Rules', array('gm' => false, 'controller' => 'pages', 'action' => 'display', 'rules')),
					$this->Html->link("Reset Password", array('gm' => false, 'controller'=>'assassins', 'action'=>'reset')),
					$this->Html->link('Login', array('gm' => false, 'controller'=>'assassins', 'action'=>'login'))
					);
				}
				echo $this->Html->nestedList($topbar_list);
			?>
		</div>

		<div id="content">
			<?php

					echo $this->Session->flash();
			?>
			<?php echo $this->fetch('content'); ?>
		</div>

		<div id="footer">
			<?php echo $this->Html->image('assassin_speech.png'); ?>
			<p>by the <a href="http://www.cumsa.org/">Cambridge University Malaysia and Singapore Association</a></p>
			<p>Contact the Game Master at <u>gamemaster@assassin.cumsa.org</u></p>
		</div>
	</div>
</body>
</html>
