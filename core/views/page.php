<h1><?php echo $content->title ?></h1>
<p>Keywords: <?php foreach ($content->keywords as $keyword) echo $keyword->value .', '?></p>
<p>Created on: <?php echo $page->date_created ?> by <?php echo $page->author->username ?> (<?php echo $page->author->first_name ?> <?php echo $page->author->last_name ?>; <?php echo $page->author->email ?>)</p>
<p><?php echo $content->data ?></p>