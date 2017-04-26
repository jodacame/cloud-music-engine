
<div class="header">
  <div class="visible-lg visible-md sub-title float-title truncate">  
  <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $track["picture_medium"]; ?>">
    <?php if(!$track['nofound']){ ?>
      <span class="st"><a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo urlencode($track["artist"]); ?>"><?php echo $track["artist"]; ?></a> > <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo urlencode($track["artist"]); ?>/<?php echo urlencode($track["album"]); ?>"><?php echo $track["album"]; ?></a></span>
    <?php } ?>
    <h1 class="t"><?php echo $track["track"]; ?></h1>
    <span class="block">      


      <button class="btn btn-success btn-md btn-play btn-green" data-id="<?php echo $track["id"]; ?>" data-track="<?php echo $track['track']; ?>"  data-album="<?php echo $track['album']; ?>" data-artist="<?php echo $track['artist']; ?>" data-image="<?php echo $track['picture_medium']; ?>" data-type="track"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>      
      <button class="btn btn-success btn-md btn-start-discover btn-green" data-track="<?php echo $track["track"]; ?>" data-title="<?php echo $track["track"]; ?>" data-artist="<?php echo $track["artist"]; ?>" data-subtitle="<?php echo $track["artist"]; ?>" data-album="<?php echo $track["album"]; ?>" data-image="<?php echo $track["picture_medium"]; ?>" data-type="track" ><i class="zmdi zmdi-portable-wifi"></i> <?php echo __("label_discover"); ?></button>                  
      <?php if(config_item("download_button") ==1 || (config_item("download_button") == 2 && is_logged())){ ?>
        <button class="btn btn-default btn-md btn-buy btn-2" data-id="<?php echo $track["id"]; ?>" data-track="<?php echo $track['track']; ?>"  data-album="<?php echo $track['album']; ?>" data-artist="<?php echo $track['artist']; ?>" data-image="<?php echo $track['picture_medium']; ?>" data-type="track"><i class="zmdi zmdi-download"></i> <?php echo __("label_download"); ?></button>      
      <?php } ?>
      
      <?php echo getLikeButton(3,getUserID(),$track['idtracks'],$track['likes']); ?>        
      <button class="btn btn-default btn-md btn-default btn-share" data-track="<?php echo $track["track"]; ?>" data-title="<?php echo $track["track"]; ?>" data-artist="<?php echo $track["artist"]; ?>" data-subtitle="<?php echo $track["artist"]; ?>" data-album="<?php echo $track["album"]; ?>" data-image="<?php echo $track["picture_medium"]; ?>" data-type="track" ><i class="zmdi zmdi-share"></i></button>            
    </span>

  </div>
  <div class="coverblur lazy" data-original="<?php echo $track["picture_extra"]; ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover text-center">
      <div class="visible-xs visible-sm">
        <h1><?php echo $track["artist"]; ?></h1>
        <h2><?php echo $track["track"]; ?></h2>
      </div>
     <?php echo get_ads("ads1",'col-md-6 pull-right padding-top-20 padding-bottom-20'); ?>                       
  </div>
</div>


<div class="col-md-12">


    <div class="col-md-7 tab active text-center" id="lyrics">  
        <?php echo get_ads("ads3",'col-md-12  padding-top-20 padding-bottom-20'); ?>
        <div>
        <br><br>
            <h1 class="title"><?php echo __("label_lyric"); ?></h1>            
            <p style="font-size:16px;line-height:25px;">
               <?php echo $lyric; ?>               
            </p>
        </div>
        
    </div>
      <div class="col-md-5"> 
        <div class="col-md-12">
            <h2 class="title"><?php echo __("label_video"); ?></h2>
            <div class="col-md-12" style="padding:0px;">
              <div style="border:0px solid rgba(0,0,0,1);border-radius:0px;position: relative;  padding-bottom: 56.25%; /* 16:9 */  padding-top: 25px;  height: 0;">
                <iframe width="560" height="349" style="border:0px;position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;" src="//www.youtube.com/embed/<?php echo $video; ?>">
                </iframe>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
      </div>

    <div class="col-md-5">                       
          <div class="col-md-12">
                <?php if($stations){ ?>
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
              
                <?php } ?>

                </div>
         <br><br>
            

       <?php if(count($tracks)>0){ ?>
       <div class="col-md-12">           
         <h2 class="title"><?php echo __("label_more_tracks"); ?></h2>            
            <?php echo get_ads("ads2",'col-md-12  padding-top-20 padding-bottom-20'); ?>
            <div class="clearfix"></div>
              <ul class="list-group style2 d ">
            <?php     

                foreach ($tracks as $key => $value) {
                  if($key==10)
                    break;
                    ?>
                    <li class="list-group-item style2 d contextMenu" data-mbid="<?php echo $value["mbid"]; ?>" data-id="<?php echo $value["id"]; ?>" data-source="<?php echo $value["source"]; ?>" data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-track="<?php echo $value['track']; ?>" data-subtitle="<?php echo __("label_track"); ?>" data-title="<?php echo $value['track']; ?>"data-image="<?php echo $value['picture_medium']; ?>" data-type="playlist">                                                
                      <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo $value['artist']; ?>/<?php echo $value['album']; ?>/<?php echo $value['track']; ?>">                                                                        
                      <div class="thumb">
                        <div class="thumb-overlay"> 
                          <i class="zmdi zmdi-format-align-center"></i>
                        </div>
                        <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
                      </div>
                      <div class="name  truncate title">
                        <?php echo $value['track']; ?> 
                        <div class="text-muted"><?php echo $value['album']; ?></div>
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
</div>
<?php if(count($similar)>1){ ?>
        <div class="col-md-12 text-left">
         <h2 class="title"><?php echo __("label_track_similar_name"); ?></h2>
        <?php echo gui_tracks($similar); ?>
        </div>
        <?php } ?>
