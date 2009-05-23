<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>
<div class="box">
	<h3><?php echo __('Edit Comment') ?></h3>
	<div class="inside">
		<p><?php echo form::label($author->name, $author->label).form::input($author->name, $author->value); ?></p>
		<p><?php echo form::label($email->name, $email->label).form::input($email->name, $email->value); ?></p>
		<p><?php echo form::label($url->name, $url->label).form::input($url->name, $url->value); ?></p>
		<p><?php echo form::label($content->name, $content->label).form::textarea($content->name, $content->value); ?></p>
	</div>
</div>

<p><?php echo form::submit($submit->name, $submit->label); ?></p>

<?php echo form::close(); ?>
