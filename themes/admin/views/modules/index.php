<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php if($modules): ?>
<h1>Available Modules:</h1>
<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td>Module</td>
			<td>Action</td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php foreach($modules as $module => $version): ?>
		<tr>
			<td><?php echo html::anchor('admin/'.$module, $module) ?></td>
			<td>
			<?php if (module::installed($module)): ?>
				<?php if (module::active($module)): ?>
					<?php echo html::anchor('admin/modules/status/'.$module.'/off', 'disable'); ?>
				<?php else: ?>
					<?php echo html::anchor('admin/modules/status/'.$module.'/on', 'enable'); ?>
				<?php endif ?>
			<?php else: ?>
				<?php echo html::anchor('admin/modules/install/'.$module, 'install'); ?>
			<?php endif ?>
			</td>
			<td class="delete">
			<?php if (module::installed($module)) echo html::anchor('admin/modules/uninstall/'.$module, html::image(
				'themes/admin/images/delete.png',
				array(
					'alt' => 'Uninstall Module',
					'title' => 'Uninstall Module'
					)
				)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif ?>