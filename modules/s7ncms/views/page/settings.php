<?php echo form::open('admin/page/settings'); ?>

<p><?php echo form::label('views', 'Page Views').form::input('views', $views); ?></p>

<h1>Sidebar:</h1>
<p><?php echo form::label('views', 'Title').form::input('default_sidebar_title', $default_sidebar_title); ?></p>
<p><?php echo form::label('views', 'Content').form::textarea('default_sidebar_content', $default_sidebar_content); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
<?php echo form::close(); ?>