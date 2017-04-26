  <div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Settings</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST">
      <div class="box-body">
        <?php foreach ($fields->result_array() as $value) { ?>
        <div class="col-lg-6">
          <?php echo getInput($value); ?>
        </div>
       <?php } ?>
       
      </div><!-- /.box-body -->
      <div class="box-footer">                    
        <button type="submit" class="btn btn-primary">Save</button>
      </div><!-- /.box-footer -->
    </form>
  </div><!-- /.box -->