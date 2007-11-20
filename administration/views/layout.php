<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="generator" content="HTML Tidy for Mac OS X (vers 31 October 2006 - Apple Inc. build 13), see www.w3.org" />

    <title>S7Ncms Administration - <?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo html::stylesheet('media/css/layout'); ?>
</head>

<body>
	<div id="header">
		<h1>Administration - <?php echo $title; ?></h1>
    </div>
    <div id="navigation">
        <ul>
            <li><?php echo html::anchor('home', 'Home') ?></li>
            <li><?php echo html::anchor('user', 'Benutzerverwaltung') ?></li>
            <li><?php echo html::anchor('pages', 'Seiten') ?></li>
            <li><?php echo html::anchor('menu', 'Menü') ?></li>
            <li><?php echo html::anchor('settings', 'Einstellungen') ?></li>
            <li><?php echo html::anchor('modules', 'Module') ?>
                <ul>
                    <li><?php echo html::anchor('module1', 'Module 1') ?></li>
                    <li><?php echo html::anchor('module2', 'Module 2') ?></li>
                    <li><?php echo html::anchor('module3', 'Module 3') ?></li>
                </ul>
            </li>
            <li><?php echo html::anchor('credits', 'Credits') ?></li>
            <li><?php echo html::anchor('user/logout', 'Logout') ?></li>
        </ul>
    </div>
    <div id="content"><?php echo $content; ?></div>
    <div id="footer">S7Ncms &copy; 2007 Eduard Baun</div>
</body>
</html>
