<?php if($modules): ?>
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
	<?php foreach($modules as $module): ?>
		<tr>
			<td><?php echo html::anchor('admin/'.$module['db']->name, $module['xml']->name) ?></td>
			<td><?php echo $module['xml']->version ?></td>
			<td><?php echo $module['xml']->description ?></td>
			<td>
			<?php if($module['db']->status === 'on'): ?>
			<?php echo html::anchor('admin/modules/status/'.$module['db']->name.'/off', 'disable'); ?>
			<?php else: ?>
			<?php echo html::anchor('admin/modules/status/'.$module['db']->name.'/on', 'enable'); ?>
			<?php endif; ?>
			</td>
			<td class="delete"><?php echo html::anchor('admin/modules/uninstall/'.$module['db']->name, html::image(
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
<?php endif ?>

<?php if( ! empty($not_installed_modules)): ?>
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
	<?php foreach($not_installed_modules as $module): ?>
		<tr>
			<td><?php echo $module->name ?></td>
			<td><?php echo $module->version ?></td>
			<td><?php echo $module->description ?></td>
			<td><?php echo html::anchor('admin/modules/install/'.$module->uri, 'install'); ?></td>
			<td class="delete">&nbsp;</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif ?>