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
	  <?php $blogpost = ORM::factory('blogpost')->find_by_id((int) $item->blogpost_id) ?>
	  <!-- ?php $blogpost = $item->blogpost; //ORM::factory('blogpost')->find_by_id((int) $item->blogpost_id) ?-->
      <item>
         <title>
         	<?php echo $item->author ?>
         </title>
         <link><?php echo url::site('blog/'.$blogpost->uri, 'http') ?></link>
         <description>
			<![CDATA[
				<?php echo $item->content ?>
			]]></description>
         <pubDate><?php echo date('r', strtotime($item->date)) ?></pubDate>
      </item>
	<?php endforeach ?>
   </channel>
</rss>