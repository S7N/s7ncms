<h1>Pages - Settings</h1>
<?php echo form::open('pages/settings'); ?>

<p>Page Views:<br /><?php echo form::input('views', $views); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
</form>