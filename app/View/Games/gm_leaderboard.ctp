<h1>Leaderboard</h1>

<table>
	<tr>
		<th>id</th>
		<th>name</th>
		<th>course</th>
		<th>college</th>
		<th>status</th>
		<th>kills</th>
	</tr>

	<?php foreach ($assassins as $assassin): ?>
	<tr>
		<td><?php echo $assassin['Assassin']['id']; ?></td>
		<td><?php echo $assassin['Assassin']['name']; ?></td>
		<td><?php echo $assassin['Assassin']['course']; ?></td>
		<td><?php echo $assassin['Assassin']['college']; ?></td>
		<td>
			<?php
				if ( $assassin['Assassin']['status'] ) {
					echo 'Alive';
				} else {
					echo 'Dead';
				}
			?>
		</td>
		<td><?php echo $assassin['Assassin']['kills']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php unset($assassin); ?>
</table>
