<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>
<div class="box">
	<h3><?php echo __('General Settings') ?></h3>
	<div class="inside">
		<p><?php echo form::label($site_title->name, $site_title->label).form::input($site_title->name, $site_title->value); ?></p>
		<p><?php echo form::label($theme->name, $theme->label).form::dropdown($theme->name, $theme->values, $theme->value); ?></p>
	</div>
</div>

<p><?php echo form::submit($submit->name, $submit->label); ?></p>

<?php echo form::close(); ?>