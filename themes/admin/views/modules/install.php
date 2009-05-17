<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1>Not Installed Modules:</h1>
<table cellspacing="0" cellpadding="0" class="table">
	<thead align="left" valign="middle">
		<tr>
			<td><?php echo __('Module') ?></td>
			<td><?php echo __('Version') ?></td>
			<td><?php echo __('Description') ?></td>
			<td><?php echo __('Action') ?></td>
			<td class="delete">&nbsp;</td>
		</tr>
	</thead>
	<tbody align="left" valign="middle">
	<?php if($modules) foreach($modules as $module): ?>
		<tr>
			<td><?php echo $module->name ?></td>
			<td><?php echo $module->version ?></td>
			<td><?php echo $module->description ?></td>
			<td><?php echo html::anchor('admin/modules/install/'.$module->uri, __('install')); ?></td>
			<td class="delete"><?php echo html::anchor('admin/modules/uninstall/'.$module->uri, html::image(
				'themes/admin/images/delete.png',
				array(
					'alt' => __('Uninstall Module'),
					'title' => __('Uninstall Module')
					)
				)); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>