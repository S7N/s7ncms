<div>
	<?php echo form::open(); ?>
	<table>
	
		<tr>
			<td>
				<label for="user">Username</label>
			</td>
			<td>
				<?php echo form::input('user', $form['user']) ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="password">Password</label>
			</td>
			<td>
				<?php echo form::password('password', $form['password']) ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="host">Hostname</label>
			</td>
			<td>
				<?php echo form::input('host', $form['host']) ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="database">Database</label>
			</td>
			<td>
				<?php echo form::input('database', $form['database']) ?>
			</td>
		</tr>	
	</table>
	<?php echo form::submit('submit', 'OK') ?>
	<?php echo form::close() ?>
</div>