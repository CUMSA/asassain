<h1>Missions</h1>

<p>When you have killed a target, enter his/her password to confirm the kill. Write a mission report and be eligible to win <?php echo $this->Html->link('prizes', array('gm' => false, 'controller' => 'pages', 'action' => 'display', 'rules', '#' => 'prizes')); ?>.

<?php
if ( count($missions) == 0 ) {
	echo '<p>You have no missions for now.</p>';
}
?>

<?php foreach ($missions as $mission): ?>
<table class="mission">
	<tr>
		<td>Target</td><td><?php echo $mission['Target']['Assassin']['name']; ?></td>
		<td class="mission-right" rowspan="5">
			<?php if ( $mission['Mission']['status'] == 'Open' ): ?>
				<?php echo $this->Form->create('Mission', array('action' => 'complete')); ?>
					<fieldset>
						<legend><?php echo __('Complete mission'); ?></legend>
						<?php
							echo $this->Form->hidden('crsid', array('value' => $mission['Target']['Assassin']['crsid']));
							echo $this->Form->input('password');
							echo $this->Form->input('report', array('label' => 'Mission Report', 'type' => 'textarea'));
						?>
					</fieldset>
				<?php echo $this->Form->end(__('Submit')); ?>
			<?php else: ?>
				<?php
					echo '<p><strong>Mission Report</strong></p>';
					echo '<p>' . $mission['Mission']['report'] . '</p>';
				?>
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>CRSID</td><td><?php echo $mission['Target']['Assassin']['crsid']; ?></td></tr>
	<tr><td>College</td><td><?php echo $mission['Target']['Assassin']['college']; ?></td></tr>
	<tr><td>Course</td><td><?php echo $mission['Target']['Assassin']['course']; ?></td></tr>
	<tr><td>Mission Status</td><td><?php echo $mission['Mission']['status']; ?></td></tr>
</table>
<?php endforeach; ?>
<?php unset($mission); ?>
