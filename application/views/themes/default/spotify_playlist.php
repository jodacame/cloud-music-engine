
<div class="col-md-12 visible-lg visible-md">
  <h2 class="sub-title style2 float-title truncate">  
  <img class="lazy img-playlist " src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $playlist->images[0]->url; ?>">
    <div class="block">      
      <span class="t"><i class="fa fa-spotify text-success"></i> <?php echo $playlist->name; ?></span>      
      <span class="st"><?php echo __("label_lenght"); ?> <?php echo number_format(count($playlist->tracks->items)); ?> <?php echo __("label_tracks"); ?> </span>
      <span class="st"><?php echo ($playlist->owner->id); ?>&nbsp;</span>
      <span class="st"><?php echo strip_tags($playlist->description); ?>&nbsp;</span>
      
      
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
        <!--<button class="btn btn-success btn-md btn-play-all play-<?php echo $autoplay; ?> btn-green"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>                      -->
        <button class="btn btn-default btn-md btn-import-playlist hide"><i class="zmdi zmdi-playlist-audio"></i> Import Playlist</button>                      
        <button class="btn btn-default btn-link btn-green" data-href="<?php echo base_url(); ?>spotify/playlist"><i class="fa fa-spotify"></i> <?php echo __("label_my_playlists_spotify"); ?></button>                      
      </div>
    </div>
  </h2>
    <div class="coverblur lazy" data-original="<?php echo $playlist->images[0]->url; ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
    <div class="overlay-cover">
     <?php echo get_ads("ads1",'col-md-8 pull-right padding-top-20 padding-bottom-20'); ?>                       
    </div>

  </div>
  

<?php
foreach ($playlist->tracks->items as $key => $value) {

	$track = array();
  $track['id'] = $value->track->id;
	$track['artist'] = $value->track->artists[0]->name;
	$track['picture_small'] = $value->track->album->images[2]->url;
	$track['picture_medium'] = $value->track->album->images[1]->url;
	$track['picture_exta'] = $value->track->album->images[0]->url;
	$track['album'] = $value->track->album->name;
	$track['track'] = $value->track->name;
	$tracks[] = $track;
}

?>
  

<div class="col-md-12" id="c-album">   
    <?php gui_tracks_playlist($tracks,$owner);  ?>                             
</div>




