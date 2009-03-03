<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1>User - New</h1>
<?php echo form::open('admin/user/create'); ?>

<p>Username:<br /><?php echo form::input('username'); ?></p>
<p>Password:<br /><?php echo form::password('password'); ?></p>
<p>Email:<br /><?php echo form::input('email'); ?></p>
<p>Homepage:<br /><?php echo form::input('homepage'); ?></p>
<p>First name:<br /><?php echo form::input('first_name'); ?></p>
<p>Last name:<br /><?php echo form::input('last_name'); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
<?php echo form::close(); ?>