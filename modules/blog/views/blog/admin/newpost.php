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
<?php echo form::open('admin/blog/newpost') ?>
<div id="tabs">
	<div id="tab_content">
		<p><?php echo form::label('form_title', 'Title').form::input('form_title') ?></p>
		<p><?php echo form::label('form_content', 'Content').form::textarea('form_content') ?></p>
		<p><?php echo form::submit('submit', ' Save ') ?></p>
	</div>
	<div id="tab_advanced">
		<p><?php echo form::label('form_content', 'Keywords: <small>(Comma separated)</small>').form::input('form_tags') ?></p>
	</div>
</div>

<?php echo form::close() ?>
