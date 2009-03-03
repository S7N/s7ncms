<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php if(isset($entries)): ?>
<p>
    <strong>Entries</strong>
    <br/>
	<?php echo html::anchor('admin/page', 'All Entries'); ?><br />
    <?php foreach($entries as $entry): ?>
    <?php echo html::anchor($entry[0], $entry[1]); ?>
    <br/>
    <?php endforeach; ?>
</p>
<?php endif; ?>
