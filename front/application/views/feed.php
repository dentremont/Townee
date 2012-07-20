<?php echo '<?xml version="1.0"?> '; ?>
<rss version="2.0"> 
   <channel> 
      <title><?php echo $items['info']->name; ?> - Town.ee</title> 
      <link>http://town.ee</link> 
      <description><?php echo $items['info']->meta; ?></description> 
      <language>en-us</language> 
      <pubDate><?php echo $items['info']->created_at; ?></pubDate> 
      <lastBuildDate><?php echo $items['info']->created_at; ?></lastBuildDate> 
      <?php foreach($items['content'] as $item) : ?>
      <item> 
         <title><?php echo $item->name; ?></title> 
         <link>http://www.twitter.com/<?php echo $item->screen_name; ?>/status/<?php echo $item->tweet_id;?></link> 
         <description><?php echo $item->tweet_text; ?></description> 
         <pubDate><?php echo $item->created_at; ?></pubDate> 
      </item>
      <?php endforeach; ?>
   </channel> 
</rss>