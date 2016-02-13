<h1>All Assassins</h1>

<table>
	<tr>
		<th>id</th>
		<th>game_id</th>
		<th>name</th>
		<th>crsid</th>
		<th>college</th>
		<th>course</th>
		<th>status</th>
		<th>gm</th>
		<th>modified</th>
		<th>created</th>
	</tr>

	<?php foreach ($assassins as $assassin): ?>
	<tr>
		<td><?php echo $assassin['Assassin']['id']; ?></td>
		<td><?php echo $assassin['Assassin']['game_id']; ?></td>
		<td><?php echo $assassin['Assassin']['name']; ?></td>
		<td><?php echo $assassin['Assassin']['crsid']; ?></td>
		<td><?php echo $assassin['Assassin']['college']; ?></td>
		<td><?php echo $assassin['Assassin']['course']; ?></td>
		<td><?php echo $assassin['Assassin']['status']; ?></td>
		<td><?php echo $assassin['Assassin']['gm']; ?></td>
		<td><?php echo $assassin['Assassin']['modified']; ?></td>
		<td><?php echo $assassin['Assassin']['created']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php unset($assassin); ?>
</table>
