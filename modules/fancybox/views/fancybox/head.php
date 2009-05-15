<?php echo html::stylesheet('modules/fancybox/css/fancybox') ?>
<?php echo html::script('vendor/jquery/jquery') ?>
<?php echo html::script('modules/fancybox/js/fancybox-1.2.1.pack') ?>
<script type="text/javascript">
$(function() {
	$("a[rel^=lightbox]").fancybox();
});
</script>