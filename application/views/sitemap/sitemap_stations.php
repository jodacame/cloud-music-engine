<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php foreach ($stations->result() as $row) {
      ?>
      <url>
         <loc><?php echo base_url(); ?><?php echo config_item("slug_station"); ?>/-/<?php echo urlencode($row->title); ?>-<?php echo $row->idstation; ?></loc>                  
         <changefreq>always</changefreq>      
      </url>
      <?php
   }
   ?>
</urlset> 
