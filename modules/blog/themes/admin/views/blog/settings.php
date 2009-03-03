<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/blog/settings'); ?>
<div class="box">
	<h3>Blog Settings</h3>
	<div class="inside">
		<p><?php echo form::label('items_per_page', 'Blog entries per page').form::input('items_per_page', $items_per_page) ?></p>
		<p><?php echo form::checkbox('comment_status', 'open', $comment_status) ?> Enable comments</p>
	</div>
</div>

<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>