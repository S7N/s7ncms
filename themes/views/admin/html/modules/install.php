<h1>Not Installed Modules:</h1>
<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Module</td>
			<td>Version</td>
			<td>Description</td>
			<td>Action</td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($modules) foreach($modules as $module): ?>
		<tr>
			<td><?php echo $module->name ?></td>
			<td><?php echo $module->version ?></td>
			<td><?php echo $module->description ?></td>
			<td><?php echo html::anchor('admin/modules/install/'.$module->uri, 'install'); ?></td>
			<td class="delete"><?php echo html::anchor('admin/modules/uninstall/'.$module->uri, html::image(
				'themes/views/admin/images/delete.png',
				array(
					'alt' => 'Uninstall Module',
					'title' => 'Uninstall Module'
					)
				)); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>