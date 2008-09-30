<div id="article">
	<div class="entry">
		<div class="entrytitle">
			<h2><?php echo html::anchor($post->get_url(), $post->title) ?></h2>
			<h3 class="date">
				<?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?> (<?php echo $post->comment_count ?> Kommentar(e))
			</h3>
		</div>
		<?php echo $post->content ?>
	</div>
	<div id="comments">
	<?php if (count($comments) > 0): ?>
		<h3>
			<?php echo $post->comment_count ?> Antworten
		</h3>
		<ol class="commentlist">
			<?php $counter = 1; foreach ($comments as $comment): ?>
			<li class="alt">
				<div class="commentcount"><?php echo $counter++ ?></div>
				<cite><?php echo $comment->author ?></cite><br />
				<small class="commentmetadata"><?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?></small>
				<?php echo nl2br($comment->content) ?>
			</li>
			<?php endforeach ?>
		</ol>
	<?php endif ?>	
	
	<?php echo $form ?>
	</div>
</div>