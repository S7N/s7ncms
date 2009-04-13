<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo form::open('admin/user/newuser') ?>

<div class="box">
	<h3>New User</h3>
	<div class="inside">
		<p>
		<?php
			echo form::label('username', 'User Name');
			if ( ! empty($errors['username'])) echo $errors['username'];
			echo form::input('username', $fields['username']);
		?>
		</p>
		<p>
		<?php
			echo form::label('email', 'Email');
			if ( ! empty($errors['email'])) echo $errors['email'];
			echo form::input('email', $fields['email']);
		?>
		</p>
		<p>
		<?php
			echo form::label('password', 'Password');
			if ( ! empty($errors['password'])) echo $errors['password'];
			echo form::password('password');
		?>
		</p>
		<p>
		<?php
			echo form::label('password_confirm', 'Confirm Password');
			if ( ! empty($errors['password_confirm'])) echo $errors['password_confirm'];
			echo form::password('password_confirm');
		 ?>
		 </p>
	</div>
</div>

<p><?php echo form::submit('submit', 'Save') ?></p>
<?php echo form::close() ?>

