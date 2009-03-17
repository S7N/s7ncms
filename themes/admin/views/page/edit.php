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
	theme_advanced_buttons1 : "pagebreak,bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,image,imageupload,|,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",

	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : false,
	
    setup : function(ed) {
        // Add a custom button
        ed.addButton('imageupload', {
            title : 'Image Upload',
            class : 'mce_image',
            onclick : function() {
            	$('#uploader').dialog('option','insertin', ed);
            	$('#uploader').dialog('open');
            }
        });	
	}	
});

</script>
<?php echo form::open('admin/page/edit/'.$page->id) ?>
<div class="box">
	<h3>Page Information</h3>
	<div class="inside">
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
<?php foreach (Kohana::config('locale.languages') as $key => $lang): ?>
<div class="box">
	<h3>Content <small>(<?php echo $lang['name'] ?>)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form['.$key.'][title]', 'Title').form::input('form['.$key.'][title]', $form[$key]->title) ?></p>
		<p><?php echo form::label('form['.$key.'][content]', 'Content').form::textarea('form['.$key.'][content]', $form[$key]->content) ?></p>
	</div>
</div>
<?php endforeach; ?>
<p><?php echo form::submit('submit', 'Save') ?></p>
<?php echo form::close() ?>
