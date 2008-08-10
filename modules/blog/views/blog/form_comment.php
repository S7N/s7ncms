<h1>Dein Kommentar:</h1>

<div id="comments-container">
	<?php echo form::open() ?>
		<fieldset>
			<ol>
				<li>
					<?php echo form::label('author', 'Name') ?>
					<?php echo form::input('author', $fields['author']) ?>
					<?php if ( ! empty($errors['author'])): ?><span class="error"><?php echo $errors['author'] ?></span><?php endif ?>
				</li>

				<li>
					<?php echo form::label('email', 'E-Mail') ?>
					<?php echo form::input('email', $fields['email']) ?>
					<?php if ( ! empty($errors['email'])): ?><span class="error"><?php echo $errors['email'] ?></span><?php endif ?>
				</li>

				<li>
					<?php echo form::label('url', 'Homepage') ?>
					<?php echo form::input('url', $fields['url']) ?>
					<?php if ( ! empty($errors['url'])): ?><span class="error"><?php echo $errors['url'] ?></span><?php endif ?>
				</li>

				<li>
					<?php echo form::textarea('content', $fields['content']) ?>
					<?php if ( ! empty($errors['content'])): ?><span class="error"><?php echo $errors['content'] ?></span><?php endif ?>
				</li>
				<li>
					<?php echo form::submit('submit', ' Abschicken ') ?>
				</li>
			</ol>
		</fieldset>
	<?php echo form::close() ?>
</div>