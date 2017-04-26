
<div class="col-md-12 visible-md visible-lg">



   <div class="filter-generic col-md-4  col-xs-12 pull-right">
      <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div> 
</div>
<br>


<div class="col-md-12">   
    <?php echo get_ads("ads1",'col-md-12 text-center padding-top-20 padding-bottom-20'); ?>                       
    <div class="clearfix"></div>
    <br>
      
    <?php     
         foreach ($genres as $key => $value) {           
            ?>
            <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>/<?php echo urlencode(normalize_name($value['name'])); ?>">
             <div class="filter-me col-xs-6 col-lg-2 col-md-4 list-thumb-c">
              <a class="thumbnail list-thumb genres " href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>/<?php echo urlencode(normalize_name($value['name'])); ?>">
              
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo base_url()."uploads/genres/".mb_strtolower(normalize_name($value['name'])); ?>.jpg">                
                      <span><?php echo (mb_strtoupper(mb_strtolower($value["name"],'UTF-8'),'UTF-8')); ?></span>    
                      <div class="overlay">
                          

                      </div>
                  </div>
                  
                  
                      
                    
                  
              
              </a>
          </div>
        </a>
            <?php
        }
        ?>           
   
</div>

<div class="clearfix"></div>