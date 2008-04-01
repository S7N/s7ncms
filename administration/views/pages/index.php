<?php echo form::open('pages/action'); ?>
<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Title</td>
			<td>Last Updated</td>
			<td>Author</td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($pages) foreach($pages as $page): ?>
		<tr>
			<td><?php echo html::anchor('pages/edit/'.$page->uri, $page->title); ?></td>
			<td><?php echo $page->modified_on; ?></td>
			<td><?php echo $page->created_by; ?></td>
			<td class="delete"><?php echo html::anchor('pages/delete/'.$page->id, html::image(
				array(
					'src' => 'media/images/delete.png',
					'alt' => 'Delete Page',
					'title' => 'Delete Page'
					),
				TRUE)); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</form>