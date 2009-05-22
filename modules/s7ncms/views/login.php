<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php echo html::stylesheet('themes/admin/css/login.css', 'screen'); ?>
	<title>S7Ncms login</title>
	<script type="text/javascript">
        window.onload = function () {document.getElementById('username').focus();};
    </script>
</head>
<body>
<div id="login">
    <div id="logo"><?php echo html::image('themes/default/images/s7n_logo.png') ?></div>
    <div id="formular">
        <div id="message">
        <?php foreach ($errors as $error): ?>
        	<?php echo $error ?><br />
        <?php endforeach ?>
        </div>

        <?php echo form::open(NULL) ?>
        	<p class="email">
        		<?php echo form::label('username', 'Username') ?><br />
        		<?php echo form::input('username', $fields['username']) ?>
        	</p>
        	<p class="password">
        		<?php echo form::label('password', 'Password') ?><br />
        		<?php echo form::password('password') ?>
        	</p>
        	<p class="submit">
        		<?php echo form::submit('submit', ' Login ') ?>
        	</p>
        <?php echo form::close() ?>
    </div>
</div>
</body>
</html>
