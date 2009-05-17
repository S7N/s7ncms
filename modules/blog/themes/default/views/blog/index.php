<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php foreach ($posts as $post): ?>
	<div class="entry">
		<div class="entrytitle">
			<h2><?php echo html::anchor($post->url(), $post->title) ?></h2>
			<h3 class="date">
				<?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?> (<?php echo __n('One comment', '%count comments', $post->comment_count) ?>)
			</h3>
		</div>
		<?php echo $post->content ?>
	</div>
<?php endforeach; ?>

<div class="navigation">
	<?php if (isset($pagination)) echo $pagination ?>
</div>
