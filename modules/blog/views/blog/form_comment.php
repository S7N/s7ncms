<h1>Dein Kommentar:</h1>

<div id="comments-container">
	<?php echo form::open() ?>
		<fieldset>
			<ol>
				<li>
					<label for="form_author"><?php echo $form_name->label() ?></label>
					<?php echo $form_name->render() ?>
					<?php echo $form_name_errors; ?>
				</li>

				<li>
					<label for="form_email"><?php echo $form_email->label() ?></label>
					<?php echo $form_email->render() ?>
					<?php echo $form_email_errors; ?>
				</li>

				<li>
					<label for="form_url"><?php echo $form_homepage->label() ?></label>
					<?php echo $form_homepage->render() ?>
					<?php echo $form_homepage_errors; ?>
				</li>

				<li>
					<?php echo $form_comment->render() ?>
					<?php echo $form_comment_errors; ?>
				</li>
				<li>
					<input name="submit" type="submit" value="Abschicken!" />
				</li>
			</ol>
		</fieldset>
	<?php echo form::close() ?>
</div>