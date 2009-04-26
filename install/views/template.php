<?php defined("SYSPATH") or die("No direct script access.") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>S7Ncms Installer</title>
<style>
img { border: 0px; }
a { color: #0000ff; }
header { }
.error {color: red;}
</style>
</head>
<body>
<div class="header">
<img src="s7n.png" />
</div>
<?php if (isset($error)): ?>
<div class="error">
	<?php echo $error ?>
</div>
<?php endif ?>
<?php echo $content ?>
</body>
</html>

