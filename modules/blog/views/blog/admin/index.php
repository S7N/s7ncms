<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Title</td>
			<td>Created on</td>
			<td>Author</td>
			<td>Comments</td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($posts) foreach($posts as $post): ?>
		<tr>
			<td>
				<?php echo html::anchor('admin/blog/edit/'.$post->id, $post->title) ?>
				&mdash;
				<?php echo html::anchor('admin/blog/comments/'.$post->id, $post->comment_count.' comment(s)') ?>
			</td>
			<td><?php echo $post->date ?></td>
			<td><?php echo $post->user->username ?></td>
			<td>
				<?php if($post->comment_status === 'open'): ?>
					<?php echo html::anchor('admin/blog/comments/close/'.$post->id, 'open') ?>
				<?php else: ?>
					<?php echo html::anchor('admin/blog/comments/open/'.$post->id, 'closed') ?>
				<?php endif ?>
			</td>
			<td class="delete"><?php echo html::anchor('admin/blog/delete/'.$post->id, html::image(
				'media/admin/images/delete.png',
				array(
					'alt' => 'Delete Page',
					'title' => 'Delete Page'
					)
				)) ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>