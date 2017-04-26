<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $_HEADER; ?>
</head>
<body class="<?php echo $page; ?> <?php echo get_class_body(); ?>">


    <div id="wrapper">
    <!-- Player -->
    <?php //echo $_PLAYER; ?>
    <!-- Sidebar -->
    <?php echo $_SIDEBAR; ?>       
    <!-- Page Content -->
    <div id="page-content-wrapper">
    <!-- Static navbar -->
  	<?php echo $_NAVBAR; ?>
            <div class="container-fluid" id="main">
                <div class="c-m">
                    <?php echo $_PAGE; ?>                    
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="padding-top:20px;padding-bottom:20px">
                    <?php echo config_item('footer_code'); ?>
                </div>
                <div style="width:100%;height:60px;display:block;overflow:auto"></div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    <div class="overlay"></div>
    

    </div>
    <!-- /#wrapper -->

    
    
    <?php echo $_MODALS; ?>
    <?php echo $_PLAYER; ?>

    <?php echo $_FOOTER; ?>


</body>

</html>
