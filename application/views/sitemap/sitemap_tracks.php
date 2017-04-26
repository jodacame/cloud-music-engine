<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php foreach ($tracks->result() as $row) {
      ?>
      <url>         
         <loc><?php echo base_url(); ?><?php echo config_item("slug_main"); ?>/<?php echo urlencode($row->artist); ?>/<?php echo urlencode($row->album); ?>/<?php echo urlencode($row->track); ?></loc>         
         <changefreq>monthly</changefreq>      
      </url>
      <?php
   }
   ?>
</urlset> 
