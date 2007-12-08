<h1>Database</h1>
Please provide your database data.

<?php echo form::open('install/database'); ?>

<p><b>Host:</b><br /><?php echo form::input('host', $host); ?></p>
<p><b>Database:</b><br /><?php echo form::input('database', $database); ?></p>
<p><b>Table Prefix:</b><br /><?php echo form::input('prefix', $prefix); ?></p>
<p><b>Username:</b><br /><?php echo form::input('username', $username); ?></p>
<p><b>Password:</b><br /><?php echo form::password('password', $password); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>