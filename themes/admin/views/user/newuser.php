<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo form::open('admin/user/newuser') ?>

<div class="box">
	<h3><?php echo __('New user') ?></h3>
	<div class="inside">
		<p>
		<?php
			echo form::label('username', __('Username'));
			if ( ! empty($errors['username'])) echo $errors['username'];
			echo form::input('username', $fields['username']);
		?>
		</p>
		<p>
		<?php
			echo form::label('email', __('Email'));
			if ( ! empty($errors['email'])) echo $errors['email'];
			echo form::input('email', $fields['email']);
		?>
		</p>
		<p>
		<?php
			echo form::label('password', __('Password'));
			if ( ! empty($errors['password'])) echo $errors['password'];
			echo form::password('password');
		?>
		</p>
		<p>
		<?php
			echo form::label('password_confirm', __('Confirm password'));
			if ( ! empty($errors['password_confirm'])) echo $errors['password_confirm'];
			echo form::password('password_confirm');
		 ?>
		 </p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')) ?></p>
<?php echo form::close() ?>

