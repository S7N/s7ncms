<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>s7ncms Installer</title>
<style>
img { border: 0px; }
a { color: #0000ff; }
header { }
</style>
</head>
<body>
<div class="header">
<img src="s7n.png">
</div>
<hr />
<div class="requierments">
System Test <font color="green">OK</font>
</div>
<hr />
<div class="dberror">
	<?php echo $dberror; ?>
</div>
<div class="dbinfo">
<?php echo form::open(); ?>
<table>

	<tr>
		<td>
			<label for="dbuser">Username</label>
		</td>
		<td>
			<?php echo form::input('dbuser') ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<label for="dbpass">Password</label>
		</td>
		<td>
			<?php echo form::password('dbpass') ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<label for="dbhost">Hostname</label>
		</td>
		<td>
			<?php echo form::input('dbhost') ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<label for="dbdatabase">Database</label>
		</td>
		<td>
			<?php echo form::input('dbdatabase') ?>
		</td>
	</tr>	
</table>
<?php echo form::submit('submit', 'Check') ?>
<?php echo form::close() ?>
</div>
<hr />
</body>
</html>

