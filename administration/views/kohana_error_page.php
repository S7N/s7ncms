<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>S7Ncms Administration - <?php echo $error; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
/* <![CDATA[ */
body{font:11pt verdana,arial,sans serif;background:#99bbcd;color:black}
body,#top h1,#leiste,#footer,#message,#content h1{margin:0}
body,#leiste{padding:0}
a:hover{text-decoration:underline}
a{text-decoration:none;color:#333}
#top{background:#eaeaea;padding-top:10px;padding-bottom:10px}
#top,#leiste,#footer{width:100%}
#top h1{font:25pt 'trebuchet ms','lucida grande',sans-serif;padding-left:20pt;color:#6698b3}
#leiste,#footer{background:#6698b3}
#footer{padding-top:0.4em;padding-bottom:0.4em;font-size:9pt;color:#fff}
#footer,#message{text-align:center}
#container{width:95%;margin:10px auto;line-height:130%}
#content h1{margin-left:-10pt;margin-right:-10pt}
#content{background:#fff;overflow:visible;padding-bottom:5pt;padding-right:10pt}
#content,#content h1{padding-left:10pt}
#content h1{background:#d6e9ee;color:#283d82;padding:5pt;margin-bottom:10px;font-size:15pt}
/* ]]> */
</style>
<!--
 This is a little <script> does two things:
   1. Prevents a strange bug that can happen in IE when using the <style> tag
   2. Accounts for PHP's relative anchors in errors
-->
<script type="text/javascript">document.write('<base href="http://php.net/" />')</script>
</head>

<body>

<div id="top">
<h1>S7NAdmin</h1>
</div>

<div id="leiste">&nbsp;</div>
	<div id="container" align="center">
		<div id="content" align="left">
			<h1><?php echo $error ?></h1>
		    <strong><?php echo $description ?></strong>
			<p class="message"><?php echo $message ?></p>
			<?php if ($line != FALSE AND $file != FALSE): ?>
				<p class="detail"><?php echo Kohana::lang('core.error_message', $line, $file) ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div id="footer">S7Ncms &copy; 2007 Eduard Baun, powered by <?php echo html::anchor('http://www.s7n.de/', 'S7Ncms'); ?></div>
</body>
</html>