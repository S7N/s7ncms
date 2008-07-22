<?php
	echo '<?xml version="1.0" encoding="UTF-8"?>'
?>
<rss version="2.0">
   <channel>
      <title>Latest Comments</title>
      <link><?php echo url::site('blog', 'http') ?></link>
      <description></description>
      <generator>S7Ncms - http://www.s7n.de/</generator>
	  <?php foreach($comments as $item):?>
	  <item>
         <title>New comment for: <?php echo $item->blogpost->title ?></title>
         <author><?php echo $item->author ?></author>
         <link><?php echo url::site('blog/'.$item->blogpost->uri, 'http') ?></link>
         <description>
			<![CDATA[
				<?php echo $item->content ?>
			]]></description>
         <pubDate><?php echo date('r', strtotime($item->date)) ?></pubDate>
      </item>
	<?php endforeach ?>
   </channel>
</rss>