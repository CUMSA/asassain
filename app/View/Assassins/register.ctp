<h1>Register</h1>

<p>Registration commences on <u>02 Nov 2014</u> and ends <u>2359H 07 Nov 2014</u>.</p>

<p><strong>NOTE</strong>: The password is an element of the game (you have to reveal it when you get killed), so please do not use passwords similar to those of your e-mail accounts etc.</p>

<?php echo $this->Form->create('Assassin'); ?>
<fieldset>
	<legend><?php echo __('Register'); ?></legend>
	<?php
		echo $this->Form->input('crsid', array('label' => 'CRSID'));
		echo $this->Form->input('password');
		echo $this->Form->input('name', array('label' => 'Name (first and last)'));
		echo $this->Form->input('college');
		echo $this->Form->input('course');
	?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
