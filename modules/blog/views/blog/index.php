<?php foreach ($blogposts as $post): ?>
	<h1><?php echo html::anchor('blog/'.$post->uri, $post->title) ?> <sup><?php echo $post->comment_count ?> Kommentare</sup></h1>
	<p>Geschrieben von <strong><?php echo $post->user->username ?></strong> am <?php echo strftime('%e. %B %Y, %H:%M', strtotime($post->date)) ?></p>
	<p><?php echo $post->content ?></p>
<?php endforeach; ?>

<p><?php if (isset($pagination)) echo $pagination ?></p>