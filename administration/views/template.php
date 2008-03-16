<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>S7Nadmin - <?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo html::stylesheet('media/css/layout', 'screen', TRUE) ?>
    <?php echo $meta ?>
</head>

<body>
	<div id="header">
		S7Nadmin
		<div class="info">
			<?php echo html::anchor('auth/logout', 'Logout'); ?>
		</div>
	</div>

	<div id="navigation">
		<ul>
			<li><?php echo html::anchor('dashboard', 'Dashboard'); ?></li>
			<li><?php echo html::anchor('settings', 'Settings'); ?></li>
			<li><?php echo html::anchor('user', 'Users'); ?></li>
			<li><?php echo html::anchor('pages', 'Pages'); ?></li>
			<li><?php echo html::anchor('modules', 'Modules'); ?></li>
		</ul>
	</div>

	<div id="left">
		<p><strong>Tasks:</strong><br />
		<?php foreach($links as $link): ?>
			<?php echo html::anchor($link[0], $link[1]); ?><br />
		<?php endforeach; ?>
		</p>
		<?php if(isset($entries)): ?>
			<p><strong>Entries:</strong><br />
			<?php foreach($entries as $entry): ?>
				<?php echo html::anchor($entry[0], $entry[1]); ?><br />
			<?php endforeach; ?>
			</p>
		<?php endif; ?>
	</div>

	<div id="main">
		<div id="title">
			<?php echo $title ?>
		</div>

		<div id="content">
			<?php if( ! is_null($message)): ?>
				<div id="message">
					<?php echo $message ?>
				</div>
			<?php endif; ?>
			<?php if( ! is_null($error)): ?>
				<div id="error">
					<?php echo $error ?>
				</div>
			<?php endif; ?>
			<?php echo $content ?>
		</div>
	</div>
</body>
</html>