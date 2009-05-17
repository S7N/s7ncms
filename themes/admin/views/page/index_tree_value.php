<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="folder">
    <div style="float: left;">
    <span class="movehandle">[Move]</span>
    <?php echo html::anchor('admin/page/edit/'.$page->id, '<span>'.$page->title().'</span>'); ?>
    <?php if ($page->level == 1 AND Kohana::find_file('controllers', $page->uri)): ?>
    	<?php echo html::image('themes/admin/images/warning.png') ?>
    <?php endif ?>
    </div>
    <div class="delete" style="position:absolute;right:10px;">
    <?php echo html::anchor('admin/page/delete/'.$page->id, html::image(
		'themes/admin/images/delete.png',
		array(
			'alt' => __('Delete Page'),
			'title' => __('Delete Page')
		)), array('class' => 'confirm'))
	?>
    </div>
</div>