<?php echo form::open('pages/action'); ?>

<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Title</td>
			<td>Last Updated</td>
			<td>Author</td>
			<td class="delete">Delete</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($pages) foreach($pages as $page): ?>
		<tr>
			<td><?php echo html::anchor('pages/edit/'.$page->uri, $page->title); ?></td>
			<td><?php echo $page->modified_on; ?></td>
			<td><?php echo $page->created_by; ?></td>
			<td><?php echo html::anchor('pages/delete/'.$page->id, 'x'); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p><!--?php echo form::checkbox('toggle', 'toggle', false, 'onChange="S7N.toggleCheckboxes()"')?> Select all</p>
<p-->
<!--?php
$options = array('' => '- please select -',
				 'delete' => 'delete',
				 'publish' => '(un)publish');
echo form::dropdown('action', $options);
?-->

<!--?php echo form::submit('submit',' Do It! ')?-->
</p>
</form>