
 <nav id="sidebar-wrapper" class="navbar navbar-default">
            <ul class="sidebar-nav nav navbar-nav">
                <li class="sidebar-brand menu-toggle cursor-pointer btn-link" data-href="<?php echo base_url(); ?>">                    
                    <img src="<?php echo base_url(); ?><?php echo config_item("logo"); ?>" class="brand">
                  
                </li>
                <li class="search">                    
                    <input type="search" class="input-search form-control" value="<?php echo $this->input->get("s"); ?>" placeholder="<?php echo __("label_search"); ?>">
                  
                </li>
          
              
                
               
                <li class="main truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_station'); ?>/"><i class="zmdi zmdi-radio"></i> <?php echo __("label_stations"); ?></a>
                </li>
                <li class="main truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_trending'); ?>/"><i class="zmdi zmdi-trending-up"></i> <?php echo __("label_trending"); ?></a>
                </li>
                <li class="main truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_top_playlist'); ?>/"><i class="zmdi zmdi-playlist-audio"></i> <?php echo __("label_top_playlist"); ?></a>
                </li> 
                <li class="main truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_new_releases'); ?>/"><i class="zmdi zmdi-collection-music "></i> <?php echo __("label_new_releases"); ?></a>
                </li>
                <li class="main truncate visible-md visible-lg">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>/"><i class="zmdi zmdi-tag"></i> <?php echo __("label_genres"); ?></a>
                </li>
                <?php if($pages > 0){ ?>
                <li class="main truncate visible-md visible-lg">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_pages'); ?>/"><i class="zmdi zmdi-google-pages"></i> <?php echo __("label_pages"); ?></a>
                </li>
                <?php } ?>
                <li class="main truncate btn-now-playing">
                    <a  class="truncate"  href="#"><i class="zmdi zmdi-play-circle-outline"></i> <?php echo __('label_now_playing'); ?>  <span id="count-now-playing" class="badge badge-success">0</span></a>
                    <div id="bars" class="icon">
                        <div class='bars'>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                          <div class='bar'></div>
                        </div>
                    </div>
                </li>

                <?php if(is_logged()){ ?>
                  <li class="main truncate user">
                      <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_user'); ?>/<?php echo $this->session->userdata['user']['username']; ?>">
                      <img class="me-avatar" src="<?php echo avatar($this->session->userdata['user']['avatar']); ?>">                            
                      <?php echo $this->session->userdata['user']['username']; ?> </a>
                      

                  </li> 
                  <?php if(is_admin())
                  {
                    ?>
                     <li class="main truncate btn-default">
                      <a class="truncate exclude" href="<?php echo base_url(); ?>admin/dashboard">                      
                        <i class="zmdi zmdi-lock text-warning"></i> Go to Admin
                       </a>
                    </li> 
                  <?php
                  }
                  ?>
                  <?php }else{ ?>
                  <li class="truncate" style="padding:10px">
                     
                        <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_login'); ?>" class="btn btn-success btn-block" style="font-weight:bold"><?php echo __("label_login"); ?></a>
                      
                  </li>

                  <?php } ?>
                 
               
                <li class="title truncate">
                    <a class="truncate" href="#"><?php echo __("label_my_music"); ?> <i class="pull-right"></i></a>
                </li>
             
                <li class="sub truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_my_playlist'); ?>"><i class="zmdi zmdi-playlist-audio"></i> <?php echo __("label_my_playlists"); ?></a>
                </li>  
                <?php if(is_spotify()) { ?>
                <li class="sub truncate ">
                    <a class="truncate " href="<?php echo base_url(); ?>spotify/playlist"><i class="text-success fa fa-spotify"></i> <?php echo __("label_my_playlists_spotify"); ?></a>
                </li> 
                 <?php } ?>

                <li class="sub truncate">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_my_favorites'); ?>/"><i class="zmdi zmdi-favorite"></i> <?php echo __("label_my_favorites"); ?></a>
                </li> 

                <li class="sub truncate hide">
                    <a class="truncate" href="<?php echo base_url(); ?>"><i class="fa fa-thumbs-up"></i> <?php echo __("label_recommended"); ?></a>
                </li>
                 <li class="sub truncate hide">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_chat_room'); ?>"><i class="zmdi zmdi-comments"></i> <?php echo __("label_chat_room"); ?></a>
                </li> 

              
               <li class="sub truncate hide">
                    <a class="truncate" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_chat_room'); ?>"><i class="zmdi zmdi-circle-o"></i> <?php echo __("label_chat_room"); ?></a>
                </li> 
             

                <li class="place-video"></li>
             
               
            </ul>
        </nav>


                    