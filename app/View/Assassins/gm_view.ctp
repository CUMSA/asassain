<h1>Assassin Profile</h1>

<table>
	<tr>
		<th>id</th>
		<th>game_id</th>
		<th>name</th>
		<th>crsid</th>
		<th>password</th>
		<th>college</th>
		<th>course</th>
		<th>modified</th>
		<th>created</th>
	</tr>

	<tr>
		<td><?php echo $assassin['Assassin']['id']; ?></td>
		<td><?php echo $assassin['Assassin']['game_id']; ?></td>
		<td><?php echo $assassin['Assassin']['name']; ?></td>
		<td><?php echo $assassin['Assassin']['crsid']; ?></td>
		<td><?php echo $assassin['Assassin']['password']; ?></td>
		<td><?php echo $assassin['Assassin']['college']; ?></td>
		<td><?php echo $assassin['Assassin']['course']; ?></td>
		<td><?php echo $assassin['Assassin']['modified']; ?></td>
		<td><?php echo $assassin['Assassin']['created']; ?></td>
	</tr>
</table>

<table>
	<tr>
		<th>id</th>
		<th>game_id</th>
		<th>assassin_id</th>
		<th>target_id</th>
		<th>status</th>
		<th>report</th>
		<th>modified</th>
		<th>created</th>
	</tr>

	<?php foreach ($missions as $mission): ?>
	<tr>
		<td><?php echo $mission['Mission']['id']; ?></td>
		<td><?php echo $mission['Mission']['game_id']; ?></td>
		<td><?php echo $mission['Mission']['assassin_id']; ?></td>
		<td><?php echo $mission['Mission']['target_id']; ?></td>
		<td><?php echo $mission['Mission']['status']; ?></td>
		<td><?php echo $mission['Mission']['report']; ?></td>
		<td><?php echo $mission['Mission']['modified']; ?></td>
		<td><?php echo $mission['Mission']['created']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php unset($mission); ?>
</table>
