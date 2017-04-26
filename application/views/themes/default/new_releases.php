
  <div class="col-md-12">
    <h1 class="pull-left"><i class="zmdi zmdi-collection-music text-success"></i> <?php echo __("label_new_releases"); ?></h1>
    
     <div class="filter-generic col-md-4  col-xs-12 pull-right">
        <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
      </div> 
  
  
    

  </div>

<?php echo render_albums($releases); ?>