<?php echo form::open('admin/pages/settings'); ?>

<p>Page Views:<br /><?php echo form::input('views', $views); ?></p>

<p><?php echo form::submit('submit','Save'); ?></p>
</form>