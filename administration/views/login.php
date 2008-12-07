<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php echo html::stylesheet('media/css/login'); ?>
	<title>S7Ncms login</title>
    <script type="text/javascript">
        function focusElement() {
            document.getElementById('email').focus();
        }
        window.onload = focusElement;
    </script>
</head>
<body>
<div id="login">
    <div id="logo"><img src="<?php echo url::base(); ?>../img/s7n_login_logo.png" alt="S7Ncms"/></div>
    <div id="message"><?php echo $message ?></div>
    <div id="formular">
        <?php echo $form ?>
    </div>
</div>
</body>
</html>
