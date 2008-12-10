<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	width: "500px",
	theme: 'advanced',
	plugins : "inlinepopups",
	entity_encoding : "raw",
	convert_urls : false
});

</script>
<?php echo form::open('admin/page/edit', array(), array('form_id' => $page->id)) ?>
<div id="tabs">
	<div id="tab_content">
		<p><?php echo form::label('form_title', 'Title').form::input('form_title', $page->title) ?></p>
		<p><?php echo form::label('form_content', 'Content').form::textarea('form_content', $page->content) ?></p>
		<p><?php echo form::submit('submit', 'Save') ?></p>
	</div>
	<div id="tab_advanced">
		<p>
		<?php echo form::label('form_type', 'Redirect page or load Module') ?>
		<?php echo form::radio('form_type', 'none', empty($page->target))?> No<br />
		<?php echo form::radio('form_type', 'module', $page->type === 'module')?> Load Module:

		<?php
			$select = array('' => 'No Module');
			foreach ($modules as $module)
			{
				$select[$module->name] = $module->name;
			}

			echo form::dropdown('form_module_target', $select, $page->target);
		?>
		<br />
		<?php echo form::radio('form_type', 'redirect', $page->type === 'redirect')?> Redirect to: <?php echo form::dropdown('form_redirect_target', $page->paths(), $page->target) ?>
		</p>

		<p><?php echo form::label('form_view', 'Template').form::input('form_view', $page->view) ?></p>
		<p><?php echo form::label('form_keywords', 'Keywords: <small>(Comma separated)</small>').form::input('form_keywords', $page->keywords) ?></p>
	</div>
</div>

<?php echo form::close() ?>
