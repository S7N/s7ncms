<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>

<?php foreach (Kohana::config('locale.languages') as $key => $value): ?>
<div class="box">
	<h3><?php echo __('Content') ?> <small>(<?php echo $value['name'] ?>)</small></h3>
	<div class="inside">
		<p>
			<?php echo form::label(${'title_'.$key}->name, ${'title_'.$key}->label) ?>
			<?php echo empty(${'title_'.$key}->error) ? form::input(${'title_'.$key}->name, ${'title_'.$key}->value) : form::input(${'title_'.$key}->name, ${'title_'.$key}->value, 'class="error"') ?>
			<?php if ( ! empty(${'title_'.$key}->error)): ?><br /><span class="error"><?php echo ${'title_'.$key}->error ?></span><?php endif ?>
		</p>
		<p><?php echo form::label(${'content_'.$key}->name, ${'content_'.$key}->label).form::textarea(${'content_'.$key}->name, ${'content_'.$key}->value) ?></p>
	</div>
</div>
<?php endforeach; ?>

<p><?php echo form::submit($submit->name, $submit->label); ?></p>

<?php echo form::close(); ?>

