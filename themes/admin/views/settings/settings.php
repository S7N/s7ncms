<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/settings/save'); ?>

<div class="box">
	<h3><?php echo __('general settings') ?></h3>
	<div class="inside">
		<p><?php echo form::label('site_title', __('Site title')).form::input('site_title', $site_title); ?></p>
		<p><?php echo form::label('theme', __('Theme')).form::dropdown('theme', $themes, $theme); ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')); ?></p>

<?php echo form::close(); ?>