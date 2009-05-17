<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme: 'advanced',
	skin : "s7n",
	plugins : "safari",
	entity_encoding : "raw",
	convert_urls : false,

	// Theme options
	theme_advanced_buttons1 : "pagebreak,bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,|,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",

	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : false
});
</script>

<?php echo form::open('admin/blog/newpost') ?>

<div class="box">
	<h3><?php echo __('New Blog Post') ?></h3>
	<div class="inside">
		<p><?php echo form::label('form_title', __('Title')).form::input('form_title') ?></p>
		<p><?php echo form::label('form_content', __('Content')).form::textarea('form_content') ?></p>
		<p><?php echo form::label('form_content', __('Tags: <small>(Comma separated)</small>')).form::input('form_tags') ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')) ?></p>

<?php echo form::close() ?>
