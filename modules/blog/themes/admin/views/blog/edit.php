<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/blog/edit', array(), array('form_id' => $post->id)) ?>

<div class="box">
	<h3><?php echo __('Edit Blog Post') ?></h3>
	<div class="inside">
		<p><?php echo form::label('form_title', __('Title')).form::input('form_title', $post->title) ?></p>
		<p><?php echo form::label('form_content', __('Content')).form::textarea('form_content', $post->content) ?></p>
		<p><?php echo form::label('form_content', __('Tags: <small>(Comma separated)</small>')).form::input('form_tags', $post->tags) ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')) ?></p>

<?php echo form::close() ?>
