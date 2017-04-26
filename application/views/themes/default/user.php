    
      
<div class="header">
  <div class="sub-title float-title truncate">  
  <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo avatar($user['avatar'],date("YmdHis")); ?>">
    <span class="st"><?php echo $user['names']; ?></span>
    <h1 class="t"><?php echo $user['username']; ?></h1>   
    <span class="block"> 
     <?php if($me){ ?>
         <div class="btn-upload-avatar btn-2"><?php echo __("label_upload_picture"); ?></div>
         <form onsubmit="return false" name="photo" id="imageUploadForm"  class="hide" method="post">
          <input accept="image/*" type="file" id="ImageBrowse"   name="image" />          
          <button type="submit" name="asdasd" value="1"></button>
      </form>
      <?php }else{ ?>
      <?php echo getLikeButton(6,getUserID(),$user['id'],$user['likes']); ?>        

      
      <?php } ?>
    </span>
     <div class="pull-right">     
      <?php echo get_social_icon($user['facebook_url'],'facebook'); ?>
      <?php echo get_social_icon($user['twitter_url'],'twitter'); ?>
      <?php echo get_social_icon($user['google_plus_url'],'google_plus','google-plus','google-plus'); ?>
      <?php echo get_social_icon($user['spotify_url'],'spotify'); ?>
      <?php echo get_social_icon($user['website_url'],'website','link','apple'); ?>
      
      
    </div>
  </div>
  <div class="coverblur lazy" data-original="<?php echo avatar($user['avatar'],date("YmdHis")); ?>" style="background-image: url('<?php echo base_url(); ?>assets/images/no-picture.png')"></div>
  <div class="overlay-cover"> 
  <?php echo get_ads("ads1",'col-md-4  padding-top-20 pull-right padding-bottom-20'); ?>
  </div>
</div>
<div class="col-md-12">  
    <div class="c">
        <div class="navbar navbar-default">
            <ul class="tabs-ajax tabs nav navbar-nav">                                
              <li class="active" data-method="user_history?id=<?php echo $user['id']; ?>" data-href="#target-custom"><a href="#"><?php echo __("label_history"); ?></a></li>            
              <?php if(is_logged()){ ?>
              <li  data-method="user_playlists?id=<?php echo $user['id']; ?>" data-href="#target-custom"><a href="#"><?php echo __("label_playlists"); ?></a></li>            
              <li  data-method="user_followers?id=<?php echo $user['id']; ?>" data-href="#target-custom"><a href="#"><?php echo __("label_followers"); ?></a></li>           
              <li  data-method="user_following?id=<?php echo $user['id']; ?>" data-href="#target-custom"><a href="#"><?php echo __("label_following"); ?></a></li>   
                <?php if($me){ ?>
                <li data-method="user_settings" data-href="#target-custom"><a href="#"><i class="fa fa-gear"></i> <?php echo __("label_settings"); ?></a></li>            
                <!--<li  data-method="dashboard" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-view-dashboard"></i> <?php echo __("label_dashboard"); ?></a></li>   -->
                <li  class="logout"><a class="exclude text-important" href="<?php echo base_url(); ?><?php echo $this->config->item('slug_logout'); ?>/"><strong><i class="fa fa-sign-out"></i> <?php echo __("label_logout"); ?></strong></a></li>                                            
                <?php } ?>
              <?php } ?>
          </ul>
        </div>
    </div>
</div>  
<div class="col-md-12">   
    <div class="tab active" id="target-custom">  
    <?php echo gui_tracks_thumb($history); ?>
    </div>
  
</div>
