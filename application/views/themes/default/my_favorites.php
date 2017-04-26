<div class="col-md-12 ">  
    <div class="c">
    	<div class="navbar navbar-default">
	        <ul class="tabs tabs-ajax nav navbar-nav">	            
	            <li class="active" data-method="favorites_tracks" data-href="#target-custom"><a href="#"><i class="fa fa-music"></i> <?php echo __("label_tracks"); ?> </a></li>            
	            <li data-method="favorites_artists" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-male-female"></i> <?php echo __("label_artists"); ?> </a></li>	           
	            <li data-method="favorites_albums" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-collection-music"></i> <?php echo __("label_albums"); ?> </a></li>	            	            
	            <li data-method="favorites_playlists" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-playlist-audio"></i> <?php echo __("label_playlists"); ?> </a></li>	            
	            <li data-method="favorites_stations" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-portable-wifi"></i> <?php echo __("label_stations"); ?> </a></li>            	           	            	        
	                    	           	            	        

	        </ul>
	    </div>
    </div>
</div>  
<div class="col-md-12">
	<?php echo get_ads("ads2",'col-md-8 padding-top-20 padding-bottom-20'); ?>   
 	<div class="filter-generic col-md-4 pull-right">
    	<input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div>   
 </div>
<div class="clearfix"></div>
<br>
<div class="tab active" id="target-custom">
	<?php echo gui_tracks($tracks);						?>
</div>
