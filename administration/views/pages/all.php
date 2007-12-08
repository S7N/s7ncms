<h1>Pages</h1>
<p>
	<b><?php echo html::anchor('pages/newpage', 'Create a new page'); ?></b><br />
	<b><?php echo html::anchor('pages/settings', 'Edit Settings'); ?></b>
</p>

<?php echo form::open('pages/action'); ?>

<table cellspacing="0" cellpadding="5" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>&nbsp;</td>
			<td>ID</td>
			<td>Title</td>
			<td>Last Updated</td>
			<td>Author</td>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($pages) foreach($pages as $page): ?>
		<tr>
			<td><?php echo form::checkbox('page_id[]', $page->id, false)?></td>
			<td><?php echo $page->id; ?></td>
			<td><?php echo $page->title; ?></td>
			<td><?php echo $page->modified_on; ?></td>
			<td><?php echo $page->created_by; ?></td>
			<td><?php echo html::anchor('../'.$page->uri, 'view'); ?> <?php echo html::anchor('pages/edit/'.$page->uri, 'edit'); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p><?php echo form::checkbox('toggle', 'toggle', false, 'onChange="S7N.toggleCheckboxes()"')?> Select all</p>
<p>
<?php
$options = array('' => '- please select -',
				 'delete' => 'delete',
				 'publish' => '(un)publish');
echo form::dropdown('action', $options);
?>

<?php echo form::submit('submit',' Do It! ')?>
</p>
</form>