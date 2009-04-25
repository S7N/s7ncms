<div class="database">
	<?php echo form::open(); ?>
	<table>
	
		<tr>
			<td>
				<label for="user">Username</label>
			</td>
			<td>
				<?php echo form::input('user') ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="password">Password</label>
			</td>
			<td>
				<?php echo form::password('password') ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="host">Hostname</label>
			</td>
			<td>
				<?php echo form::input('host') ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="dbname">Database</label>
			</td>
			<td>
				<?php echo form::input('dbname') ?>
			</td>
		</tr>	
	</table>
	<?php echo form::submit('submit', 'Check') ?>
	<?php echo form::close() ?>
</div>