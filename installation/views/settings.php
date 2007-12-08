<h1>User Data</h1>
<p>Please choose an username and a password. This user will be the Administrator of your Website.</p>
<?php echo form::open('install/settings'); ?>

<p><b>Username:</b><br /><?php echo form::input('username', $username); ?></p>
<p><b>Password:</b><br /><?php echo form::password('password', $password); ?></p>

<h1>Website Data</h1>
<p><b>URL of your Website:</b><br /><?php echo form::input('url', $url); ?></p>
<p><b>SEO friendly URL:</b><br />
<?php echo form::checkbox('mod_rewrite', 'yes', false); ?> My server supports mod_rewrite</p>

<p><?php echo form::submit('submit','Save'); ?></p>