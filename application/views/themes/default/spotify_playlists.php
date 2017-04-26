<div class="col-md-12">
  <h2 class="pull-left"><i class="fa fa-spotify text-success"></i> <?php echo __("label_my_playlists_spotify"); ?></h2>
  <div class="filter-generic col-md-4 pull-right">
  <br>
      <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div>   
</div>
<div class="clearfix"></div>
<?php
 $CI     =& get_instance(); 
  foreach ($playlists->items as $key => $value) {
  ?>
  <div class="filter-me col-lg-2 col-md-4 list-thumb-c">
        <div class="thumbnail list-thumb">
            <div class="image">
                <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value->images[0]->url; ?>">                
                <div class="overlay">
                    <a href="<?php echo base_url(); ?>spotify/playlist/<?php echo $value->owner->id; ?>::<?php echo $value->id; ?>?play=1"><i class="btn-play-album zmdi zmdi-play" data-name="<?php echo $value->name; ?>"  data-image="<?php echo $value->images[0]->url; ?>" data-type="playlist"></i></a>
                </div>
            </div>
            <div class="data">                    
                <a href="<?php echo base_url(); ?>spotify/playlist/<?php echo $value->owner->id; ?>::<?php echo $value->id; ?>" class="name truncate" title="<?php echo $value->name; ?>"><i class="fa fa-spotify"></i> <?php echo $value->name; ?></a>                     
                <div class="subdata"><i class="fa fa-user"></i> <?php echo $value->owner->id; ?></div> 
            </div>
        </div>
    </div>
        <?php
      } 
      ?>