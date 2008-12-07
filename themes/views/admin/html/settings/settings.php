<?php echo form::open('admin/settings/save'); ?>

<p><?php echo form::label('site_title', 'Site Title').form::input('site_title', $site_title); ?></p>
<p><?php echo form::label('theme', 'Theme').form::dropdown('theme', $themes, $theme); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>

<?php echo form::close(); ?>