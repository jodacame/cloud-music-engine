    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $SEO['title']; ?></title>
    <meta name="description" content="<?php echo rtrim(ltrim(strip_tags($SEO['description']))).config_item("site_description"); ?>">
    <meta name="author" content="">
    <meta name="keywords" content="<?php echo config_item("keywords"); ?>"> 
    <meta name="google-site-verification" content="<?php echo config_item("gwt"); ?>" />
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png"   href="<?php echo base_url(); ?>assets/images/fav.png">

    <link rel="stylesheet"  type="text/css"  href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css" />
    <?php

    if($SEO['meta'])
    {
    $image = false;
      foreach ($SEO['meta'] as $key => $value) {
        echo "<".$value['type']." ";
        foreach ($value['attr'] as $key => $value) {
          echo $key.'="'.$value.'" ';
          if($value == 'og:image')
            $image = true;
        }
        echo ">\n";
      }
    }
    echo $SEO['meta_raw'];
    ?>

   
   
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(!$image){ ?>
     <meta property="og:image" content="<?php echo base_url(); ?>assets/images/facebook_banner.jpg">    
    <?php } ?>

    <script>
    var base_url= "<?php echo base_url(); ?>";
    var is_logged= "<?php echo is_logged(); ?>";
    var is_mobile= "<?php echo $this->agent->is_mobile(); ?>";
    var slug = {main:"<?php echo get_slug('main'); ?>",my_playlist:"<?php echo get_slug('my_playlist'); ?>",station:"<?php echo get_slug('station'); ?>",playlist:"<?php echo get_slug('playlist'); ?>"};
    var lang = <?php echo json_encode(config_item('translation')); ?>;    
    var settings = {show_video:'<?php echo $this->config->item("show_video"); ?>',ga:'<?php echo $this->config->item("ga"); ?>'};
    </script>

