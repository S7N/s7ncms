<?php echo form::open('admin/blog/settings'); ?>
<p><strong>Items per Page:</strong><br />
	<?php echo form::input('items_per_page', $items_per_page) ?>
</p>
<p>
	<?php echo form::checkbox('comment_status', 'open', $comment_status) ?> Enable comments
</p>
<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>
