<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/google_analytics'); ?>
<div class="box">
	<h3>Google Anylytics Settings</h3>
	<div class="inside">
		<p><?php echo form::label('google_analytics_id', 'Web Property ID').form::input('google_analytics_id', $google_analytics_id) ?></p>
	</div>
</div>

<p><?php echo form::submit('submit', ' Save '); ?></p>

<?php echo form::close(); ?>