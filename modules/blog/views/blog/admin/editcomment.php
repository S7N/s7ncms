<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	width: "500px"
});

</script>

<?php echo form::open('admin/blog/comments/edit/'.$comment->id); ?>
<p>
	Author:<br />
	<?php echo form::input('form_author', $comment->author); ?>
</p>
<p>
	E-Mail:<br />
	<?php echo form::input('form_email', $comment->email); ?>
</p>
<p>
	Homepage:<br />
	<?php echo form::input('form_url', $comment->url); ?>
</p>
<p>
	Comment: (Editor
	<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_content').show();">an</a> /
	<a href="javascript:void(0);" onmousedown="tinyMCE.get('form_content').hide();">aus</a>
	)<br />
	<?php echo form::textarea('form_content', $comment->content); ?>
</p>
<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>
