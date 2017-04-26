  <?php if($stations_genre){ 
    foreach ($stations_genres as $key => $value) {      
      if($value['name'] == $stations_genre)
      {

          $current = $value;
      }

    }
    ?>
<div class="header" >
  <div class="visible-lg visble-md sub-title float-title truncate">  
  <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url().$current['image']; ?>">
    <span class="st"> <a itemprop="url" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>"><?php echo __("label_station"); ?></a></span>
    <h1 class="t"><?php echo $stations_genre; ?></h1>    

  </div>
  <div class="coverblur lazy" data-original="<?php echo base_url(). $current['image'];  ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover">
      <?php echo get_ads("ads1",'col-md-6 text-center  pull-right padding-top-20'); ?>
      <h2 class="text-center visible-xs visble-sm "><?php echo $stations_genre; ?></h2>
  </div>
</div>
<?php }else{ ?>

  <div class="col-md-12">
    <h2 class="pull-left"><i class="zmdi zmdi-radio text-success"></i> <?php echo __("label_popular_stations"); ?></h2>
    
     <div class="filter-generic col-md-4  col-xs-12 pull-right">
        <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
      </div> 
  
  
    

  </div>
  <br>
  <?php } ?>
  <div class="clearfix"></div>
  <br>

<div class="col-md-9">
  


      <?php foreach ($stations->result_array() as $value) {       
        ?>      
      
          <div class="filter-me col-xs-6  col-lg-3 col-md-6 list-thumb-c">
              <div class="thumbnail list-thumb contextMenu"  data-stationid="<?php echo $value["idstation"]; ?>" data-subtitle="<?php echo __("label_station"); ?>"  data-title="<?php echo $value["title"]; ?>"  data-image="<?php echo base_url().$value["cover"]; ?>" data-type="station">
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url().$value['cover']; ?>">                
                      <div class="overlay">
                         <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo urlencode($value["genre"]); ?>/<?php echo $value["title"]; ?>-<?php echo $value["idstation"]; ?>?play=1"><i class="cursor-pointer zmdi zmdi-play btn-play-album"></i></a>
                      </div>
                  </div>
                  <div class="data">                    
                      <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo urlencode($value["genre"]); ?>/<?php echo $value["title"]; ?>-<?php echo $value["idstation"]; ?>" class="name truncate" title="<?php echo $value["title"]; ?>"><?php echo $value["title"]; ?></a>                     

                  </div>
              </div>
          </div>
        <?php
        }
    
        ?>

<div class="clearfix"></div>
  
</div>



  <!-- Category Stations -->

<div class="col-md-3">   
    <?php echo get_ads("ads1",'col-md-12 text-center padding-top-20 padding-bottom-20'); ?>                       
      <div class="clearfix"></div>
       <ul class="list-group style2 ">           
          

    <?php     

         foreach ($stations_genres as $key => $value) { 
            ?>
            <li class="filter-me list-group-item style2 " >                                                
              <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/<?php echo urlencode($value['name']); ?>">                                                                        
              <div class="thumb">
                <div class="thumb-overlay"> 
                  <i class="zmdi zmdi-collection-music"></i>
                </div>
                <img class="lazy" src="<?php echo base_url().$value['image']; ?>">                
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
