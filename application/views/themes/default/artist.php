

<div class="visible-lg visible-md header contextMenu" data-id="<?php echo $data['id']; ?>" data-subtitle="<?php echo __("label_artist"); ?>" data-title="<?php echo $data['artist']; ?>" data-artist="<?php echo $data['artist']; ?>" data-image="<?php echo base_url().$data["picture_small"]; ?>" data-type="artist">
  <div class="sub-title float-title">  
  <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $data['picture_medium']; ?>">
   <span class="st">
    <?php if($data['genre_1']){ ?>
     <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>/<?php echo urlencode(normalize_name($data['genre_1'])); ?>"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo $data['genre_1']; ?></a>
     <?php } if($data['genre_2']){ ?>
     <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>/<?php echo urlencode(normalize_name($data['genre_2'])); ?>"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo $data['genre_2']; ?></a>
     <?php }  ?>
   </span>
    <h1 class="t"><?php echo $data['artist']; ?></h1>
    <span class="block visible-lg visible-md">      
      <!--<button class="btn btn-success btn-md  btn-play-all play-<?php echo $autoplay; ?> btn-green"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>-->
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

      <button class="btn btn-success btn-md btn-start-discover btn-green" data-artist="<?php echo $data["artist"]; ?>" ><i class="zmdi zmdi-portable-wifi"></i> <?php echo __("label_discover"); ?></button>      
      <button class="btn btn-default btn-md  btn-share" data-id="<?php echo $data['id']; ?>" data-subtitle="<?php echo __("label_artist"); ?>" data-title="<?php echo $data['artist']; ?>" data-artist="<?php echo $data['artist']; ?>" data-image="<?php echo base_url().$data["picture_small"]; ?>" data-type="artist"><i class="zmdi zmdi-share"></i></button>
      <?php echo getLikeButton(1,getUserID(),$data['idartist'],$data['likes']); ?>        
      </div>
    </span>

  </div>
  <div class="coverblur lazy" data-original="<?php echo $data['picture_extra'];  ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover">
      <?php echo get_ads("ads1",'col-md-6 text-center  pull-right padding-top-20'); ?>
  </div>
</div>

<div class="col-md-12">  
    <div class="c">
        <div class="navbar navbar-default">
            <ul class="tabs nav navbar-nav">
              <li class="active" data-href="#overview"><a href="#"><?php echo __("label_overview"); ?></a></li>
              <li data-href="#albums"><a href="#"><?php echo __("label_albums"); ?></a></li>
              <li data-href="#similar"><a href="#"><?php echo __("label_related"); ?></a></li>
              <li data-href="#about"><a href="#"><?php echo __("label_about"); ?></a></li>
              
          </ul>
        </div>
    </div>
</div>   
<?php echo get_ads("ads2",'col-md-12 padding-top-20 padding-bottom-20'); ?>   
<div class="clearfix"></div>
<div class="tab active" id="overview">
  
    <div class="col-md-<?php if(count($playlists) > 0 || count($stations)> 0){ echo "8"; }else{ echo "12"; }?> ">                           
        <?php gui_tracks($toptracks,__("label_top_tracks"),true);  ?>                             
    </div>

   
                <?php if($stations){ ?>
                   <div class="col-md-4">
                     <h2 class="title"><?php echo __("label_stations"); ?></h2>
                                      
                      <?php echo get_ads("ads2",'col-md-12  padding-top-20 padding-bottom-20'); ?>
                      <div class="clearfix"></div>
                        <ul class="list-group style2 d ">
                      <?php     

                          foreach ($stations as $key => $value) {
                            if($key==10)
                              break;
                              ?>
                              <li class="list-group-item style2 d" >                                                
                                <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo slug($value["genre"]); ?>/<?php echo $value["title"]; ?>-<?php echo $value["idstation"]; ?>">                                                                        
                                <div class="thumb">
                                  <div class="thumb-overlay"> 
                                    <i class="zmdi zmdi-radio"></i>
                                  </div>
                                  <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url().$value['cover']; ?>">                
                                </div>
                                <div class="name  truncate title">
                                  <?php echo $value['title']; ?> 
                                  <div class="text-muted truncate"><?php echo $value['description']; ?></div>
                                </div>
                                </a>
                              </li>
                              <?php
                          }
                          ?>   
                          
                      </ul>   
               </div>
                <?php } ?>

               

    <?php if(count($playlists) > 0){ ?> 
    <div class="col-md-4">    

             <h2 class="title"><?php echo __("label_playlist"); ?></h2>                
            <ul class="list-group style2">
              
              
            <?php     

               foreach ($playlists as $key => $value) {

                    if($key==5)
                      break;
                    ?>
                    <li class="list-group-item style2 d contextMenu" data-mbid="<?php echo $value["mbid"]; ?>" data-id="<?php echo $value["id"]; ?>" data-source="<?php echo $value["source"]; ?>" data-subtitle="<?php echo __("label_playlist"); ?>" data-title="<?php echo $value['name']; ?>" data-name="<?php echo $value['name']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="playlist">                                                
                      <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_playlist'); ?>/<?php echo urlencode($value["name"]); ?>-<?php echo $value["idplaylist"]; ?>">                                                                        
                      <div class="thumb">
                        <div class="thumb-overlay"> 
                          <i class="zmdi zmdi-playlist-audio"></i>
                        </div>
                        <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['image']; ?>">                
                      </div>
                      <div class="name  truncate title">
                        <?php echo $value['name']; ?> 
                        <div class="text-muted"><?php echo __("label_playlist"); ?></div>
                      </div>
                      </a>
                    </li>
                    <?php
                }
                ?>   
                
            </ul>    
              
    </div>
     <?php } ?>
</div>


<div class="col-md-12 tab div-thumb-c" id="albums">
    
     <div class="filter-generic col-md-4 pull-right">
        <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
      </div> 
      <div class="clearfix"></div>
    <?php 

    foreach ($data['albums'] as $key => $value) { 
      if($value['release_date'] == '')
         $value['release_date'] = '&nbsp;';
      ?>
      
        <div class="col-lg-2 col-md-3 list-thumb-c filter-me">
              <div class="thumbnail list-thumb contextMenu" data-id="<?php echo $value['id']; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-title="<?php echo $value['album']; ?>" data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-type="album">
                <div class="image">
                    <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
                    <div class="overlay">
                       <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo $value['artist']; ?>/<?php echo $value['album']; ?>?play=1"><i class="btn-play-album zmdi zmdi-play"></i></a>
                    </div>
                </div>
                <div class="data">
                    <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/<?php echo slug($value['album']); ?>" class="name truncate" title="<?php echo $value['album']; ?>"><?php echo $value['album']; ?></a>
                    <div class="subdata truncate"><?php echo $value['release_date']; ?></div>                    
                </div>
            </div>
        </div>
      <?php
      }
      ?>

</div>

<div class="col-md-12 tab div-thumb-c" id="similar">
    
 

  <div class="col-md-12 div-thumb-c">   
    <!-- Artist -->     
      <?php 
     
      echo render_artist($similar);
     
        ?>
  </div>

</div>
<div class="col-md-12 tab" id="about">
    
 

 <div class="jumbotron text-justify">
  <p>
    <?php echo $data['info']['bio'];?>
 </p>
 </div>

</div>

