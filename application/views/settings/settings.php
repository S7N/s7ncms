<h1>Settings</h1>
<?php echo form::open('admin/settings/save'); ?>

<p>Default URI:<br /><?php echo form::input('default_uri', $default_uri); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
<?php echo form::close(); ?>