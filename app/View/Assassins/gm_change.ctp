<h1>Change Password</h1>

<p>Enter CRSID and new password.</p>

<?php echo $this->Form->create('Assassin'); ?>
<fieldset>
	<legend><?php echo __('Change Password'); ?></legend>
	<?php
		echo $this->Form->input('crsid', array('label' => 'CRSID'));
		echo $this->Form->input('password');
	?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
