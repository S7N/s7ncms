<h1>Users</h1>
<p><b><?php echo html::anchor('admin/user/create', 'Create a new user'); ?></b></p>

<?php echo form::open('admin/user/search'); ?>
<p><b>Search Users:</b><br /><?php echo form::input(array('name' => 'search', 'size' => 10)); ?> <?php echo form::submit('submit',' Search! ')?></p>
<?php echo form::close(); ?>

<?php echo form::open('admin/user/action'); ?>

<table cellspacing="0" cellpadding="5" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>&nbsp;</td>
			<td>ID</td>
			<td>Username</td>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php foreach($users as $user): ?>
		<tr>
			<td><?php echo form::checkbox('user_id[]', $user->id, false)?></td>
			<td><?php echo $user->id; ?></td>
			<td><?php echo $user->username; ?><br /><span style="font-size: 80%;"><?php echo $user->email; ?></span></td>
			<td><?php echo html::anchor('user/edit/'.$user->id, 'edit'); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p><?php echo form::checkbox('toggle', 'toggle', false, 'onChange="S7N.toggleCheckboxes()"')?> Select all</p>
<p>
<?php
$options = array('' => '- please select -',
				 'delete' => 'delete');
echo form::dropdown('action', $options);
?>

<?php echo form::submit('submit',' Do It! ')?>
</p>
</form>