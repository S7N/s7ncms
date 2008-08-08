<?php
	echo '<?xml version="1.0" encoding="UTF-8"?>'
?>
<rss version="2.0">
   <channel>
      <title><?php echo Kohana::config('s7n.site_title') ?></title>
      <link><?php echo url::site('blog', 'http') ?></link>
      <description></description>
      <generator>S7Ncms - http://www.s7n.de/</generator>
	  <?php foreach($posts as $item):?>
      <item>
         <title><?php echo $item->title ?></title>
         <link><?php echo url::site($item->get_url(), 'http') ?></link>
         <description><![CDATA[<?php echo $item->content ?>]]></description>
         <pubDate><?php echo date('r', strtotime($item->date)) ?></pubDate>
         <guid><?php echo url::site($item->get_url(), 'http') ?></guid>
      </item>
      <?php endforeach ?>
   </channel>
</rss>