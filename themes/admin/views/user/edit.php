<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>

<div class="box">
	<h3><?php echo __('Edit user') ?></h3>
	<div class="inside">
		<p>
			<?php echo form::label($username->name, $username->label) ?>
			<?php echo empty($username->error) ? form::input($username->name, $username->value) : form::input($username->name, $username->value, 'class="error"') ?>
			<?php if ( ! empty($username->error)): ?><br /><span class="error"><?php echo $username->error ?></span><?php endif ?>
		</p>
		<p>
			<?php echo form::label($email->name, $email->label) ?>
			<?php echo empty($email->error) ? form::input($email->name, $email->value) : form::input($email->name, $email->value, 'class="error"') ?>
			<?php if ( ! empty($email->error)): ?><br /><span class="error"><?php echo $email->error ?></span><?php endif ?>
		</p>
		<p>
			<?php echo form::label($password->name, $password->label) ?>
			<?php echo empty($password->error) ? form::password($password->name, $password->value) : form::password($password->name, $password->value, 'class="error"') ?>
			<?php if ( ! empty($password->error)): ?><br /><span class="error"><?php echo $password->error ?></span><?php endif ?>
		</p>
		<p>
			<?php echo form::label($password_confirm->name, $password_confirm->label) ?>
			<?php echo empty($password_confirm->error) ? form::password($password_confirm->name, $password_confirm->value) : form::password($password_confirm->name, $password_confirm->value, 'class="error"') ?>
			<?php if ( ! empty($password_confirm->error)): ?><br /><span class="error"><?php echo $password_confirm->error ?></span><?php endif ?>
		</p>
	</div>
</div>

<p><?php echo form::submit($submit->name, $submit->label); ?></p>

<?php echo form::close(); ?>