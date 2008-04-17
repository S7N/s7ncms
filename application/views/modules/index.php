<h1>Installed Modules:</h1>
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
			<td><?php echo $module['xml']->name ?></td>
			<td><?php echo $module['xml']->version ?></td>
			<td><?php echo $module['xml']->description ?></td>
			<td>
			<?php if($module['db']->status === 'on'): ?>
			<?php echo html::anchor('admin/modules/status/'.$module['db']->name.'/off', 'deactivate'); ?>
			<?php else: ?>
			<?php echo html::anchor('admin/modules/status/'.$module['db']->name.'/on', 'activate'); ?>
			<?php endif; ?>
			</td>
			<td class="delete"><?php echo html::anchor('admin/modules/uninstall/'.$module['db']->name, html::image(
				array(
					'src' => 'media/admin/images/delete.png',
					'alt' => 'Uninstall Module',
					'title' => 'Uninstall Module'
					)
				)); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>