  
      
<div id="station-page" class="header contextMenu" data-title="<?php echo $station["title"]; ?>" data-subtitle="<?php echo __("label_station"); ?>"  data-stationid="<?php echo $station["idstation"]; ?>" data-image="<?php echo base_url().$station["cover"]; ?>" data-type="station">
  <div class="visible-md visible-lg sub-title float-title truncate">  
  <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url().$station['cover']; ?>">
    <span class="st " itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
      <a itemprop="url" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>"><?php echo __("label_station"); ?></a> >
      <a itemprop="url" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo $station['genre']; ?>"><?php echo $station['genre']; ?></a>
    </span>    
    <h1 class="t"><?php echo $station['title']; ?></h1>
    <span class="block">      
      <button class="btn btn-success btn-md btn-play btn-green play-<?php echo $autoplay; ?>" data-name="<?php echo $station["title"]; ?>" data-stationid="<?php echo $station['idstation']; ?>" data-image="<?php echo base_url().$station["cover"]; ?>" data-type="station"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>
      <button class="btn btn-default btn-md btn-share" data-title="<?php echo $station["title"]; ?>" data-subtitle="<?php echo __("label_station"); ?>"  data-stationid="<?php echo $station["idstation"]; ?>" data-image="<?php echo base_url().$station["cover"]; ?>" data-type="station"><i class="zmdi zmdi-share"></i></button>
      <?php echo getLikeButton(5,getUserID(),$station['idstation'],$station['likes']); ?>        
    </span>

  </div>
  <div class="coverblur lazy" data-original="<?php echo base_url().$station["cover"]; ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover text-center">
      <div class="visible-xs visible-md">
        <h2><?php echo $station['title']; ?></h2>
        <button class="btn btn-success btn-md btn-play btn-green play-<?php echo $autoplay; ?>" data-name="<?php echo $station["title"]; ?>" data-stationid="<?php echo $station['idstation']; ?>" data-image="<?php echo base_url().$station["cover"]; ?>" data-type="station"><i class="zmdi zmdi-play"></i> <?php echo __("label_play"); ?></button>
      </div>

   <?php echo get_ads("ads1",'col-md-8 pull-right padding-top-20 padding-bottom-20'); ?>                       
  </div>
</div>
<div class="col-md-9">

<div class="tab active" id="overview">
    <div class="col-md-12">   
        <div style="padding:30px;padding-top:10px;font-size:18px;line-height:30px">
          <p><?php echo makeClickableLinks(strip_tags($station['description'])) ; ?></p>
        </div>
                                  
    </div>
    
    
    <div class="col-md-<?php if(strlen(trim(strip_tags($lyric) )) > 200){ echo '9'; } else{ echo '12'; } ?>">
    <?php gui_tracks_station($tracklist,$station['idstation']);  ?>   
    </div>
    <?php if(strlen(trim(strip_tags($lyric) )) > 200){ ?>
    <div class="col-md-3 text-center">
      <?php echo $lyric; ?>
    </div>
    <?php } ?>
   
</div>



</div>
 <div class="col-md-3">    
          <?php echo get_ads("ads2",'col-md-12 text-center padding-top-20 padding-bottom-20'); ?>                       
            <div class="clearfix"></div>                   
            <ul class="list-group style2 ">           
          

    <?php     

         foreach ($stations_genres as $key => $value) { 
            ?>
            <li class="list-group-item style2 " >                                                
              <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo urlencode($value['name']); ?>">                                                                        
              <div class="thumb">
                <div class="thumb-overlay"> 
                  <i class="zmdi zmdi-collection-music"></i>
                </div>
                <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url().$value['image']; ?>">                
              </div>
              <div class="name title"><span class="text-muted"><?php echo $value['name']; ?></span></div>
              </a>
            </li>
            <?php
        }
        ?>   
          <li class="hide list-group-item style2" >                                                
              <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>">                                                                        
              <div class="thumb">
                <div class="thumb-overlay"> 
                  <i class="zmdi zmdi-collection-music"></i>
                </div>
                <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" >                
              </div>
              <div class="name title"><span class="text-muted"><?php echo __("all_stations"); ?></span></div>
              </a>
            </li>
    </ul>    
    </div>
