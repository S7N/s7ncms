<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Author</td>
			<td>Comment</td>
			<td>Date</td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($comments) foreach($comments as $comment): ?>
		<tr>
			<td><?php echo html::specialchars($comment->author) ?></td>
			<td><?php echo html::specialchars(text::limit_chars($comment->content, 70)) ?></td>
			<td><?php echo strftime('%e. %B %Y, %H:%M', strtotime($comment->date)) ?></td>
			<td class="delete">(<?php echo html::anchor('admin/blog/comments/edit/'.$comment->id, 'edit') ?>)
			<?php echo html::anchor('admin/blog/comments/delete/'.$comment->id, html::image(
				'themes/admin/images/delete.png',
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