<h1>Reset Password</h1>

<p>Enter your CRSID and your new password will be sent to you by e-mail.</p>

<?php echo $this->Form->create('Assassin'); ?>
<fieldset>
	<legend><?php echo __('Reset Password'); ?></legend>
	<?php
		echo $this->Form->input('crsid', array('label' => 'CRSID'));
	?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
