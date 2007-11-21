<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>S7Ncms Administration - <?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo html::stylesheet('media/css/layout'); ?>
</head>

<body>

<div id="top">
<h1>S7NAdmin</h1>
</div>

<div id="leiste">&nbsp;</div>
	<div id="container" align="center">
		<div id="navigation" align="left">
			<ul id="navlist">
				<li><span id="current">Admin</span>
					<ul id="subnavlist">
					    <li><?php echo html::anchor('home', 'Home'); ?></li>
						<li><?php echo html::anchor('settings', 'Settings'); ?></li>
					</ul>
				</li>
				<li><span id="current">User</span>
					<ul id="subnavlist">
					    <li><?php echo html::anchor('user', 'List all'); ?></li>
						<li><?php echo html::anchor('user/groups', 'Groups'); ?></li>
					</ul>
				</li>
				<li><span id="current"><?php echo html::anchor('pages', 'Pages'); ?></span>
				</li>
				<li><span id="current">Modules</span>
					<ul id="subnavlist">
					    <li><?php echo html::anchor('blog', 'Blog'); ?></li>
						<li><?php echo html::anchor('gallery', 'Gallery'); ?></li>
						<li><?php echo html::anchor('upload', 'Upload'); ?></li>
					</ul>
				</li>
				<li><span id="current">Logout</span>
					<ul id="subnavlist">
						<li><?php echo html::anchor('auth/logout', 'Logout'); ?></li>
					</ul>
				</li>					
			</ul>
			
		</div>
		<div id="content" align="left">
		    <div id="message"><?php echo $this->session->get('flash_msg'); ?></div>
			<?php echo $content ?>
		</div>
	</div>
	<div id="footer">S7Ncms &copy; 2007 Eduard Baun, powered by <?php echo html::anchor('http://www.s7n.de/', 'S7Ncms'); ?></div>
</body>
</html>
