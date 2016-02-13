<h1>All Games</h1>

<p><?php echo $this->Html->link('View All Assassins', array('controller' => 'assassins', 'action' => 'all')); ?></p>
<p><?php echo $this->Html->link('View All Missions', array('controller' => 'missions', 'action' => 'all')); ?></p>
<p><?php echo $this->Html->link('Change Password', array('controller' => 'assassins', 'action' => 'change')); ?></p>

<table>
	<tr>
		<th>id</th>
		<th>title</th>
		<th>description</th>
		<th>active</th>
		<th>status</th>
		<th>modified</th>
		<th>created</th>
		<th>options</th>
	</tr>

	<?php foreach ($games as $game): ?>
	<tr>
		<td><?php echo $game['Game']['id']; ?></td>
		<td><?php echo $game['Game']['title']; ?></td>
		<td><?php echo $game['Game']['description']; ?></td>
		<td><?php echo $game['Game']['active']; ?></td>
		<td><?php echo $game['Game']['status']; ?></td>
		<td><?php echo $game['Game']['modified']; ?></td>
		<td><?php echo $game['Game']['created']; ?></td>
		<td>
			<p><?php echo $this->Form->postLink('Create Mission Cycle', array('action' => 'createMissionCycle', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Delete Mission Cycle', array('action' => 'deleteMissionCycle', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Reverse Mission Cycle', array('action' => 'reverseMissionCycle', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Print Mission Cycle', array('action' => 'printMissionCycle', $game['Game']['id'])); ?></p>
			<p><?php echo $this->Form->postLink('Open All Missions', array('action' => 'changeAllMissionStatus', 'Open', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Close All Missions (Succeed)', array('action' => 'changeAllMissionStatus', 'Success', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Close All Missions (Failed)', array('action' => 'changeAllMissionStatus', 'Failure', $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Revive All Assassins', array('action' => 'changeAllAssassinStatus', 1, $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('Kill All Assassins', array('action' => 'changeAllAssassinStatus', 0, $game['Game']['id']), array('confirm' => 'Are you sure?')); ?></p>
			<p><?php echo $this->Form->postLink('View Leaderboard', array('action' => 'leaderboard', $game['Game']['id'])); ?></p>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($game); ?>
</table>
