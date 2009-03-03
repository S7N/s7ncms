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
<?php echo form::open('admin/page/edit/'.$page->id) ?>
<div class="box">
	<h3>Page Information</h3>
	<div class="inside">
		<p><?php echo form::label('form[info][title]', 'Title').form::input('form[info][title]', $page->title()) ?></p>
		<p>
			<?php echo form::label('form[info][type]', 'Redirect page or load Module') ?>
			<?php echo form::radio('form[info][type]', 'none', empty($page->target))?> Do Nothing<br />
			<?php echo form::radio('form[info][type]', 'module', $page->type === 'module')?> Load Module:

			<?php
				$select = array('' => 'No Module');
				foreach ($modules as $module)
					$select[$module->name] = $module->name;

				echo form::dropdown('form[info][module_target]', $select, $page->target);
			?>
			<br />
			<?php echo form::radio('form[info][type]', 'redirect', $page->type === 'redirect')?> Redirect to: <?php echo form::dropdown('form[info][redirect_target]', $page->paths(), $page->target) ?>
		</p>

	</div>
</div>
<div class="box">
	<h3>Content <small>(Deutsch)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form[de][title]', 'Title').form::input('form[de][title]', $page_de->title) ?></p>
		<p><?php echo form::label('form[de][content]', 'Content').form::textarea('form[de][content]', $page_de->content) ?></p>
	</div>
</div>
<div class="box">
	<h3>Content <small>(English)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form[en][title]', 'Title').form::input('form[en][title]', $page_en->title) ?></p>
		<p><?php echo form::label('form[en][content]', 'Content').form::textarea('form[en][content]', $page_en->content) ?></p>
	</div>
</div>
<p><?php echo form::submit('submit', 'Save') ?></p>
<?php echo form::close() ?>