<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h3 id="respond">
	<?php echo __('Your comment')?>:
</h3>

<?php echo form::open(NULL, array('id' => 'commentform')) ?>
	<?php echo $__form_object ?>
	<?php echo $csrf ?>
	<p>
		<?php echo empty($author_error) ? form::input('author', $author->value) : form::input('author', $author->value, 'class="error"') ?>
		<?php echo form::label('author', $author->label) ?>
		<?php if ( ! empty($author_error)): ?><br /><span class="error"><?php echo $author_error ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($email_error) ? form::input('email', $email->value) : form::input('email', $email->value, 'class="error"') ?>
		<?php echo form::label('email', $email->label) ?>
		<?php if ( ! empty($email_error)): ?><br /><span class="error"><?php echo $email_error ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($url_error) ? form::input('url', $url->value) : form::input('url', $url->value, 'class="error"') ?>
		<?php echo form::label('url', $url->label) ?>
		<?php if ( ! empty($url_error)): ?><br /><span class="error"><?php echo $url_error ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($content_error) ? form::textarea('content', $content->value) : form::textarea('content', $content->value, 'class="error"') ?>
		<?php if ( ! empty($content_error)): ?><br /><span class="error"><?php echo $content_error ?></span><?php endif ?>
	</p>
	<?php if (config::get('blog.enable_captcha') === 'yes'):?>
	<p>
		<?php echo $security->get_captcha() ?><br />
		<?php echo empty($security_error) ? form::input('security') : form::input('security', '', 'class="error"') ?>
		<?php echo form::label('security', $security->label) ?>
		<?php if ( ! empty($security_error)): ?><br /><span class="error"><?php echo $security_error ?></span><?php endif ?>
	</p>
	<?php endif; ?>
	<p>
		<?php echo form::submit('submit', $submit->value) ?>
	</p>
<?php echo form::close() ?>