<?php echo form::open('pages/newpage') ?>
<div id="tabs">

	<ul>
		<li><a class="active" href="#tab_page"><span>Content</span></a></li>
		<li><a href="#tab_sidebar"><span>Sidebar</span></a></li>
		<li><a href="#tab_advanced"><span>Advanced Settings</span></a></li>
	</ul>
	
	<div id="tab_page">
		<p>Title:<br />
		<?php echo form::input('form_title') ?></p>
		<p>Template:<br />
		<?php echo form::input('form_view', 'default'); ?></p>
		<p>Intro: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_intro').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_intro').hide();">aus</a>
		)<br />
		<?php echo form::textarea('form_intro'); ?></p>
		<p>Body: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_body').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_body').hide();">aus</a>
		)<br />
		<?php echo form::textarea('form_body'); ?></p>
	</div>
	
	<div id="tab_sidebar">
		<p>Sidebar Content: (Editor
			<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_sidebar_content').show();">an</a> /
			<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_sidebar_content').hide();">aus</a>
			)<br />
			<?php echo form::textarea('form_sidebar_content'); ?>
		</p>
	</div>
	
	<div id="tab_advanced">
		<p>
			Keywords (comma separated):<br />
		    <?php echo form::input('form_meta_keywords'); ?>
		</p>
		<p>
			Change the date of publication: (YYYY-MM-DD hh:mm:ss)<br />
			<?php echo form::input('form_publish_on'); ?>
		</p>
	</div>
	
</div>

<p><?php echo form::submit('submit', ' Save '); ?></p>

</form>
