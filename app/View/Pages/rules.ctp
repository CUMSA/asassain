<h1>Rules</h1>

<ol>
	<li><?php echo $this->Html->link('Game Characters', '#game_characters') ?></li>
	<li><?php echo $this->Html->link('Game Play', '#game_play') ?></li>
	<ol>
		<li><?php echo $this->Html->link('Killing Your Target', '#killing_target') ?></li>
		<li><?php echo $this->Html->link('Invalidating a Kill', '#invalidate_kill') ?></li>
		<li><?php echo $this->Html->link('After the Kill', '#after_kill') ?></li>
		<li><?php echo $this->Html->link('Target Forgets Password', '#forget_password') ?></li>
	</ol>
	<li><?php echo $this->Html->link('Registration', '#registration') ?></li>
	<li><?php echo $this->Html->link('Prizes', '#prizes') ?></li>
	<li><?php echo $this->Html->link('Feedback and Enquiries', '#feedback') ?></li>
</ol>

<h2 id="game_characters">Game Characters</h2>

<ul>
	<li><u>Game Master</u>. The Game Master oversees the game, decides the rules, regulates the game, sends e-mails, and has the undisputable final say. He is contactable at <u>gamemaster@assassin.cumsa.org</u>.</li>
	<li><u>Players</u>. You.</li>
	<li><u>Community Members</u>. All CUMSA members.</li>
</ul>

<h2 id="game_play">Game Play</h2>

<p>Any player who is alive will have a target to assassinate. At the same time, he/she is also a target of another player. All players are arranged in a cyclic order; the objective is to kill all the other players along the cycle. A four-player game is as follows:</p>

<blockquote>
<pre>
A --> B
^     |
|     |
|     v
D <-- C

A hunts B, B seeks C, C hounds D, D pursues A.
</pre>
</blockquote>

<p>A player who is alive will have a <u>mission</u> telling him/her whom to kill. The mission contains the target's name and college. Once the mission is complete (i.e. the target is killed), a new mission will be assigned to kill the target's target... the last assassin alive wins the game.</p>

<h3 id="killing_target">Killing Your Target</h3>

<p>To kill your target, say to him/her <em>"CUMSA Assassin, you're dead"</em>, subject to the following constraints:</p>

<ol>
	<li>There must be no other Community Members (refer to "Game Characters" for who Community Members are), whether dead or alive, <u>within sight</u>.</li>
	</li>If an assassination takes place within sight of a Community Member, the target and/or the Community Member(s) can <u>invalidate</u> the kill.</li>
	<li>Throughout the game, you may NOT:
		<ol>
			<li>break any Cambridge University, college, United Kingdom etc. laws, rules or regulations,
			<li>use physical force,
			<li>play unfairly - surrender your password once you've been killed,
			<li>kill during your lecture, practical or supervision, and when your victim is in a lecture, practical or supervision.</li>
		</ol>
	</li>
</ol>

<h3 id="invalidate_kill">Invalidating a Kill</h3>

<p>A Community Member who "witnesses" a kill can save the target. A Community Member does not have to directly see the kill; as long as the target can point out a Community Member in sight, the Community Member can be considered a witness.</p>

<h3 id="after_kill">After the Kill</h3>

<p>Your target must give you his/her password, which you use to complete your mission and obtain your next one.</p>

<p>Players who are killed are out of the game.</p>

<h3 id="forget_password">Target Forgets Password</h3>

<p>If your target forgets his/her password upon being killed, inform him/her to obtain a new password <?php echo $this->Html->link('here', array('gm' => false, 'controller'=>'assassins', 'action'=>'reset')); ?> and subsequently provide it to you. For added measure, you may want your target to sign a piece of paper to agree that he/she was killed, and pass this paper to the Game Master.</p>

<h2 id="prizes">Prizes</h2>

<p>When the game is over, the following prizes will be given:</p>

<ul>
	<li><u>Winner</u>. The last assassin standing.</li>
	<li><u>Most Kills</u>. The assassin with the most kills.</li>
	<li><u>Most Creative Kill</u>. The assassin with the most creative kill, judged by the CUMSA committee.</li>
</ul>

<h2 id="registration">Registration</h2>

<p>The game will commence on <u>0000H 08 Nov 2014</u>. From now till 07 Nov, you may register <?php echo $this->Html->link('here', array('gm' => false, 'controller' => 'assassins', 'action' => 'register')); ?>. No registrations will be entertained once the game has started. Registration is open to all CUMSA members.</p>

<h2 id="feedback">Feedback and Enquiries</h2>

<p>If you have any feedback or enquiries, contact the Game Master at <u>gamemaster@assassin.cumsa.org</u>.</p>
