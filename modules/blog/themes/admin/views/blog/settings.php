<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open() ?>
<?php echo $__form_object ?>
<?php echo $csrf ?>
<div class="box">
	<h3><?php echo __('Blog Settings') ?></h3>
	<div class="inside">
		<p>
			<?php echo form::label($items_per_page->name, $items_per_page->label) ?>
			<?php echo empty($items_per_page->error) ? form::input($items_per_page->name, $items_per_page->value) : form::input($items_per_page->name, $items_per_page->value, 'class="error"') ?>
			<?php if ( ! empty($items_per_page->error)): ?><br /><span class="error"><?php echo $items_per_page->error ?></span><?php endif ?>
		</p>
		<p>
			<?php echo form::checkbox($enable_captcha->name, $enable_captcha->value, $enable_captcha->checked) ?> <?php echo __('Enable captcha') ?><br/>
			<?php echo form::checkbox($enable_tagcloud->name, $enable_tagcloud->value, $enable_tagcloud->checked) ?> <?php echo __('Enable tag cloud') ?><br/>
			<?php echo form::checkbox($comment_status->name, $comment_status->value, $comment_status->checked) ?> <?php echo __('Enable comments') ?>
		</p>
	</div>
</div>

<p><?php echo form::submit($submit->name, $submit->label); ?></p>

<?php echo form::close(); ?>