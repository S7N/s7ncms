<h1>File Permissions</h1>
<p>Please check first file permissions of the following files which should be writable:</p>
<ul>
<?php foreach ($files as $file): ?>
<li><?php echo $file ?></li>
<?php endforeach ?>
</ul>

<p>
	<?php echo html::anchor('install/database', 'Continue with setting up the database') ?>
</p>