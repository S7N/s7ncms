<h1><?php echo $post->title ?></h1>
<p>Geschrieben von: <?php echo $post->user->username ?></p>
<p><?php echo $post->content ?></p>

<?php if (count($comments) > 0): ?>
	<h1><?php echo $post->comment_count ?> Kommentar(e):</h1>
	
	<?php foreach ($comments as $comment): ?>
		<p>
			<b><?php echo $comment->author ?></b>
			<?php if ( ! empty($comment->url)): ?>
				(<?php echo html::anchor($comment->url, 'Link') ?>)
			<?php endif; ?>
			sagte am <?php echo strftime('%e. %B %Y, %H:%M', strtotime($comment->date)) ?>:<br />
			<?php echo nl2br($comment->content) ?></p>
	<?php endforeach ?>
<?php endif ?>

<?php echo $form ?>