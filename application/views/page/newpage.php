<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	width: "500px",
	theme: 'advanced'
});

</script>
<?php echo form::open('admin/page/newpage') ?>
<div id="tabs">

	<ul>
		<li><a class="active" href="#tab_page"><span>Content</span></a></li>
		<li><a href="#tab_advanced"><span>Advanced</span></a></li>
	</ul>
	
	<div id="tab_page">
		<p>Title:<br />
		<?php echo form::input('form_title') ?></p>
		<p>Template:<br />
		<?php echo form::input('form_view', 'default'); ?></p>
		<p>Content: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_content').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_content').hide();">aus</a>
		)<br />
		<?php echo form::textarea('form_content'); ?></p>
		
		<p>Excerpt: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_excerpt').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_excerpt').hide();">aus</a>
		)<br />
		<?php echo form::textarea('form_excerpt'); ?></p>
		
	</div>
	
	<div id="tab_advanced">
		<p>
			Keywords (comma separated):<br />
		    <?php echo form::input('form_keywords'); ?>
		</p>
	</div>
	
</div>

<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>
