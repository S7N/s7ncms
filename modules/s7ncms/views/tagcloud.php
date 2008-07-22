<div id="tagcloud">
<?php foreach ($tags as $tag): ?>
	<span style="font-size:<?php echo $tag['size'] ?>%;"><?php echo html::anchor($tag['uri'], rawurlencode($tag['name'])) ?></span>
<?php endforeach ?>
</div>
