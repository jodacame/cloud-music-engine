<?php 
		$total_result = count($tracks)+count($artist)+count($albums) +count($lyrics) +count($playlists)+count($stations) +count($users);

		
		if($total_result==0)
		{
			?>
			<div class="error" >      
				<h1 style="font-size:90px"><i class="zmdi zmdi-search"></i></h1>                         				
				<h2><?php echo __("label_no_found"); ?> "<?php echo $query; ?>" </h2>
				<p><?php echo __("label_no_found_description"); ?></p>                           				
			</div>
			<?php
			return false;
		}
	?>


<div class="col-md-12 visible-lg visible-md">  
<?php echo get_ads("ads1",'col-md-6 padding-top-20 pull-right padding-bottom-20'); ?>   
    <div class="sc">

    	<h2><?php echo __("label_result_for"); ?> <strong class="text-success">"<?php echo $query; ?>"</strong></h2>
    	<br>
    	<div class="navbar navbar-default">
	        <ul class="tabs nav navbar-nav">
	            <li class="active" data-href="#all"><a href="#"><i class="zmdi zmdi-folder-star-alt"></i> <?php echo __("label_all"); ?></a></li>
	            <?php if(count($tracks) >0){ ?>
	            <li data-href="#tracks"><a href="#"><i class="fa fa-music"></i> <?php echo __("label_songs"); ?> <span class="label label-inverse"><?php echo count($tracks); ?></span></a></li>            
	            <?php } ?>
	            <?php if(count($artist) >0){ ?>
	            <li data-href="#artist"><a href="#"><i class="zmdi zmdi-male-female"></i> <?php echo __("label_artists"); ?> <span class="label label-inverse"><?php echo count($artist); ?></span></a></li>
	            <?php } ?>
	            <?php if(count($albums) >0){ ?>
	            <li data-href="#albums"><a href="#"><i class="zmdi zmdi-collection-music"></i> <?php echo __("label_albums"); ?> <span class="label label-inverse"><?php echo count($albums); ?></span></a></li>
	            <?php } ?>
	            <?php if(count($lyrics) >0){ ?>
	            <li data-href="#lyrics"><a href="#"><i class="zmdi zmdi-format-align-center"></i> <?php echo __("label_lyrics"); ?> <span class="label label-inverse"><?php echo count($lyrics); ?></span></a></li>
	            <?php } ?>
	            <?php if(count($playlists) >0){ ?>
	            <li data-href="#playlist"><a href="#"><i class="zmdi zmdi-playlist-audio"></i> <?php echo __("label_playlists"); ?> <span class="label label-inverse"><?php echo count($playlists); ?></span></a></li>
	            <?php } ?>
	            <?php if(count($stations) >0){ ?>
	            <li data-href="#stations"><a href="#"><i class="zmdi zmdi-portable-wifi"></i> <?php echo __("label_stations"); ?> <span class="label label-inverse"><?php echo count($stations); ?></span></a></li>            
	            <?php } ?>
	            <?php if(count($users) >0){ ?>
	            <li data-href="#users"><a href="#"><i class="fa fa-users"></i> <?php echo __("label_users"); ?> <span class="label label-inverse"><?php echo count($users); ?></span></a></li>
	            <?php } ?>
	        </ul>
	    </div>
    </div>
</div>  


<!-- TAB: ALL -->

<div class="tab active" id="all">
	
	
	<div class="col-md-6 col-xs-6 div-thumb-c visible-lg visible-md">   
	<?php if(count($artist)>0){ ?>
		<!-- Artist -->	
		
		<h2 class="sub"><span class="link-tab cursor-pointer" data-href="#artist"><?php echo __("label_artists");?> <small><i class="fa fa-external-link" aria-hidden="true"></i></small></span></h2>
	    <?php 	    
	    foreach ($artist as $key => $value) { 
	    	if($key == 3) break;
	    	?>    	
	    
	        <div class="col-lg-4 col-md-12 list-thumb-c">
	            <div class="thumbnail list-thumb contextMenu" data-id="<?php echo $value['idartist']; ?>" data-subtitle="<?php echo __("label_track"); ?>" data-title="<?php echo $value['artist']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-type="artist">
	                <div class="image">
	                    <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
	                    <div class="overlay">
	                           <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo urlencode($value["artist"]); ?>?play=1" class="name truncate" title="<?php echo $value["name"]; ?>"><i class="btn-play-album zmdi zmdi-play"></i></a>
	                    </div>
	                </div>
	                <div class="data">
	                    <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo urlencode($value["artist"]); ?>" class="name truncate" title="<?php echo $value["name"]; ?>"><?php echo $value["artist"]; ?></a>
	                    <div class="subdata">&nbsp;</div>                    
	                </div>
	            </div>
	        </div>
	      <?php
	      }
	      ?>
	      <?php } ?>
	</div>
	

	<div class="visible-lg visible-md div-thumb-c col-xs-6 col-md-<?php if(count($artist)>0){ echo "6"; $l=3;$i=4; }else{echo "12"; $l=6;$i=2; } ?>">   
		<?php if(count($albums)>0){ ?>
		<!-- Albums -->	
		<h2 class="sub"><span class="link-tab cursor-pointer" data-href="#albums"><?php echo __("label_albums");?> <small><i class="fa fa-external-link" aria-hidden="true"></i></small></span></h2>
	    <?php foreach ($albums as $key => $value) { 
	    	if($key == $l) break;
	    	?>    	
	    
	        <div class="col-lg-<?php echo $i; ?> col-md-12 list-thumb-c">
	            <div class="thumbnail list-thumb contextMenu" data-id="<?php echo $value['idalbum']; ?>" data-album="<?php echo $value['album']; ?>" data-title="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-type="album">
	                <div class="image">
	                    <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
	                    <div class="overlay">
	                        <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo $value["artist"]; ?>/<?php echo $value["album"]; ?>?play=1"><i class="btn-play-album zmdi zmdi-play"></i></a>
	                    </div>
	                </div>
	                <div class="data">
	                    <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo $value["artist"]; ?>/<?php echo $value["album"]; ?>" class="name truncate" title="<?php echo $value["album"]; ?>"><?php echo $value["album"]; ?></a>
	                    <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo $value["artist"]; ?>" class="subdata truncate"><?php echo $value['artist']; ?></a>                    
	                </div>
	            </div>
	        </div>
	      <?php
	      }
	      ?>
	      	<?php } ?>
	</div>

	<?php echo get_ads("ads2",'col-md-12 text-center padding-top-20 pull-right padding-bottom-20'); ?>   
	
	<!-- TRACKS -->
	
	 <div class="col-md-<?php if(count($lyrics)>0 || count($playlists) > 0){ echo '8'; } else{ echo '12';} ?>">     
	 		<?php if(count($tracks)>0){ ?>                  

          		<?php gui_tracks($tracks,'<span class="link-tab cursor-pointer" data-href="#tracks">'.__("label_tracks").' <small><i class="fa fa-external-link" aria-hidden="true"></i></small></span>',true); ?>
          		
    		<?php } ?>
    </div>
    
    
    <div class="visible-lg visible-md col-md-4">                       
	    <!-- lyrics -->
	    <?php if(count($lyrics)>0){ ?>
	    <div class="col-md-12">                       
	          <ul class="list-group style2">
		      
		        <?php     

		            foreach ($lyrics as $key => $value) {
		              if($key==5)
		                break;
		                ?>
		                <li class="list-group-item style2 d contextMenu" data-mbid="<?php echo $value["mbid"]; ?>" data-id="<?php echo $value["idlyric"]; ?>" data-source="<?php echo $value["source"]; ?>" data-name="<?php echo $value['name']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="playlist">                                                
		                  <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/-/<?php echo slug($value['track']); ?>">                                                                        
		                  <div class="thumb">
		                    <div class="thumb-overlay"> 
		                      <i class="zmdi zmdi-format-align-center"></i>
		                    </div>
		                    <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
		                  </div>
		                  <div class="name  truncate title">
		                  	<?php echo $value['track']; ?> 
		                  	<div class="text-muted"><?php echo $value['artist']; ?> - <span class="text-muted"> <?php echo __("label_lyrics");?></span></div>
		                  </div>
		                  </a>
		                </li>
		                <?php
		            }
		            ?>   
		            
		        </ul>    
		 
	    </div>
	 	<?php } ?>
	     <!-- PLAYLIST -->
	    

		
	    <div class="visible-lg visible-md col-md-12">    
	     <?php if(count($playlists) > 0){ ?>                   
	          <ul class="list-group style2 d">
		         
		        <?php     

		           foreach ($playlists as $key => $value) {

			              if($key==5)
			                break;
		                ?>
		                <li class="list-group-item style2 d contextMenu" data-mbid="<?php echo $value["mbid"]; ?>" data-id="<?php echo $value["idplaylist"]; ?>" data-source="<?php echo $value["source"]; ?>" data-name="<?php echo $value['name']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="playlist">                                                
		                  <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_playlist'); ?>/<?php echo urlencode($value["name"]); ?>-<?php echo $value["idplaylist"]; ?>">                                                                        
		                  <div class="thumb">
		                    <div class="thumb-overlay"> 
		                      <i class="zmdi zmdi-playlist-audio"></i>
		                    </div>
		                    <img class="lazy"  src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['image']; ?>">                
		                  </div>
		                  <div class="name  truncate title">
		                  	<?php echo $value['name']; ?> 
		                  	<div class="text-muted"><?php echo __("label_playlist"); ?></div>
		                  </div>
		                  </a>
		                </li>
		                <?php
		            }
		            ?>   
		            
		        </ul>    
		           <?php } ?>
	    </div>


	

	  
	 
	</div>

	<?php if(count($users)>0){ ?>
	<div class="col-md-12">	
	<br>
	<h2 class="sub"><span class="link-tab cursor-pointer" data-href="#users"><?php echo __("label_users");?> <small><i class="fa fa-external-link" aria-hidden="true"></i></small></span></h2>
	
	<?php echo render_users($users,6); ?>
	</div>
	<?php } ?>
	<?php if(count($stations)>0){ ?>		
	<div class="col-md-12">
	<br>
	<h2 class="sub"><span class="link-tab cursor-pointer" data-href="#stations"><?php echo __("label_stations");?> <small><i class="fa fa-external-link" aria-hidden="true"></i></small></span></h2>	
	<?php render_stations($stations,6); ?>
	</div>
	<?php } ?>


</div>
<!-- TAB: Tracks -->
<div class="tab" id="tracks">
<!-- TRACKS -->
	 <div class="col-md-12">       
	 	<?php gui_tracks($tracks); ?>                         
    </div>


</div>

<!-- TAB: Albums -->

<div class="tab" id="albums">
	<div class="col-md-12 div-thumb-c">   
		<?php render_albums($albums); ?>
	</div>
</div>

<!-- TAB: Artist -->
<div class="tab" id="artist">
	<div class="col-md-12 div-thumb-c">   
		<!-- Artist -->			
	    <?php echo render_artist($artist); ?>
	</div>
</div>

<!-- TAB: Playlist -->
<div class="tab" id="playlist">
	<div class="col-md-12 div-thumb-c">   
		
	<?php render_playlists($playlists); ?>

	</div>
</div>



<!-- TAB: Stations -->
<div class="tab" id="stations">
	<div class="col-md-12 div-thumb-c">   
		
	  <?php render_stations($stations); ?>

	</div>
</div>


<!-- TAB: USers -->

<div class="tab" id="users">
	<div class="col-md-12 div-thumb-c">   
		<?php echo render_users($users,50); ?>
	</div>
</div>