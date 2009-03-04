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

<?php echo form::open('admin/page/newpage') ?>
<?php foreach (Kohana::config('locale.languages') as $key => $lang): ?>
<div class="box">
	<h3>Content <small>(<?php echo $lang['name'] ?>)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form['.$key.'][title]', 'Title').form::input('form['.$key.'][title]') ?></p>
		<p><?php echo form::label('form['.$key.'][content]', 'Content').form::textarea('form['.$key.'][content]') ?></p>
	</div>
</div>
<?php endforeach; ?>
<p><?php echo form::submit('submit', 'Save') ?></p>
<?php echo form::close() ?>

