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
<?php echo form::open('admin/page/newpage') ?>
<div id="tabs">
	<div id="tab_content">
		<p><?php echo form::label('form_title', 'Title').form::input('form_title') ?></p>
		<p><?php echo form::label('form_content', 'Content').form::textarea('form_content') ?></p>
		<p><?php echo form::submit('submit', 'Save') ?></p>
	</div>
	<div id="tab_advanced">
		<p>
		<?php
			$select = array('none' => 'No Module');
			foreach ($modules as $module)
			{
				$select[$module['db']->name] = $module['xml']->name;
			}
			
			echo form::label('form_module', 'Module');
		?>
		<?php echo form::dropdown('form_module', $select, 'none') ?>
		</p>
		<p><?php echo form::label('form_view', 'Template').form::input('form_view') ?></p>
		<p><?php echo form::label('form_keywords', 'Keywords: <small>(Comma separated)</small>').form::input('form_keywords') ?></p>
	</div>
</div>

<?php echo form::close() ?>