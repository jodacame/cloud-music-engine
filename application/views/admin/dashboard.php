  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Registered Users</span>
        <span class="info-box-number"><?php echo number_format($users); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

   <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fa fa-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Playlists</span>
        <span class="info-box-number"><?php echo number_format($playlists); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

   <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-male"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Artists</span>
        <span class="info-box-number"><?php echo number_format($artists); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->


   <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Albums</span>
        <span class="info-box-number"><?php echo number_format($albums); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-music"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Tracks</span>
        <span class="info-box-number"><?php echo number_format($tracks); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-teal"><i class="fa fa-headphones"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Stations</span>
        <span class="info-box-number"><?php echo number_format($stations); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->


     <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Favorites Tracks</span>
        <span class="info-box-number"><?php echo number_format($ftracks); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Favorites Artists</span>
        <span class="info-box-number"><?php echo number_format($fartists); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

   <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-black"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Favorites Albums</span>
        <span class="info-box-number"><?php echo number_format($falbums); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

   <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-maroon"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Favorites Stations</span>
        <span class="info-box-number"><?php echo number_format($fstations); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-fuchsia"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Favorites Playlists</span>
        <span class="info-box-number"><?php echo number_format($fplaylists); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-olive"><i class="fa fa-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Social Followers</span>
        <span class="info-box-number"><?php echo number_format($followers); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->




<div class="col-md-6">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-key"></i> License Key</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">      
      <?php if(!$license['error']){ ?>
          <table class="table table-striped table-hover ">
            <tr>
              <td><strong>Item Name</strong></td>
              <td><?php echo $license['product_name']; ?></td>
            </tr>
            <tr>
              <td><strong>License Key</strong></td>
              <td class="text-success"><?php echo $this->config->item("purchase_code"); ?></td>
            </tr>
            <tr>
              <td><strong>Purchase Date</strong></td>
              <td><?php echo $license['created_at']; ?></td>
            </tr>
            <tr>
              <td><strong>Buyer</strong></td>
              <td><?php echo $license['buyer']; ?></td>
            </tr>
            <tr>
              <td><strong>License</strong></td>
              <td><?php echo $license['license']; ?></td>
            </tr>            
            <tr>
              <td><strong>Server</strong></td>
              <td><?php echo $this->input->server('SERVER_ADDR'); ?> - <?php echo $this->input->server('SERVER_SOFTWARE'); ?>  </td>
            </tr>
            <tr>
              <td><strong>Domain</strong></td>
              <td><?php echo base_url(); ?>  </td>
            </tr>
            
          </table>    
          <hr>
        <?php }else{ ?>
        <div class="alert alert-error">
          <strong>Error:</strong> <?php echo $license['error']; ?>
        </div>
        <?php } ?>
        <div class="form-group">
          <label for="purchase_code">License Key</label>
          <input type="text"  required class="form-control" value="" id="purchase_code" name="purchase_code" placeholder="Your license key">
          <span class="inline-helper">
              When you purchased the script, you received a email with your license.
          </span>
        </div>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>        
        <a href="https://www.nexxuz.com/buy" class="pull-right btn btn-success">Buy License</a>
        

      </div>
    </form>
  </div>
</div>
<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-users"></i> Users Registered Last 12 Months</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              <tr>
                <th>Month</th>
                <th>Users</th>
              </tr>
              <?php
                foreach ($registered->result() as $row) 
                {
              ?>
              <tr>
                <td><?php echo $row->month; ?></td>
                <td style="width:20px"><span class="badge bg-red"><?php echo number_format($row->n); ?></span></td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  

          <div id="bar-chart" style="height: 300px;"></div>



  </div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>

<script>
<?php

          foreach ($registered->result() as $row) {
            $data .= "{y:'". $row->month."',a:".$row->n."},";           
            
          }
          $data = substr($data ,0,-1);
           
?>
$(function () {
      
    $('.popover-class').popover();
                  //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: [
                       <?php echo $data ; ?>
                    ],
                    barColors: ['#3C8DBC', '#F56954'],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Users'],
                    hideHover: 'auto'
                });

});
</script>
