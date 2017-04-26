   <?php for($x=1;$x<=intval($pages);$x++){ ?>
   <sitemap>
      <loc><?php echo base_url(); ?>sitemap/artist/<?php echo $x; ?></loc>   
   </sitemap>
   <?php } ?>
