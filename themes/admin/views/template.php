<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $head ?>
</head>

<body>
	<div id="dialog" style="display: none;">Möchten Sie diese Seite inklusive der Unterseiten wirklich löschen?</div>
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
			<?php echo menus::modules() ?>
			<li><?php echo html::anchor('admin/modules', 'Modules'); ?></li>
			<li><?php echo html::anchor('admin/user', 'Users'); ?></li>
			<li><?php echo html::anchor('admin/settings', 'Settings'); ?></li>
		</ul>
	</div>

	<div id="main">
		<div id="title">
			<h2><?php echo $title ?></h2>
			<?php if ($searchbar): ?>
			<?php echo form::open(NULL, array('id' => 'searchbar', 'method' => 'get')) ?>
			    <input name="q" value="<?php echo $searchvalue ?>" type="search" placeholder="Filter by" autosave="s7n.search" />
			<?php echo form::close() ?>
			<?php endif ?>

			<!--<?php if(isset($tabs)): ?>
			<ul id="contentmenu">
				<?php foreach ($tabs as $tab): ?>
                	<li><a href="#tab_<?php echo url::title($tab) ?>"><span><?php echo $tab ?></span></a></li>
                <?php endforeach ?>
            </ul>
			<?php endif ?>-->
		</div>

		<div id="left">
			<div id="sidebar">
				<?php echo Sidebar::instance() ?>

				<?php if(isset($tasks) AND !empty($tasks)): ?>
					<h3>Tasks</h3>
					<p>
						<?php foreach($tasks as $task): ?>
							<?php echo html::anchor($task[0], $task[1]); ?><br />
						<?php endforeach; ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

		<div id="content">
			<?php if( $message !== NULL ): ?>
				<div id="info_message">
					<p><?php echo $message ?></p>
				</div>
			<?php endif; ?>
			<?php if( $error !== NULL): ?>
				<div id="error_message">
					<p><?php echo $error ?></p>
				</div>
			<?php endif; ?>
			<?php echo $content ?>
		</div>
	</div>
</body>
</html>