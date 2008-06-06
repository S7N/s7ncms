<?php echo form::open('admin/settings/save'); ?>

<p>Site Title:<br /><?php echo form::input('site_title', $site_title); ?></p>
<p>Default URI:<br /><?php echo form::input('default_uri', $default_uri); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
<?php echo form::close(); ?>