<?php echo get_tabs_trending(); ?>

<div class="col-md-12">	
<?php echo get_ads("ads1",'col-md-6 pull-left'); ?>		
 	<div class="filter-generic col-md-4 pull-right">
    	<input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div>   
 </div>
<div class="clearfix"></div>
<br>

<div class="tab active" id="target-custom">
	<div class="div-thumb-c col-md-12">  
		
	    <?php echo gui_tracks_thumb($trending); ?>	      
	</div>
</div>