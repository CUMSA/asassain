<h1>CUMSA Assassin has begun!</h1>

<div id="sticky">



</div>

<hr />

<?php foreach ($completed_missions as $mission): ?>
<div class="post">

<?php

$time = new DateTime($mission['Mission']['modified']);

echo '<p><strong>' . $time->format('Y-m-d H:i:s') . '</strong>: ' . $mission['Mission']['assassin_name'] . ' killed ' . $mission['Mission']['target_name'] . '.';

if ( $mission['Mission']['report'] != '' ) {
	echo ' The mission report:</p><blockquote>' . $mission['Mission']['report'] . '</blockquote>';
} else {
	echo '</p>';
}
?>

</div>
<?php endforeach; ?>
<?php unset($mission); ?>
