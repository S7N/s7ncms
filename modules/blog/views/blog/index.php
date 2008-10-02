<?php foreach ($posts as $post): ?>
	<div class="entry">
		<div class="entrytitle">
			<h2><?php echo html::anchor($post->get_url(), $post->title) ?></h2>
			<h3 class="date">
				<?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?> (<?php echo $post->comment_count ?> Kommentar(e))
			</h3>
		</div>
		<?php echo $post->content ?>
	</div>
<?php endforeach; ?>

<div class="navigation">
	<?php if (isset($pagination)) echo $pagination ?>
</div>
