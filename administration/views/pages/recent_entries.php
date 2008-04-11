<?php if(isset($entries)): ?>
<p>
    <strong>Entries</strong>
    <br/>
    <?php foreach($entries as $entry): ?>
    <?php echo html::anchor($entry[0], $entry[1]); ?>
    <br/>
    <?php endforeach; ?>
</p>
<?php endif; ?>
