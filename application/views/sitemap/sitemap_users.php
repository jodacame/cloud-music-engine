<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php foreach ($users->result() as $row) {
      ?>
      <url>
         <loc><?php echo base_url(); ?><?php echo config_item("slug_user"); ?>/<?php echo urlencode($row->username); ?></loc>         
         <changefreq>daily</changefreq>      
      </url>
      <?php
   }
   ?>
</urlset> 
