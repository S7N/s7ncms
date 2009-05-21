<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/page/newpage') ?>
<?php foreach (Kohana::config('locale.languages') as $key => $lang): ?>
<div class="box">
	<h3><?php echo __('Content') ?> <small>(<?php echo $lang['name'] ?>)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form['.$key.'][title]', __('Title')).form::input('form['.$key.'][title]') ?></p>
		<p><?php echo form::label('form['.$key.'][content]', __('Content')).form::textarea('form['.$key.'][content]') ?></p>
	</div>
</div>
<?php endforeach; ?>
<p><?php echo form::submit('submit', __('Save')) ?></p>
<?php echo form::close() ?>

