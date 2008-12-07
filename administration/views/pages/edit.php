<h1>Pages - Edit</h1>
<?php echo form::open('pages/edit', array(), array('id' => $page->id)); ?>
<?php echo form::hidden('content_id', $page->content_id); ?>
<div id="myTabs" class="mootabs">

	<ul class="mootabs_title">
		<li><a class="active" href="#tab_page">Content</a></li>
		<li><a href="#tab_sidebar">Sidebar</a></li>
		<li><a href="#tab_advanced">Advanced Settings</a></li>
	</ul>
	
	<div id="tab_page" class="mootabs_panel active">
		<p>Title:<br />
		<?php echo form::input('title', $page->title); ?></p>
		<p>Template:<br />
		<?php echo form::input('view', $page->view); ?></p>
		<p>Intro: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('intro').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('intro').hide();">aus</a>
		)<br />
		<?php echo form::textarea('intro', $page->intro); ?></p>
		<p>Body: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('body').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('body').hide();">aus</a>
		)<br />
		<?php echo form::textarea('body', $page->body); ?></p>
		
	</div>
	
	<div id="tab_sidebar" class="mootabs_panel">
	
		<p>Sidebar Content: (Editor
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('sidebar_content').show();">an</a> /
		<a href="javascript:void(0);" onmousedown="tinyMCE.get('sidebar_content').hide();">aus</a>
		)<br />
		<?php echo form::textarea('sidebar_content', $page->sidebar_content); ?></p>
	
	</div>
	
	<div id="tab_advanced" class="mootabs_panel">
	
		<p>
			Keywords (comma separated):<br />
		    <?php echo form::input('meta_keywords', $page->meta_keywords); ?>
		</p>
		
		<p>
			Change the date of publication: (YYYY-MM-DD hh:mm:ss)<br />
			<?php echo form::input('publish_on', $page->publish_on); ?>
		</p>
	</div>

</div>
<p><?php echo form::submit('submit', 'Save'); ?></p>
</form>
