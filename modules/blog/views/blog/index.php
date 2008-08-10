<?php foreach ($posts as $post): ?>
	<h1><?php echo html::anchor($post->get_url(), $post->title) ?> <sup><?php echo $post->comment_count ?> Kommentare</sup></h1>
	<p>Geschrieben von <strong><?php echo $post->user->username ?></strong> am <?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?></p>
	<p><?php echo $post->content ?></p>
<?php endforeach; ?>

<p><?php if (isset($pagination)) echo $pagination ?></p>