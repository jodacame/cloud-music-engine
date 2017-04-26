
<div class="visible-lg visible-md col-md-12">
  <div class="sub-title style2 float-title">  
  <?php echo get_ads("ads1",'col-md-5  pull-right'); ?>

    <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $album['picture_medium']; ?>">

    <div class="block">      
      <h1 class="t"><?php echo $album['album']; ?></h1>
      <a href="<?php echo base_url(); ?><?php echo  $this->config->item('slug_main'); ?>/<?php echo $album['artist']; ?>" class="st"><h2><?php echo $album['artist']; ?></h2></a>      
      <span class="st"><?php echo number_format(count($tracks)); ?> <?php echo __("label_tracks"); ?> </span>
      <span class="st"><?php echo $album["release_date"]; ?> </span>
      
      <div class="buttons">       

       <div class="btn-group">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="zmdi zmdi-play"></i>  <?php echo __("label_play"); ?>
          </button>
          <ul class="dropdown-menu">
            <li class="btn-play-add" ><a href="#"><?php echo __("label_add_to_queue"); ?></a></li>
            <li class="btn-play-append play-<?php echo $autoplay; ?>"><a href="#"><?php echo __("label_add_to_queue_and_play"); ?></a></li>
            <li class="btn-play-all" data-abum="<?php echo $album['album']; ?>"><a href="#"><?php echo __("label_clean_queue_and_play"); ?></a></li>
            
          </ul>
        </div>

       <!-- <button class="btn btn-success btn-md btn-play-all play-<?php echo $autoplay; ?> btn-green" data-abum="<?php echo $album['album']; ?>"><i class="zmdi zmdi-play"></i>  <?php echo __("label_play"); ?></button>        -->
        <?php if(config_item("download_button") ==1 || (config_item("download_button") == 2 && is_logged())){ ?>
        <button class="btn btn-default btn-md btn-buy btn-2" data-id="<?php echo $album['id']; ?>" data-title="<?php echo $album['album']; ?>" data-album="<?php echo $album['album']; ?>" data-artist="<?php echo $album['artist']; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-image="<?php echo $album["picture_medium"]; ?>" data-type="album"><i class="zmdi zmdi-download"></i> <?php echo __("label_download"); ?></button>      
      <?php } ?>
        <button class="btn btn-default btn-md  btn-share" data-id="<?php echo $album['id']; ?>" data-title="<?php echo $album['album']; ?>" data-album="<?php echo $album['album']; ?>" data-artist="<?php echo $album['artist']; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-image="<?php echo $album["picture_medium"]; ?>" data-type="album"><i class="zmdi zmdi-share"></i></button>
        <?php echo getLikeButton(2,getUserID(),$album['idalbum'],$album['likes']); ?>        
        
    
      </div>
    </div>    
  </div>

  
</div>
  
<?php echo get_ads("ads2",'col-md-12 text-center padding-bottom-20'); ?>


   

<div class="col-md-12" id="c-album">   

    <?php gui_tracks($tracks);  ?>                             
</div>



