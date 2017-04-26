<div id="open-playlist-page"></div>
<?php if(count($playlists) == 0){ ?>
<div class="error" >                               
	<h1 style="font-size:90px"><i class="zmdi zmdi-collection-music"></i></h1>
	<h2><?php echo __("label_library_empty"); ?></h2>
	<p><?php echo __("label_library_empty_description"); ?></p>                           
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create-playlist"><?php echo __("label_new_playlist"); ?></button>
</div>
<?php }else{ ?>
<div class="col-md-12">
<?php echo get_ads("ads1",'col-md-8 padding-top-20 padding-bottom-20'); ?>   

  <div class="filter-generic col-md-4 pull-right">
  <br>
      <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div>   
</div>
<div class="clearfix"></div>

<div class="col-lg-2 col-md-4 list-thumb-c filter-me ">
        <div class="thumbnail list-thumb" >
            <div class="image">
                <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png">                
                <div class="overlay">
                    <a href="#"><i class="btn-gen btn-new-playlist zmdi zmdi-plus" ></i></a>
                </div>
            </div>
            <div class="data">                      
                <a href="" class="name truncate btn-new-playlist" title="<?php echo __("label_new_playlist"); ?>"><?php echo __("label_new_playlist"); ?></a>                       
            </div>
        </div>
    </div>


<?php 
echo render_playlists($playlists);
}
?>