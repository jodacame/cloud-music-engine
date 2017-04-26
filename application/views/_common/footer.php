    <div id="loading">
          <div class="vertical-centered-box">
  <div class="content">
    <div class="loader-circle"></div>
    <div class="loader-line-mask">
      <div class="loader-line"></div>
    </div>
    
  </div>
</div>
    </div>
    <div id="loading-overlay" class="hide"></div>






<div id="menu-music"  class="dropdown-menu"  >
 <div class="header">
                    <div class="image"></div>
                  <h2 class="truncate"></h2>
                    <h3 class="truncate"></h3>
                </div>
                
                <div class="list-group" style="position:relative;overflow:hidden">
                  <a class="hide list-group-item only-track btn-play" href="#"><i class="zmdi zmdi-play-circle-outline"></i> <?php echo __("label_play"); ?></a>                  
                  <?php if(is_logged()){ ?>
                  <a class="hide list-group-item only-track no-close btn-add-to" href="#"><i class="zmdi zmdi-collection-music"></i> <?php echo __("label_add_to_playlist"); ?></a></li>                                                             
                  <?php } ?>
                  <a class="hide list-group-item only-track btn-add-to-playlist" href="#"><i class="zmdi zmdi-playlist-plus"></i> <?php echo __("label_add_to_queue"); ?></a>
                  <?php if(is_logged()){ ?>
                  <a class="hide list-group-item only-track  only-album  only-artist  btn-to-favorite" href="#"><i class="zmdi zmdi-favorite-outline"></i> <?php echo __("label_add_to_favorite"); ?></a>                  
                  <?php } ?>
                  <a class="hide list-group-item only-artist only-track only-album btn-start-discover" href="#"><i class="zmdi zmdi-portable-wifi"></i> <?php echo __("label_discover"); ?></a>                  
                  <?php if(config_item("download_button") ==1 || (config_item("download_button") == 2 && is_logged())){ ?>
                  <a class="hide list-group-item only-track only-album btn-buy" href="#"><i class="zmdi zmdi-download"></i> <?php echo __("label_download"); ?></a>                  
                  <?php } ?>

                  <a class="hide list-group-item only-all btn-share" href="#"><i class="zmdi zmdi-share"></i> <?php echo __("label_share"); ?></a>                  
                  
                  
                  <!--<a class="hide list-group-item only-artist only-track only-playlist only-station btn-share-this" href="#"><i class="zmdi zmdi-code"></i> <?php echo __("label_get_embed_code"); ?></a>-->
                  <a class="hide list-group-item only-search btn-search" href="#"><i class="zmdi zmdi-search"></i> <?php echo __("label_search"); ?></a>
                  <div id="playlist-menu" class="well well-sm">
                  <div class="list-group scroll">
                      <a class="hide list-group-item only-track no-close  btn-playlist-menu-hide" href="#" style="border-bottom:1px solid rgba(255,255,255,.05)"><i class="zmdi zmdi-arrow-left" ></i> <?php echo __("label_back"); ?></a>                      

                      <span class="playlist-target">                      
                      </span>

                      <a class="hide list-group-item only-track  btn-new-playlist" href="#"><i class="zmdi zmdi-plus"></i> <?php echo __("label_new_playlist"); ?></a>
                  </div>
                </div>
                <a class="visible-sm visible-xs list-group-item  hide only-all" href="#"><i class="zmdi zmdi-close"></i> <?php echo __("label_close"); ?></a>                  

                </div>


</div>


<!-- MODAL BUY BUTTON -->
<!-- Modal -->
<div class="modal fade" id="modal-buy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <div class="modal-title truncate">        

          <i class="fa fa-download"></i> <span id="d-title"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <!--<img style="width:100%;margin:0px;" class="thumbnail" src="#" id="d-image" class="pull-left">-->
        </div>
      </div>
      <div class="modal-body">            
            <div class="list-group">
              <?php 
                echo get_download_button('amazon','Amazon');
                echo get_download_button('apple','iTunes');
                echo get_download_button('youtube','Youtube');
                echo get_download_button('soundcloud','Soundcloud');
                echo get_download_button('spotify','Spotify');
              ?>
              
            </div>
              
            
      </div>      
    </div>
  </div>
</div>



<!-- MODAL LANGUAGES -->
<!-- Modal -->
<div class="modal fade" id="modal-langs" tabindex="-1" role="dialog" aria-labelledby="Langs">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <div class="modal-title truncate">        
          <i class="fa fa-language" aria-hidden="true"></i> <?php echo __("label_language"); ?>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>          
        </div>
      </div>
      <div class="modal-body">            
            <div class="list-group">
              <?php foreach (config_item("langs") as $key => $value) {
                ?><a class="list-group-item external exclude" href="?lang=<?php echo $value["code"]; ?>">
                <div  class="flag flag-<?php echo mb_strtolower($value["code"]); ?>" style="display:inline-block"></div>
                <?php echo $value["name"]; ?></a><?php
              }
              ?>
            </div>         
      </div>      
    </div>
  </div>
</div>

<!-- MODAL SHARE BUTTON -->
<!-- Modal -->
<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title"><i class="hide zmdi zmdi-share"></i> <span><?php echo __("label_share"); ?></span></h5>

      </div>
      <div class="modal-body">
           <input type="url" class="form-control">
           <br>
           <div class="pull-left">
              <div class="checkbox">
                <label>
                  <input checked="checked" id="autoplay" type="checkbox"> <?php echo __("label_autoplay"); ?>
                </label>
              </div>
           </div>
           <div class="pull-right">
            <strong><?php echo __("label_share"); ?></strong>
            <a  target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={url}" class="btn-share-link btn azm-social azm-size-32  azm-facebook exclude external"><i class="fa fa-facebook"></i></a>
            <a  target="_blank" href="https://twitter.com/home?status={url}" class="btn-share-link btn azm-social azm-size-32  azm-twitter exclude external"><i class="fa fa-twitter"></i></a>
            <a  target="_blank" href="https://plus.google.com/share?url={url}" class="btn-share-link btn azm-social azm-size-32  azm-google-plus exclude external"><i class="fa fa-google-plus"></i></a>            
          </div>
            <div class="clearfix"></div>
      </div>      
    </div>
  </div>
</div>


<!-- MODAL CREATE PLAYLIST -->
<!-- Modal -->
<div class="modal fade" id="modal-create-playlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="zmdi zmdi-collection-music"></i> <?php echo __("label_new_playlist"); ?></h4>
      </div>
      <div class="modal-body">
           
              
              <div class="form-group">                
                <input type="text" class="form-control"  maxlength="50" id="input-name-playlist" placeholder="<?php echo __("label_name_playlist"); ?>">
              </div>              
              
              
            
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-xs btn-success btn-save-playlist"><?php echo __("label_save_playlist"); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT PLAYLIST -->
<!-- Modal -->
<div class="modal fade" id="modal-edit-playlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form onsubmit="return false" name="photo" id="imageUploadFormCover"  method="post">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="zmdi zmdi-collection-music"></i> <?php echo __("label_edit_playlist"); ?></h4>
      </div>
      <div class="modal-body">
       
               <div class="col-md-12">
                 <img class="img-responsive img-thumbnail btn-upload-cover-playlist cursor-pointer"  style="width:100%" src="<?php echo base_url(); ?>assets/images/no-picture.png">

                      <div style="position:absolute;top:10px;left:25px;" class="btn-upload-cover-playlist btn btn-default btn-xs"><i class="fa fa-upload"></i> <?php echo __("label_change_cover"); ?></div>
                        

               </div>
               <div class="col-md-12">
                  <br>
                  <div class="form-group">

                        <input class="hide" accept="image/*" type="file" id="ImageBrowseCover"   name="image" />                                    
                        <input required  type="text" class="form-control" name="name" value="" placeholder="<?php echo __("label_name_playlist"); ?>">
                        <input  type="hidden" class="form-control hide" required name="idplaylist" value="">
                  </div>
                   

                   
                   
                    
                  </div>
                  <div class="clearfix"></div>
               </div>
        
              
          
              
            
      </div>
      <div class="modal-footer">        
        <button type="submit" name="updatepl" class="btn btn-block btn-success btn-update-playlist"><?php echo __("label_update_playlist"); ?></button>
      </div>
    </div>
  </div>
  </form>
</div>
<!-- END MODAL EDIT PLAYLIST -->

<div id="noty" class="alert alert-success">
  <div class="picture">
  <img src="">
  </div>
  <div class="data">
      <strong class="truncate"></strong>
      <span class="truncate"></span>
  </div>
  <div class="clearfix"></div>
</div>

<?php
if(strpos(mb_strtolower(base_url()),"nexxuz") !== false)
{
  ?>
  <a id="buy-now"  title="Do you want this script?" style="z-index:9999999;box-shadow: 1px 1px 3px rgba(0,0,0,.2); display:none;border:0px;position: absolute;left:20px;bottom:60px;border-radius: 3px " href="https://nexxuz.com/buy"><img  alt="Buy Nexxuz Now" style="border-radius: 3px" src="https://dl.dropboxusercontent.com/u/5404672/Imagenes%20Web/buy-now.png"></a>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      setTimeout(function(){ 
        $("#buy-now").fadeIn();
      }, 3000);
    });
  
  
  </script>
  <?php
}
?>
  
  <!--<link href="<?php echo base_url() ?>assets/css/custom.php?a=<?php echo urlencode(config_item("main_color")); ?>&b=<?php echo urlencode(config_item("secondary_color")); ?>&c=<?php echo urlencode(config_item("default_color")); ?>&d=<?php echo urlencode(config_item("text_color")); ?>&e=<?php echo urlencode(config_item("text_color_hover")); ?>&f=<?php echo urlencode(config_item("color_success")); ?>" rel="stylesheet">-->
  <!-- <link href="<?php echo base_url(); ?>assets/themes/<?php echo $this->config->item('color_scheme'); ?>/style.css" rel="stylesheet">-->
  <!-- Custom CSS -->
  <link href="<?php echo base_url() ?>assets/css/theme.css?c=<?php echo date("YmdHms"); ?>" rel="stylesheet">  
  <link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet">
  
  

    <!-- jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <!--<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>-->
    
   



    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <!-- jPlayer -->
    <script src="<?php echo base_url(); ?>assets/js/jplayer/jplayer/jquery.jplayer.js"></script>    
    <!-- YOUTUBE -->
  
    <script src="<?php echo base_url(); ?>assets/js/youtube.js"></script>
  
    <!-- MP3 -->
    <script src="<?php echo base_url(); ?>assets/js/audio.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>    
    <!--<script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.min.js"></script>-->
    <!--<script src="<?php echo base_url(); ?>assets/js/jquery-ajax-localstorage-cache.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-contextmenu.js"></script>
    <script async src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
    <!--<script src='https://www.google.com/recaptcha/api.js'></script>-->
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js'></script>


  

<?php if(config_item("ga")){ ?>
<script>
var _gaq=[["_setAccount","<?php echo config_item("ga"); ?>"],["_trackPageview"]];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
s.parentNode.insertBefore(g,s)}(document,"script"));
</script>
<?php } ?>

