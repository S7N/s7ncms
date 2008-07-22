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
			<td><?php echo html::anchor('admin/page/edit/'.$page->id, $page->title); ?></td>
			<td><?php echo $page->modified; ?></td>
			<td><?php echo $page->user->username; ?></td>
			<td class="delete"><?php echo html::anchor('admin/page/delete/'.$page->id, html::image(
				'media/admin/images/delete.png',	
				array(
					'alt' => 'Delete Page',
					'title' => 'Delete Page'
					)
				)); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>