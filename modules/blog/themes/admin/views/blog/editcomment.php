<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/blog/comments/edit/'.$comment->id); ?>

<div class="box">
	<h3><?php echo __('Edit Comment') ?></h3>
	<div class="inside">
		<p><?php echo form::label('form_author', __('Author')).form::input('form_author', $comment->author); ?></p>
		<p><?php echo form::label('form_email', __('Email')).form::input('form_email', $comment->email); ?></p>
		<p><?php echo form::label('form_url', __('Homepage')).form::input('form_url', $comment->url); ?></p>
		<p><?php echo form::label('form_comment', __('Comment')).form::textarea('form_content', $comment->content); ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')); ?></p>

<?php echo form::close(); ?>
