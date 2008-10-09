<div class="folder">
    <div style="float: left;">
    <span class="movehandle">[Move]</span>
    <?php echo html::anchor('admin/page/edit/'.$page->id, '<span>'.$page->title.'</span>'); ?>
    </div>
    <div style="position:absolute;right:30px;">(<strong>Last updated:</strong> <?php echo $page->modified; ?>)</div>
    <div class="deleter" style="position:absolute;right:10px;">
    <?php echo html::anchor('admin/page/delete/'.$page->id, html::image(
		'media/admin/images/delete.png',	
		array(
			'alt' => 'Delete Page',
			'title' => 'Delete Page'
		)), array('class' => 'confirm'))
	?>
    </div>
</div>