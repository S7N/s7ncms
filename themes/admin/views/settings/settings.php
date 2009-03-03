<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/settings/save'); ?>

<div class="box">
	<h3>General Settings</h3>
	<div class="inside">
		<p><?php echo form::label('site_title', 'Site Title').form::input('site_title', $site_title); ?></p>
		<p><?php echo form::label('theme', 'Theme').form::dropdown('theme', $themes, $theme); ?></p>
	</div>
</div>

<p><?php echo form::submit('submit','Save'); ?></p>

<?php echo form::close(); ?>