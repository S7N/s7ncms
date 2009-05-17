<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/page/settings'); ?>
<div class="box">
	<h3><?php echo __('Page settings') ?></h3>
	<div class="inside">
		<p><?php echo form::label('views', __('Available page views')).form::input('views', $views); ?></p>
	</div>
</div>

<div class="box">
	<h3><?php echo __('Sidebar') ?></h3>
	<div class="inside">
		<p><?php echo form::label('views', __('Title')).form::input('default_sidebar_title', $default_sidebar_title); ?></p>
		<p><?php echo form::label('views', __('Content')).form::textarea('default_sidebar_content', $default_sidebar_content); ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')); ?></p>
<?php echo form::close(); ?>