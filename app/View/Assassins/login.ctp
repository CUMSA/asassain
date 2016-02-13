<h1>Login</h1>

<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('Assassin'); ?>
<fieldset>
	<legend><?php echo __('Please enter your CRSID and password'); ?></legend>
	<?php
		echo $this->Form->input('crsid', array('label' => 'CRSID'));
		echo $this->Form->input('password');
	?>
</fieldset>
<?php echo $this->Form->end(__('Login')); ?>
