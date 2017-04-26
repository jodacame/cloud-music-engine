
<div class="col-md-12 visible-md visible-lg">
  <h1 class="pull-left"><i class="zmdi zmdi-tag text-success"></i> 
  <a href="<?php echo base_url(); ?><?php echo $this->config->item('slug_genres'); ?>"><?php echo $genre; ?></a>
  </h1>  


   <div class="filter-generic col-md-4  col-xs-12 pull-right">
      <input type="search" class="form-control" placeholder="&#9906; <?php echo __("label_filter"); ?>">
    </div> 
</div>
<br>

<?php echo render_artist($tracks,false,2); ?>