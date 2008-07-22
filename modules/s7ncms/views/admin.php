<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $head ?>
</head>

<body>
	<div id="header">
		S7Nadmin
		<div class="info">
			<?php echo html::anchor('admin/auth/logout', 'Logout'); ?>
		</div>
	</div>

	<div id="navigation">
		<ul>
			<li><?php echo html::anchor('admin/dashboard', 'Dashboard'); ?></li>
			<li><?php echo html::anchor('admin/page', 'Pages'); ?></li>
			<li><?php echo html::anchor('admin/modules', 'Modules'); ?></li>
			<li><?php echo html::anchor('admin/menu', 'Menu'); ?></li>
			<li><?php echo html::anchor('admin/user', 'Users'); ?></li>
			<li><?php echo html::anchor('admin/settings', 'Settings'); ?></li>
		</ul>
	</div>

	<div id="left">
		<?php if(isset($tasks) AND !empty($tasks)): ?>
			<p><strong>Tasks</strong><br />
			<?php foreach($tasks as $task): ?>
				<?php echo html::anchor($task[0], $task[1]); ?><br />
			<?php endforeach; ?>
			</p>
		<?php endif; ?>
		
		<?php echo $this->recent_entries() ?>
		
	</div>

	<div id="main">
		<div id="title">
			<p><?php echo $title ?></p>
			<?php if ($searchbar): ?>
			<?php echo form::open('', array('id' => 'searchbar', 'method' => 'get')) ?>
			    <input name="q" value="<?php echo $searchvalue ?>" type="search" placeholder="Filter by" autosave="s7n.search" />
			<?php echo form::close() ?>
			<?php endif ?>
		</div>
		<div id="content">
			<?php if( $message !== NULL ): ?>
				<div id="message">
					<?php echo $message ?>
				</div>
			<?php endif; ?>
			<?php if( $error !== NULL): ?>
				<div id="error">
					<?php echo $error ?>
				</div>
			<?php endif; ?>
			<?php echo $content ?>
		</div>
	</div>
</body>
</html>