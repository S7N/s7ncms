<?php $path = 'modules/syntaxhighlighter/vendor/syntaxhighlighter/';
echo html::script(array(
	$path.'scripts/shCore',
	$path.'scripts/shLegacy',
	$path.'scripts/shBrushAS3',
	$path.'scripts/shBrushBash',
	$path.'scripts/shBrushCpp',
	$path.'scripts/shBrushCsharp',
	$path.'scripts/shBrushCss',
	$path.'scripts/shBrushDelphi',
	$path.'scripts/shBrushDiff',
	$path.'scripts/shBrushGroovy',
	$path.'scripts/shBrushJava',
	$path.'scripts/shBrushJavaFX',
	$path.'scripts/shBrushJScript',
	$path.'scripts/shBrushPerl',
	$path.'scripts/shBrushPhp',
	$path.'scripts/shBrushPlain',
	$path.'scripts/shBrushPowerShell',
	$path.'scripts/shBrushPython',
	$path.'scripts/shBrushRuby',
	$path.'scripts/shBrushScala',
	$path.'scripts/shBrushSql',
	$path.'scripts/shBrushVb',
	$path.'scripts/shBrushXml')) ?>
<?php echo html::stylesheet($path.'styles/shCore') ?>
<?php echo html::stylesheet($path.'styles/shThemeDefault') ?>
<script type="text/javascript">
SyntaxHighlighter.defaults['toolbar'] = false;
SyntaxHighlighter.all();
</script>