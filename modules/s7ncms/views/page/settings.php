<?php echo form::open('admin/page/settings'); ?>

<h1>Page Views:</h1>
<p><?php echo form::input('views', $views); ?></p>

<h1>Sidebar:</h1>
<p><strong>Title</strong><br />
<?php echo form::input('default_sidebar_title', $default_sidebar_title); ?><br />
<strong>Content</strong><br />
<?php echo form::textarea('default_sidebar_content', $default_sidebar_content); ?>
</p>

<p><?php echo form::submit('submit','Save'); ?></p>
<?php echo form::close(); ?>