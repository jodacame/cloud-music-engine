<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cloud Music Engine</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    

    <!-- Custom CSS -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:100%2C100italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/player.css" rel="stylesheet">
    <link href="css/animations.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        <?php 
            $color = "#0288D1";
            $color_bt = "#536DFE";
        ?>
        .navbar-material-indigo{
            background-color:<?php echo $color; ?>
        }
        .sidebar-nav > .sidebar-brand {        
            background: <?php echo hex2rgba($color,1); ?>; /* Old browsers */
            background: -moz-linear-gradient(-45deg, <?php echo hex2rgba($color,0.6); ?> 0%, <?php echo hex2rgba($color,0.8); ?> 49%, <?php echo hex2rgba($color,0.6); ?> 50%, <?php echo hex2rgba($color,1); ?> 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,<?php echo hex2rgba($color,0.6); ?>), color-stop(49%,<?php echo hex2rgba($color,0.8); ?>), color-stop(50%,<?php echo hex2rgba($color,0.6); ?>), color-stop(100%,<?php echo hex2rgba($color,1); ?>)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(-45deg, <?php echo hex2rgba($color,0.6); ?> 0%,<?php echo hex2rgba($color,0.8); ?> 49%,<?php echo hex2rgba($color,0.6); ?> 50%,<?php echo hex2rgba($color,1); ?> 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(-45deg, <?php echo hex2rgba($color,0.6); ?> 0%,<?php echo hex2rgba($color,0.8); ?> 49%,<?php echo hex2rgba($color,0.6); ?> 50%,<?php echo hex2rgba($color,1); ?> 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(-45deg, <?php echo hex2rgba($color,0.6); ?> 0%,<?php echo hex2rgba($color,0.8); ?> 49%,<?php echo hex2rgba($color,0.6); ?> 50%,<?php echo hex2rgba($color,1); ?> 100%); /* IE10+ */
            background: linear-gradient(135deg, <?php echo hex2rgba($color,0.6); ?> 0%,<?php echo hex2rgba($color,0.8); ?> 49%,<?php echo hex2rgba($color,0.6); ?> 50%,<?php echo hex2rgba($color,1); ?> 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $color; ?>', endColorstr='<?php echo $color; ?>',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
        }
        .player .header{
            background-color: <?php echo $color; ?>    
        }
        .sidebar-nav li.active a{
            color:<?php echo $color; ?>;
        }
        .player .main .avatar .sh
        {
            background-color: <?php echo $color; ?>    
        }
        .jp-video .jp-controls span,.btn-float
        {
            background-color: <?php echo  $color_bt; ?>;
        }
        .jp-video .jp-toggles
        {
            background-color: <?php echo hex2rgba($color,0.9); ?>;    
        }
        .player{
            /*border-left:1px <?php echo hex2rgba($color,1); ?> solid;*/
            background-color: #FFF;
        }
        
        ul.tabs li.active
        {
            border-bottom: 1px <?php echo hex2rgba($color,1); ?> solid;
        }
        .jumbotron-material-indigo{
            background-color: <?php echo hex2rgba($color,0.9); ?>;
            /*background-image:  -webkit-radial-gradient(50% 50%, ellipse cover, <?php echo hex2rgba($color,1); ?>, <?php echo hex2rgba($color,0.5); ?> 70%);*/
            color:#FFF;
        }
        ul#playlist li.active p
        {
            color: <?php echo hex2rgba($color,0.9); ?>;
        }      
        .sidebar-nav li.main a:hover 
        {
             background-color: <?php echo hex2rgba($color,0.2); ?>;
        }  
    </style>
</head>

<body>




    <div id="wrapper">


    <!-- Player -->
    <div class="player">
        <div class="header">
            <i class="md md-queue-music"></i>
            <div class="now">
                <strong class="jp-track-artis">Welcome To The Jungle</strong>
                <small class="jp-track-title">Guns N' Roses</small>
            </div>
        </div>
        <div class="main">
            <div class="avatar" style="background-image:url('http://userserve-ak.last.fm/serve/300x300/102521427.png')">
                <div class="sh"></div>
                <div class="controls">
                    <div class="actions">
                        <i class="md md-playlist-add"></i>
                        <i class="md md-file-download"></i>
                        <i class="md md-share"></i>
                    </div>
                    
                    <div id="jp_container_1" class="jp-video " role="application" aria-label="media player">
                      <div class="jp-type-single">
                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                        <div class="jp-gui">
                          <div class="jp-video-play hide">
                            <span class="jp-video-play-icon" role="button" tabindex="0"><i class="md md-play-circle-fill"></i></span>
                          </div>
                          <div class="jp-interface">
                            <div class="jp-progress">
                              <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                              </div>
                            </div>
                            <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                            <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                            <!--<div class="jp-details">
                              <div class="jp-title" aria-label="title">&nbsp;</div>
                            </div>-->
                            <div class="jp-controls-holder">
                              <div class="jp-volume-controls">  
                                <span class="jp-mute" role="button" tabindex="0"><i class="md md-volume-off"></i></span>                                                                
                                <div class="jp-volume-bar">
                                  <div class="jp-volume-bar-value"></div>
                                </div>
                              </div>
                              <div class="jp-controls">
                                <span class="jp-play" role="button" tabindex="0"><i class="md md-play-arrow"></i></span>
                                <span class="jp-pause" role="button" tabindex="0"><i class="md md-pause"></i></span>
                              </div>
                              <div class="jp-toggles">
                                <span class="jp-repeat hide" role="button" tabindex="0"><i class="md  md-repeat"></i></span>
                                <span class="jp-repeat-off hide" role="button" tabindex="0"><i class="md  md-repeat"></i></span>
                                <span class="jp-full-screen hide" role="button" tabindex="0"><i class="md md-fullscreen"></i></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="jp-no-solution">
                          <span>Update Required</span>
                          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <ul id="playlist">
            <?php for($x<0;$x<=50;$x++){ ?>
                <li <?php if($x==3){ echo 'class="active"'; }?>>
                    <div class="avatar" style="background-image:url('http://userserve-ak.last.fm/serve/300x300/102521427.png')">
                    </div>
                    <div class="details">
                        <p class="track">Welcome To The Jungle</p>
                        <p class="artist">Gun's And Roses</p>
                    </div>
                </li>
            <?php } ?>
            </ul>

        </div>
    </div>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand menu-toggle">                    
                    <div class="profile">
                        
                         <i class="md-settings"></i>
                        <div class="avatar">
                            <img src="http://fondosgratishd.com/wp-content/uploads/Avatar-Movie-1-800x6000.jpg">
                            <span class="noty">25</span>
                        </div>
                        <span class="data">
                            <strong>Jodacame</strong>
                            jodacame@gmail.com
                        </span>                        
                        <ul class="stats">
                            <li>
                                <span>Followers</span>
                                <strong>1,570</strong>
                            </li>
                            <li>
                                <span>Following</span>
                                <strong>5,100</strong>
                            </li>
                            <li>
                                <span>Activity</span>
                                <strong>27,547</strong>
                            </li>
                        </ul>


                    </div>
                </li>
                <li class="main btn-player">
                    <a href="#">
                    Listen Now

                    </a>
                </li>
                 <li class="main">
                    <a href="#">Search</a>
                </li>

                <li class="main">
                    <a href="#">Mi Música</a>
                </li>
                <li class="main">
                    <a href="#">Radio</a>
                </li>
                <li class="main">
                    <a href="#">Explore</a>
                </li>
                <li class="main">
                    <a href="#">Friends</a>
                </li>

                <li class="title">
                    <a href="#">AUTOPLAYLIST</a>
                </li>
                <li class="sub">
                    <a href="#">Robbie Williams</a>
                </li>
                <li class="sub">
                    <a href="#">Rock</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <!-- Static navbar -->
      <nav class="navbar navbar-default navbar-fixed-top navbar-material-indigo">
        <div class="container-fluid">
          <div class="navbar-header">          
            <a  id="menu-toggle" class="menu-toggle navbar-brand" href="#">
                <i class="md md-menu"></i>
            </a>
            <a class="menu-toggle navbar-brand navbar-title " href="#">
                Top Artist
            </a>
             <a  class="btn-player visible-xs visible-md navbar-brand pull-right" href="#">
                <i class="md md-queue-music"></i>
            </a>
          </div>  
        </div><!--/.container-fluid -->
      </nav>

            <div class="container-fluid" id="main">
                <div class="box">
                    <div class="jumbotron jumbotron-material-indigo">
                        <div class="avatar" style="background-image:url('http://userserve-ak.last.fm/serve/300x300/102521427.png')"></div>
                        <h1 class="float-title truncate">Robbie Williams asd asdas dasd</h1>
                        
                            <div class="btn-group">      
                                <span class="hide float-title"> -</span>                        
                                <h2 class="dropdown-toggle float-title" data-toggle="dropdown" aria-expanded="false"><i class="md md-more-vert" ></i>  Crazy
                                                                 
                                </h2>
                              <ul class="dropdown-menu dropdown-menu-material" role="menu">
                                <li><a href="#">Add to Queue</a></li>
                                <li><a href="#">Play Now</a></li>
                                <li><a href="#">Share This</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Add to...</a></li>
                              </ul>
                            </div>
                        
                        
                        <ul class="tags">
                            <li><i class="md md-navigate-next"></i><a href="#">Rock</a></li>
                            <li><i class="md md-navigate-next"></i><a href="#">Movies</a></li>
                            <li><i class="md md-navigate-next"></i><a href="#">Pop Rock</a></li>
                         
                        </ul>
                        <a class="btn-float" href="#">
                            <i class="md md-play-arrow"></i>
                        </a>                                                
                    </div>
                    <ul class="tabs">
                        <li data-target="about" class="active"><i class="md md-info-outline"></i> <span class="hidden-sm hidden-xs">About</span></li>
                        <li data-target="top"><i class="md md-star-outline"></i> <span class="hidden-sm hidden-xs">Top</span></li>                        
                        <li class="btn-share"><i class="md md-share"></i> <span class="hidden-sm hidden-xs">Share</span></li>
                        <li data-target="related"><i class="md md-nature-people"></i> <span class="hidden-sm hidden-xs">Related</span></li>
                        <li data-target="lyric"><i class="md md-format-align-center"></i> <span class="hidden-sm hidden-xs">Lyric</span></li>
                    </ul>
                        
                    <div class="row">
                     
                            <div class="tab active" id="about">
                                <p>
                                Aerosmith is an American hard rock band, sometimes referred to as "The Bad Boys from Boston" and "America's Greatest Rock and Roll Band." Their style, which is rooted in blues-based hard rock, has come to also incorporate elements of pop music, heavy metal music, and rhythm and blues, and has inspired many subsequent rock artists. The band was formed in Boston, Massachusetts in 1970. Guitarist Joe Perry and bassist Tom Hamilton, originally in a band together called the Jam Band, met up with singer Steven Tyler, drummer Joey Kramer, and guitarist Ray Tabano, and formed Aerosmith. In 1971, Tabano was replaced by Brad Whitford, and the band began developing a following in Boston.
                                </p>
                                <div class="comments">
                                    <ul class="items">
                                        <li>
                                            <textarea id="comment" placeholder="Place your comment here."></textarea>
                                            <button class="btn btn-link pull-right btn-send-comment">Send</button>

                                        </li>
                                    </ul>
                                    <ul class="items">
                                    <?php for($x=0;$x<=5;$x++){ ?>
                                        <li>
                                            <div class="avatar" style="background-image:url('http://userserve-ak.last.fm/serve/300x300/102521427.png')"></div>
                                            <div class="data">                                                                                            
                                                                                             
                                                <div class="user">Jodacame</div>
                                                <div class="date">27 Jun 2017</div>
                                            </div>
                                            <div class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab" id="top">
                                
                                    <ul class="list-music">

                                    <?php 
                                        //$url = "http://api.soundcloud.com/tracks.json?client_id=ab938e303f4136d237a4fc8801a411e8&track_type=original&q=".urlencode("crazy aerosmith");
                                        //$url = "https://itunes.apple.com/search?term=".urlencode("crazy aerosmith");
                                        $url = "http://ws.spotify.com/search/1/track.json?q=".urlencode("crazy aerosmith");
                                        $ch = curl_init();  
                                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                                        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
                                        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
                                        curl_setopt($ch,CURLOPT_MAXREDIRS,50);
                                        if(strtolower(parse_url($url, PHP_URL_SCHEME)) == 'https')
                                        {
                                            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
                                            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
                                        }
                                        curl_setopt($ch, CURLOPT_URL, $url); 
                                        $data = curl_exec($ch);
                                        curl_close($ch); 
                                        
                                        $data = json_decode($data);
                                        //print_r($data);
                                        foreach ($data->tracks as $key => $value) {
                                            ?>
                                            <li class="li">                                                
                                                <div class="track"><?php echo $value->name; ?></div>
                                                <div class="artist"><?php echo $value->artists[0]->name; ?></div>
                                                <div class="trg">
                                                         <div class="btn-group">                              
                                                            <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" ><i class="md md-more-vert" ></i></div>
                                                              <ul class="dropdown-menu dropdown-menu-material" role="menu">
                                                                <li><a href="#">Add to Queue</a></li>
                                                                <li><a href="#">Play Now</a></li>
                                                                <li><a href="#">Share This</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#">Add to...</a></li>
                                                              </ul>
                                                        </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                       
                                    </ul>

                            </div>
                          
                            <div class="tab" id="related">
                                Related
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    <div class="overlay"></div>
    

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/app.js"></script>
    <script src="js/youtube.js"></script>

    <!-- jPlayer -->
    <script src="js/jplayer/jplayer/jquery.jplayer.min.js"></script>

    <script src="js/jquery.nicescroll.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>


    <!-- Menu Toggle Script -->
    <script>
    $(".menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $(".btn-player").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("player-active");
        $("#wrapper").removeClass("toggled");
    });

    $(".overlay").click(function (e) {
        e.preventDefault();
         $("#wrapper").removeClass("toggled");
         $("#wrapper").removeClass("player-active");
         
    });
    $(".player .header").click(function (e) {
        e.preventDefault();
         $("#wrapper").removeClass("player-active");
         
    });
    $(".sidebar-nav li").click(function (e) {
        e.preventDefault();
        $(".sidebar-nav li").removeClass('active');
        $(this).addClass('active');
    });

    </script>





<div class="modal" id="modal-comment">
  <div class="modal-dialog">
    <div class="modal-content">      
      <div class="modal-body text-center">
        <div class="avatar">
            <img src="http://fondosgratishd.com/wp-content/uploads/Avatar-Movie-1-800x6000.jpg">
            <blockquote id="commentok"><p></p> </blockquote>
        </div>
        <div class="g-recaptcha" data-sitekey="6LeseAMTAAAAAIwBuOYGFZpyXXdzS5Dmh4Hz81s5"></div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-link">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</body>

</html>

<?php
function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
?>