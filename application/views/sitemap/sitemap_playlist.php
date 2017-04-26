<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php foreach ($playlist->result() as $row) {
      ?>
      <url>
         <loc><?php echo base_url(); ?><?php echo config_item("slug_playlist"); ?>/<?php echo urlencode($row->name); ?>-<?php echo $row->idplaylist; ?></loc>         
         <changefreq>monthly</changefreq>      
      </url>
      <?php
   }
   ?>
</urlset> 
