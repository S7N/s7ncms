<h3 id="respond">
	Dein Kommentar
</h3>

<?php echo form::open(NULL, array('id' => 'commentform')) /* id="commentform" */?>
	<p>
		<?php echo empty($errors['author']) ? form::input('author', $fields['author']) : form::input('author', $fields['author'], 'class="error"') ?>
		<?php echo form::label('author', 'Name') ?>
		<?php if ( ! empty($errors['author'])): ?><br /><span class="error"><?php echo $errors['author'] ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($errors['email']) ? form::input('email', $fields['email']) : form::input('email', $fields['email'], 'class="error"') ?>
		<?php echo form::label('email', 'E-Mail') ?>
		<?php if ( ! empty($errors['email'])): ?><br /><span class="error"><?php echo $errors['email'] ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($errors['url']) ? form::input('url', $fields['url']) : form::input('url', $fields['url'], 'class="error"') ?>
		<?php echo form::label('url', 'Homepage') ?>
		<?php if ( ! empty($errors['url'])): ?><br /><span class="error"><?php echo $errors['url'] ?></span><?php endif ?>
	</p>
	<p>
		<?php echo empty($errors['content']) ? form::textarea('content', $fields['content']) : form::textarea('content', $fields['content'], 'class="error"') ?>
		<?php if ( ! empty($errors['content'])): ?><br /><span class="error"><?php echo $errors['content'] ?></span><?php endif ?>
	</p>
	<p>
		<?php echo form::submit('submit', ' Abschicken ') ?>
	</p>
<?php echo form::close() ?>