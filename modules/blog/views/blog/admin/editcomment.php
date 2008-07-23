<?php echo form::open('admin/blog/comments/edit/'.$comment->id); ?>
<p>
	Author:<br />
	<?php echo form::input('form_author', $comment->author); ?>
</p>
<p>
	E-Mail:<br />
	<?php echo form::input('form_email', $comment->email); ?>
</p>
<p>
	Homepage:<br />
	<?php echo form::input('form_url', $comment->url); ?>
</p>
<p>
	<?php echo form::textarea('form_content', $comment->content); ?>
</p>
<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>
