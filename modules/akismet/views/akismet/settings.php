<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/akismet'); ?>
<div class="box">
	<h3><?php echo __('Akismet Settings') ?></h3>
	<div class="inside">
		<p><?php echo form::label('akismet_api_key', 'API Key').form::input('akismet_api_key', $akismet_api_key) ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', __('Save')); ?></p>

<?php echo form::close(); ?>