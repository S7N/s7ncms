<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php echo html::stylesheet('media/css/layout'); ?>
	<title>S7Ncms Install</title>
</head>
<body>
<div id="layout">
    <div id="logo"><?php echo html::image('media/img/s7n_logo.png'); ?></div>
    <div id="content">
        <p class="message"><?php echo $message ?></p>
        <?php echo $content ?>
    </div>
</div>
</body>
</html>
