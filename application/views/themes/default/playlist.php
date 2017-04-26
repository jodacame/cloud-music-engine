
<div class="col-md-12 visible-md visible-lg">
  <div class="sub-title style2 float-title">  
  <?php echo get_ads("ads1",'col-md-6 padding-top-20 pull-right padding-bottom-20'); ?>   

  <img class="lazy img-playlist " src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $playlist['image']; ?>">
    <div class="block">      
      <span class="t"><?php echo $playlist['name']; ?></span>
      <a href="<?php echo base_url(); ?><?php echo  $this->config->item('slug_user'); ?>/<?php echo $playlist['username']; ?>" class="st"><?php echo __("label_create_by"); ?> <?php echo $playlist['username']; ?></a>      
      <span class="st"><?php echo __("label_lenght"); ?> <?php echo number_format(count($tracks)); ?> <?php echo __("label_tracks"); ?> </span>
      
      <div class="buttons">
       <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="zmdi zmdi-play"></i>  <?php echo __("label_play"); ?>
        </button>
        <ul class="dropdown-menu">
          <li class="btn-play-add" ><a href="#"><?php echo __("label_add_to_queue"); ?></a></li>
          <li class="btn-play-append play-<?php echo $autoplay; ?>"><a href="#"><?php echo __("label_add_to_queue_and_play"); ?></a></li>
          <li class="btn-play-all"><a href="#"><?php echo __("label_clean_queue_and_play"); ?></a></li>
          
        </ul>
      </div>

        <!--<button class="btn btn-success btn-md btn-play-all play-<?php echo $autoplay; ?> btn-green"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>-->
        <?php if($playlist['iduser'] == getUserID()){ 
          $owner=true;
        ?>
        <button class="btn btn-md btn-default btn-edit-playlist" data-idplaylist="<?php echo $playlist['idplaylist']; ?>"  data-image="<?php echo $playlist['image']; ?>" data-name="<?php echo $playlist['name']; ?>" title="<?php echo __("label_edit_playlist"); ?>"><i class="zmdi zmdi-edit"></i></button>
        <button class="btn btn-md btn-default btn-remove-playlist" data-idplaylist="<?php echo $playlist['idplaylist']; ?>" title="<?php echo __("label_delete_playlist"); ?>"><i class="zmdi zmdi-delete"></i></button>        
        <?php } ?>
        <button class="btn btn-md btn-default btn-share" data-subtitle="<?php echo __('label_playlist'); ?>" data-idplaylist="<?php echo $playlist['idplaylist']; ?>"  data-image="<?php echo $playlist['image']; ?>" data-title="<?php echo $playlist['name']; ?>" data-name="<?php echo $playlist['name']; ?>" data-type="playlist" title="<?php echo __("label_share"); ?>"><i class="zmdi zmdi-share"></i></button>        
        <?php echo getLikeButton(4,getUserID(),$playlist['idplaylist'],$playlist['likes']); ?>        
      </div>

    </div>
  </div>
  <div class="coverblur lazy" data-original="<?php echo $playlist['image']; ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover">
   
  </div>

  </div>
  


   
<?php echo get_ads("ads2",'col-md-12 padding-top-20 text-center padding-bottom-20'); ?>   
<div class="col-md-12" id="c-album">  
  

    <?php gui_tracks_playlist($tracks,$owner);  ?>                             
</div>



