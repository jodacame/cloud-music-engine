<div class="col-md-12">
<h1 class="pull-left"><i class="zmdi zmdi-playlist-audio text-success"></i> <?php echo __("label_top_playlist"); ?></h1>
  <div class="filter-generic col-md-4 pull-right">
  <br>
      <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div>   
</div>
<div class="clearfix"></div>
<?php foreach ($playlists as $key => $value) {
    ?>
  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 list-thumb-c filter-me">
        <div class="thumbnail list-thumb contextMenu" data-title="<?php echo $value["name"]; ?>" data-subtitle="<?php echo __("label_playlist"); ?>" data-stationid="<?php echo $value["idplaylist"]; ?>" data-image="<?php echo $value["image"]; ?>" data-type="playlist">
            <div class="image">
                <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['image']; ?>">                
                <div class="overlay">
                    <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_playlist'); ?>/<?php echo urlencode($value["name"]); ?>-<?php echo urlencode($value["idplaylist"]); ?>?play=1"><i class="btn-play-album zmdi zmdi-play" data-name="<?php echo $value["name"]; ?>" data-stationid="<?php echo $value['idplaylist']; ?>" data-image="<?php echo $value["image"]; ?>" data-type="playlist"></i></a>
                </div>
            </div>
            <div class="data">                      
                <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_playlist'); ?>/<?php echo urlencode($value["name"]); ?>-<?php echo urlencode($value["idplaylist"]); ?>" class="name truncate" title="<?php echo $value["title"]; ?>"><?php echo $value["name"]; ?></a>                       
                <div class="subdata truncate"><?php echo number_format($value['likes']).' '.__("label_likes"); ?></div>                    
            </div>
        </div>
    </div>
        <?php
}
?>