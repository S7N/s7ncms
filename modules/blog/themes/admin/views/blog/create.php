<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>
<div class="box">
	<h3><?php echo __('New Blog Post') ?></h3>
	<div class="inside">
		<p>
			<?php echo form::label($title->name, $title->label) ?>
			<?php echo empty($title->error) ? form::input($title->name, $title->value) : form::input($title->name, $title->value, 'class="error"') ?>
			<?php if ( ! empty($title->error)): ?><br /><span class="error"><?php echo $title->error ?></span><?php endif ?>
		</p>
		<p><?php echo form::label($content->name, $content->label).form::textarea($content->name, $content->value) ?></p>
		<p><?php echo form::label($tags->name, $tags->label).form::input($tags->name, $tags->value) ?></p>
	</div>
</div>

<p><?php echo form::submit($submit->name, $submit->label) ?></p>

<?php echo form::close() ?>