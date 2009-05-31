<h1><?php echo $content->title ?></h1>
<p><?php echo $content->data ?></p>
<hr />
<p>Keywords: <?php foreach ($content->keywords as $keyword) echo $keyword->value .', '?></p>
<p>Created on: <?php echo $page->date_created ?> by <?php echo $page->author->username ?> (<?php echo $page->author->first_name ?> <?php echo $page->author->last_name ?>; <?php echo $page->author->email ?>)</p>
<p>The Author speaks <?php echo $page->author->nation->language->name ?></p>
<p>Full URI if this page: <?php echo $page->uri() ?></p>
<p>Link to this page: <?php echo html::anchor($page->uri(), $content->menu_title) ?></p>
<p>German version of this page: <?php echo html::anchor_lang('de', $page->uri('de'), $page->content('de')->menu_title) ?></p>
<p>English version of this page: <?php echo html::anchor_lang('en', $page->uri('en'), $page->content('en')->menu_title) ?></p>
