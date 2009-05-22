<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/blog/settings'); ?>
<div class="box">
	<h3><?php echo __('Blog Settings') ?></h3>
	<div class="inside">
		<p><?php echo form::label('items_per_page', __('Blog entries per page')).form::input('items_per_page', $items_per_page) ?></p>
		<p><?php echo form::checkbox('enable_captcha', 'yes', $enable_captcha) ?> <?php echo __('Enable captcha') ?></p>
		<p><?php echo form::checkbox('comment_status', 'open', $comment_status) ?> <?php echo __('Enable comments') ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')); ?></p>

<?php echo form::close(); ?>