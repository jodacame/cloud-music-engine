<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">     
   <!-- Artist -->
   <?php echo $artist; ?>
   <!-- Tracks -->
   <?php echo $tracks; ?>   

    <sitemap>
      <loc><?php echo base_url(); ?>sitemap/users/1</loc>   
   </sitemap>     
    <sitemap>
      <loc><?php echo base_url(); ?>sitemap/stations/1</loc>   
   </sitemap>
      <sitemap>
      <loc><?php echo base_url(); ?>sitemap/playlist/1</loc>   
   </sitemap>   

</sitemapindex>