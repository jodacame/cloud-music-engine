<?php
function gui_tracks_thumb($tracks,$lg=2)
{
    $CI     =& get_instance(); 
      foreach ($tracks as $key => $value) {  
          if(!$value["picture_small"])         
            $value["picture_small"] = $value["image"];
          if(!$value["picture_extra"])         
            $value["picture_extra"] = $value["image"];   
          if(!$value["picture_medium"])         
            $value["picture_medium"] = $value["image"];
          if(trim($value["track"]) != '')
          {

        ?>      
      
          <div class="filter-me col-xs-6 col-lg-<?php echo $lg; ?> col-md-4 list-thumb-c">
              <div class="thumbnail list-thumb <?php if($value['idtracks']){ echo 'contextMenu'; }?>"  data-id="<?php echo $value['idtracks']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-title="<?php echo $value['artist']; ?>" data-subtitle="<?php echo $value["track"]; ?>" data-track="<?php echo $value["track"]; ?>" data-image="<?php echo $value["picture_small"]; ?>" data-type="track">
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
                      <div class="overlay">
                          <i class="cursor-pointer btn-play zmdi zmdi-play"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-track="<?php echo $value["track"]; ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-id="<?php echo $value['idtracks']; ?>"  data-type="track"></i>
                      </div>
                  </div>
                  <div class="data">
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>/<?php echo slug($value["album"]); ?>/<?php echo slug($value["track"]); ?>" class="name truncate" title="<?php echo $value["track"]; ?>"><?php echo $value["track"]; ?></a>
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>" class="subdata truncate"><?php echo $value['artist']; ?></a>                    
                      <?php if($value['created']){ ?>
                      <small class="text-muted text-right" style="color:rgba(255,255,255,.5)"><?php echo ago(strtotime($value['created'])); ?></small>                    
                      <?php }?>
                  </div>
              </div>
          </div>
          <?php
            }
        }
          
}
function gui_tracks($tracks,$title = false,$more = false)
{

if(count($tracks) < 10)
{
  $more =false;
}
if(count($tracks) == 0)
      {
        ?>
        <div class="error">                              
         <h1 style="font-size:90px">
          <i class="fa fa-music"></i>
         </h1>                               
         <h2><?php echo __("label_no_tracks"); ?></h2>                                       
         </div>
        <?php
        return false;
      } 

  $CI     =& get_instance();  
  $id = rand(0,9999999);
	?>

   <?php if($title){ ?>
          
            <div class="main-title">
             <h2 class="sub"> <?php echo $title ; ?></h2>
            </div>
          <?php } ?>
<div class="<?php if($more) {echo "more"; } ?>" id="<?php echo $id; ?>">
	<table class="table table-hover" >
         <thead>
          <tr>     
              <th class="control"></th>     
	            <th class="track title"><?php echo __("label_track"); ?></th>
	            <th class="artist title"><?php echo __("label_artist"); ?></th>
	            <th class="visible-lg visible-md hidde-xs album title"><?php echo __("label_album"); ?></th>	                      
          </tr>
          </thead>
          <tbody>
        <?php
          $duplicated = array();
            foreach ($tracks as $key => $value) {
              if($duplicated[sha1($value['artist'].$value['album'].$value['track'])])
                continue;
              $duplicated[sha1($value['artist'].$value['album'].$value['track'])] = true;
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["picture"];
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["image"];
            	if(!$value["album"])
            		$value["album"] = '-';
                ?>
                <tr class="filter-me contextMenu track-<?php echo $value["idtracks"]; ?>" data-id="<?php echo $value["idtracks"]; ?>" data-track="<?php echo $value['track']; ?>" data-artist="<?php echo $value['artist']; ?>" data-title="<?php echo $value['artist']; ?>"  data-subtitle="<?php echo $value['track']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track" >                                                
                   <td class="control title">
                        <i class="zmdi btn-action btn-play zmdi-play-circle"  data-id="<?php echo $value["idtracks"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>                        
                        <i class="zmdi btn-action btn-pause zmdi-pause-circle"></i>
                        <i class="zmdi hide btn-add-to-playlist zmdi-plus"  data-id="<?php echo $value["idtracks"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>           
                        <i class="zmdi contextMenu no-close btn-open-menu zmdi-plus"  data-id="<?php echo $value["idtracks"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>           
                    </td>
                    <td class="track title"><a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/<?php echo slug($value['album']); ?>/<?php echo slug($value['track']); ?>"><?php echo $value['track']; ?></a></td>
                    <td class="artist title" data-id="<?php echo $value["idtracks"]; ?>" data-subtitle="<?php echo __("label_artist"); ?>" data-title="<?php echo $value['artist']; ?>" data-artist="<?php echo $value['artist']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="artist">
                    <?php 
                    if(is_array($value['artists']))
                    {
                      foreach ($value['artists'] as $key2 => $value2) {
                        ?>
                        <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value2['name']); ?>"><?php echo $value2['name']; ?></a>
                        <?php
                      }                      
                    }
                    else
                    {
                        ?> <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>"><?php echo $value['artist']; ?></a><?php
                    }
                    ?>
                    </td>
                    <td class="visible-lg visible-md album title " data-id="<?php echo $value["idtracks"]; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-title="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="album">
                                          
                      
                        <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/<?php echo slug($value["album"]); ?>"><?php echo $value["album"]; ?></a>
                    </td>  
                </tr>
                <?php
            }
            ?>       
            </tbody>   
        </table>   
        </div> <?php        
        if($more)
            {
              ?>
              <br>              
              <button data-target="#<?php echo $id; ?>" class="btn btn-default btn-more-data"><?php echo __("label_show_more"); ?></button>
              <div class="clearfix"></div>
              <?php
            }

          
}




function gui_tracks_playlist($tracks,$owner)
{
  if(count($tracks) == 0)  
  {
    ?>
    <div class="error" id="open-playlist-page">                               
      <h1 style="font-size:90px"><i class="zmdi zmdi-collection-music"></i></h1>
      <h2><?php echo __("label_library_empty"); ?></h2>
      <p><?php echo __("label_library_empty_description"); ?></p>                                 
    </div>
    <?php
    return false;
  }
  $CI     =& get_instance();  
 
  

  ?>



  <table class="table table-hover">
         <thead>
          <tr>     
              <th class="control"></th>     
              <th class="track title"><?php echo __("label_track"); ?></th>
              <th class="artist title"><?php echo __("label_artist"); ?></th>
              <th class="visible-lg visible-md hidde-xs  album title"><?php echo __("label_album"); ?></th>                       
          </tr>
          </thead>
          <tbody>
        <?php          
            foreach ($tracks as $key => $value) {
          
             
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["picture"];
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["image"];
              if(!$value["album"])
                $value["album"] = '-';

                ?>
                <tr class="<?php echo $value["id"]; ?> contextMenu"  data-id="<?php echo $value["id"]; ?>" data-subtitle="<?php echo $value['track']; ?>" data-track="<?php echo $value['track']; ?>"  data-title="<?php echo $value['artist']; ?>"  data-artist="<?php echo $value['artist']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track">                                                
                   <td class="control title ">
                        
                        <i class="zmdi btn-action btn-play zmdi-play-circle"  data-id="<?php echo $value["id"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>                        
                        <i class="zmdi btn-action btn-pause zmdi-pause-circle"></i>                        
                        <i class="zmdi hide btn-add-to-playlist zmdi-plus"  data-id="<?php echo $value["id"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>           
                        <i class="zmdi contextMenu no-close btn-open-menu zmdi-plus"  data-id="<?php echo $value["id"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"></i>           
                        
                        

           
                    </td>
                    <td class="track title"><a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/<?php echo slug($value['album']); ?>/<?php echo slug($value['track']); ?>">
                      <?php echo $value['track']; ?></a>
                    </td>
                    <td class="artist title " data-id="<?php echo $value["id"]; ?>" data-subtitle="<?php echo __("label_artist"); ?>" data-title="<?php echo $value['artist']; ?>" data-artist="<?php echo $value['artist']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="artist">
                    <?php 
                    if(is_array($value['artists']))
                    {
                      foreach ($value['artists'] as $key2 => $value2) {
                        ?>
                        <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value2['name']); ?>"><?php echo $value2['name']; ?></a>
                        <?php
                      }                      
                    }
                    else
                    {
                        ?> <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>"><?php echo $value['artist']; ?></a><?php
                    }
                    ?>
                    </td>
                    <td class="visible-lg visible-md hidde-xs  album title " data-id="<?php echo $value["id"]; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-artist="<?php echo $value['artist']; ?>" data-title="<?php echo $value['album']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="album">

                       <div class="trg btn-group" >
                          <?php if($owner == true){ ?>
                          <button class="btn btn-xs btn-default btn-remove-from-playlist "   data-idplaylist="<?php echo $value["idplaylist"]; ?>" data-id="<?php echo $value["id"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="track"><i class="fa fa-trash"></i>  </button>
                          <?php } ?>                                
                          <button class="btn btn-xs  btn-default btn-menu-music"> <i class="zmdi zmdi-more-vert  btn-menu-music"  data-id="<?php echo $value["id"]; ?>" data-track="<?php echo $value['track']; ?>"  data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-image="<?php echo $value['picture_medium']; ?>"></i></button>
                          <a target="_blank"  class="btn btn-xs btn-default external exclude" href="<?php echo base_url(); ?>d?artist=<?php echo $value['artist']; ?>&track=<?php echo $value['track']; ?>&s1=youtube"><i class="fa fa-download"></i></a>
                        </div> 
                        <a href="<?php echo base_url(); ?><?php echo  $CI->config->item('slug_main'); ?>/<?php echo slug($value['artist']); ?>/<?php echo $value["album"]; ?>"><?php echo $value["album"]; ?></a>
                    </td>
                    
                 
                </tr>
                <?php
            }
            ?>       
            </tbody>   
        </table>   
       <?php
            
}


function gui_tracks_station($tracks,$stationid=false)
{
  $CI     =& get_instance();  
 
  if(count($tracks) == 0)
    return false;
  ?>



  <table class="table table-hover">
         <thead>
          <tr>     
                
              <th class="track title"><?php echo __("label_track"); ?></th>
              <th class="artist title"><?php echo __("label_artist"); ?></th>
              
          </tr>
          </thead>
          <tbody>
        <?php          
            foreach ($tracks as $key => $value) {
              $value['track'] = ucwords(mb_strtolower($value['track'],"UTF-8"));
              $value['artist'] = ucwords(mb_strtolower($value['artist'],"UTF-8"));
             
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["picture"];
              if(!$value["picture_medium"])
                $value["picture_medium"] = $value["image"];
              if( $value["picture_medium"] == '' )
                  $value["picture_medium"] = base_url()."assets/images/no-picture.png";

              if(!$value["album"])
                $value["album"] = __("label_no_album");
                ?>
                <tr class="contextMenu <?php if($key==0){ echo $stationid; } ?>" data-subtitle="<?php echo $value['track']; ?>"  data-track="<?php echo $value['track']; ?>" data-title="<?php echo $value['artist']; ?>"  data-artist="<?php echo $value['artist']; ?>" data-album="<?php echo $value['album']; ?>" data-image="<?php echo $value['picture_medium']; ?>" data-type="search">                                                
                   
                    <td class="track title">
                    <a href="<?php echo base_url(); ?>?s=<?php echo slug($value['track']); ?>+<?php echo slug($value['artist']); ?>"><?php echo $value['track']; ?></a></td>
                    <td class="artist title">
                    <a href="<?php echo base_url(); ?>?s=<?php echo slug($value['artist']); ?>"><?php echo $value['artist']; ?></a>
                    </td>
                    
                    
                 
                </tr>
                <?php
            }
            ?>       
            </tbody>   
        </table>   
       <?php
            
}



function avatar($img,$v=1)
{
  if(strpos($img, "http") === false)
    return base_url()."avatars/".$img."?v=".$v;
  return $img;
}

function getLikeButton($type,$iduser,$idtarget,$value,$liked =false)
{
  
  if(!is_logged())
  {
    return false;
  }
  if(intval($iduser) == 0 || $idtarget == '')
  {   

    return false;
  }
  $CI     =& get_instance();  
  $exist = $CI->Admin->getTable("likes",array("iduser" => getUserID(),"idtarget" => $idtarget,"type" => $type));

  $liked = false;
  if($exist->num_rows() > 0)
    $liked = true;
  if($type == 6)
  {

     if($liked)
        $html = '<button class="btn btn-md btn-default btn-like" data-type="'.$type.'" data-unlike="1" data-iduser="'.$iduser.'" data-value="'.$value.'" data-idtarget="'.$idtarget.'" title="'.__("label_unfollow").'"><i class="zmdi zmdi-accounts"></i> <b>'.number_format($value).'</b> </button>';  
      else
        $html = '<button class="btn btn-md btn-success btn-like" data-type="'.$type.'" data-iduser="'.$iduser.'" data-value="'.$value.'" data-idtarget="'.$idtarget.'" title="'.__("label_follow").'"><i class="zmdi zmdi-accounts-outline"></i> <b>'.number_format($value).'</b> </button>';       
  }
  else
  {
    if($liked)
      $html = '<button class="btn btn-md btn-default btn-like" data-type="'.$type.'" data-unlike="1" data-iduser="'.$iduser.'" data-value="'.$value.'" data-idtarget="'.$idtarget.'" title="'.__("label_remove_to_favorite").'"><i class="zmdi zmdi-favorite"></i> <b>'.number_format($value).'</b></button>';  
    else
      $html = '<button class="btn btn-md btn-default btn-like" data-type="'.$type.'" data-iduser="'.$iduser.'" data-value="'.$value.'" data-idtarget="'.$idtarget.'" title="'.__("label_add_to_favorite").'"><i class="zmdi zmdi-favorite-outline"></i> <b>'.number_format($value).'</b></button>';  

  }
  return $html;
}

function getInput($data)
{
  $CI     =& get_instance();  
  switch ($data['type']) {
    case 'textarea':
      $input = '<textarea class="form-control '.$data['class'].'" rows="5"  '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'">'.$data['value'].'</textarea>';
      break;    
    
    case 'select':      
      $temp = explode("|", $data['options']);
  
      foreach ($temp as $key => $value) 
      { 
        $lables     = explode(":", $value);
        $valuel     = $lables[0];
        if($lables[1] != '')
          $value = $lables[1];
        if($valuel == '')
          $valuel = $value;

         $selected = '';
         if($value == $data['value'])
           $selected = 'selected="selected"';
          if($value != '')
            $options .= "<option  $selected value='".$value."'>".$valuel."</option>";
      }
      
      $input = '<select class="form-control '.$data['class'].'" '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'">'.$options.'</select>';
      break; 

     case 'select-multiple':      
      $temp = explode("|", $data['options']);
  
      foreach ($temp as $key => $value) 
      { 
        $lables     = explode(":", $value);
        $valuel     = $lables[0];
        if($lables[1] != '')
          $value = $lables[1];
        if($valuel == '')
          $valuel = $value;

         $selected = '';
         $temp_values  = explode(",", $data['value']);
         if(in_array($value, $temp_values))
           $selected = 'selected="selected"';
          if($value != '')
            $options .= "<option  $selected value='".$value."'>".$valuel."</option>";
      }
      
      $input = '<select multiple="multiple" class="form-control '.$data['class'].'" '.$data['attr'].' name="'.$data['var'].'[]" id="'.$data['var'].'">'.$options.'</select>';
      break; 
    default:
      $input = '<input class="form-control '.$data['class'].'" type="'.$data['type'].'" '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'" value="'.$data['value'].'">';
      break;
  }
  $html ='<div class="form-group">
          <label for="'.$data['var'].'" class="col-sm-3 control-label">'.$data['label'].'</label>
          <div class="col-sm-9">
            '.$input.'
            <p class="help-block">'.$data['helper'].'</p>
          </div>
        </div>';
        return  $html;
}

function get_class_body()
{
  $CI     =& get_instance();  
  if($CI->config->item('show_video')==1)
    return "show-video";
}

function render_artist($artist,$limit = false,$lg = 2)
{

    
      $CI     =& get_instance(); 
      if(count($artist) == 0)
      {
        ?>
        <div class="error">                              
         <h1 style="font-size:90px">
          <i class="zmdi zmdi-male-female"></i>
         </h1>                               
         <h2><?php echo __("label_no_artist"); ?></h2>                                       
         </div>
        <?php
        return false;
      }      
      foreach ($artist as $key => $value) { 
        if($limit)
        {
          if($key >= $limit)
            break;
        }
        ?>      
      
          <div class="filter-me col-xs-6 col-lg-<?php echo $lg; ?> col-md-4 list-thumb-c">
              <div class="thumbnail list-thumb contextMenu" data-id="<?php echo $value['idartist']; ?>" data-title="<?php echo $value['artist']; ?>"  data-artist="<?php echo $value['artist']; ?>"  data-subtitle="<?php echo __("label_artist"); ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-type="artist">
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
                      <div class="overlay">
                         <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>?play=1"><i class="btn-play-album zmdi zmdi-play"></i></a>
                      </div>
                  </div>
                  <div class="data">
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>" class="name truncate" title="<?php echo $value["artist"]; ?>"><?php echo $value["artist"]; ?></a>
                      <div class="subdata"> </div>                    
                  </div>
              </div>
          </div>
        <?php
        }
        
}

function render_albums($albums)
{
    if(count($albums) == 0)
      {
        ?>
        <div class="error">                              
         <h1 style="font-size:90px">
          <i class="zmdi zmdi-collection-music"></i>
         </h1>                               
         <h2><?php echo __("label_no_albums"); ?></h2>                                       
         </div>
        <?php
        return false;
      } 

  $CI     =& get_instance(); 
  foreach ($albums as $key => $value) {         
        ?>      
      
          <div class="filter-me col-xs-6 col-lg-2 col-md-4 list-thumb-c">
              <div class="thumbnail list-thumb contextMenu" data-id="<?php echo $value['idalbum']; ?>" data-title="<?php echo $value['album']; ?>" data-album="<?php echo $value['album']; ?>" data-artist="<?php echo $value['artist']; ?>" data-subtitle="<?php echo __("label_album"); ?>" data-image="<?php echo $value["picture_medium"]; ?>" data-type="album">
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['picture_medium']; ?>">                
                      <div class="overlay">
                         <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>/<?php echo $value["album"]; ?>?play=1"><i class="btn-play-album zmdi zmdi-play"></i></a>
                      </div>
                  </div>
                  <div class="data">
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>/<?php echo slug($value["album"]); ?>" class="name truncate" title="<?php echo $value["album"]; ?>"><?php echo $value["album"]; ?></a>
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_main'); ?>/<?php echo slug($value["artist"]); ?>" class="subdata truncate"><?php echo $value["artist"]; ?></a>                    
                  </div>
              </div>
          </div>
        <?php
        }
    
  
}
function render_playlists($playlists)
{

  if(count($playlists) == 0)
      {
        ?>
        <div class="error">                              
         <h1 style="font-size:90px">
          <i class="zmdi zmdi-playlist-audio"></i>
         </h1>                               
         <h2><?php echo __("label_no_playlists"); ?></h2>                                       
         </div>
        <?php
        return false;
      } 

  $CI     =& get_instance(); 
  foreach ($playlists as $key => $value) {
  ?>
  <div class="filter-me col-xs-6 col-lg-2 col-md-4 list-thumb-c">
        <div class="thumbnail list-thumb contextMenu"  data-title="<?php echo $value["name"]; ?>"  data-artist="<?php echo $value["name"]; ?>" data-subtitle="<?php echo __("label_playlist"); ?>" data-stationid="<?php echo $value["idplaylist"]; ?>" data-image="<?php echo $value["image"]; ?>" data-type="playlist">
            <div class="image">
                <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo $value['image']; ?>">                
                <div class="overlay">
                    <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_playlist'); ?>/<?php echo slug($value["name"]); ?>-<?php echo slug($value["idplaylist"]); ?>?play=1"><i class="btn-play-album zmdi zmdi-play" data-name="<?php echo $value["name"]; ?>" data-stationid="<?php echo $value['idplaylist']; ?>" data-image="<?php echo $value["image"]; ?>" data-type="playlist"></i></a>
                </div>
            </div>
            <div class="data">                    
                <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_playlist'); ?>/<?php echo slug($value["name"]); ?>-<?php echo slug($value["idplaylist"]); ?>" class="name truncate" title="<?php echo $value["title"]; ?>"><?php echo $value["name"]; ?></a>                     
            </div>
        </div>
    </div>
        <?php
      } 
}
function render_stations($stations,$limit = 100)
{

  if(count($stations) == 0)
      {
        ?>
        <div class="error">                              
         <h1 style="font-size:90px">
          <i class="zmdi zmdi-portable-wifi"></i>
         </h1>                               
         <h2><?php echo __("label_no_stations"); ?></h2>                                       
         </div>
        <?php
        return false;
      } 

  $CI     =& get_instance(); 
  foreach ($stations as $key => $value) {
    if($key>= $limit)
      break;
    if($value['cover'] == '')
      $value['cover'] =  base_url()."assets/images/no-picture.png";
  ?>
      <div class="filter-me col-xs-6 col-lg-2 col-md-4 list-thumb-c">
              <div class="thumbnail list-thumb contextMenu"  data-stationid="<?php echo $value["idstation"]; ?>" data-subtitle="<?php echo __("label_station"); ?>"  data-title="<?php echo $value["title"]; ?>"  data-image="<?php echo  base_url().$value["cover"]; ?>" data-type="station">
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo  base_url().$value['cover']; ?>">                
                      <div class="overlay">
                          <!--<i class="btn-play-album zmdi zmdi-play btn-play" data-name="<?php echo $value["title"]; ?>" data-stationid="<?php echo $value['idstation']; ?>" data-image="<?php echo  base_url().$value["cover"]; ?>" data-type="station"></i>-->
                          <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_station'); ?>/<?php echo slug($value["genre"]); ?>/<?php echo slug($value["title"]); ?>-<?php echo $value["idstation"]; ?>?play=1"><i class="cursor-pointer zmdi zmdi-play btn-play-album"></i></a>
                      </div>
                  </div>
                  <div class="data">                    
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_station'); ?>/<?php echo slug($value["genre"]); ?>/<?php echo slug($value["title"]); ?>-<?php echo $value["idstation"]; ?>" class="name truncate" title="<?php echo $value["title"]; ?>"><?php echo $value["title"]; ?></a>                     
                  </div>
              </div>
          </div>
        <?php
      }
}
function render_users($users,$limit)
{
    $CI     =& get_instance(); 
     foreach ($users as $key => $value) {   
       if($key>= $limit)     
        break;
        ?>      
      
          <div class="col-lg-2 col-xs-6 col-md-4 list-thumb-c">
              <div class="thumbnail list-thumb" >
                  <div class="image">
                      <img class="lazy" src="<?php echo base_url(); ?>assets/images/no-picture.png" data-original="<?php echo avatar($value['avatar']); ?>">                
                      <div class="overlay">
                         <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_user'); ?>/<?php echo slug($value["username"]); ?>"></a>
                      </div>
                  </div>
                  <div class="data">
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_user'); ?>/<?php echo slug($value["username"]); ?>"><?php echo $value["username"]; ?></a>
                      <a href="<?php echo base_url(); ?><?php echo $CI->config->item('slug_user'); ?>/<?php echo slug($value["username"]); ?>" class="subdata truncate"><?php echo __("label_followers").' '.number_format($value["likes"],0); ?></a>                    
                  </div>
              </div>
          </div>
        <?php
        }
      

}
function get_ads($block,$class)
{
  if(is_logged() && config_item("hide_ads_registered") == '1')
    return false;
  $slot = substr($block, -1);
  if(config_item("ads_slot".$slot) == '')
    return false;
  $CI     =& get_instance();  
  return $CI->load->view('_common/ads/'.$block,array("class" => $class),true);

}

function get_social_icon($url,$type,$icon = '',$bg = '')
{
  if($icon == '')
    $icon = $type;  
  if($bg == '')
    $bg = $type;
  
  if($url)
    return '<a  target="_blank"  rel="nofollow" href="'.$url.'" class="btn azm-social azm-size-32  azm-'.$bg.' exclude external"><i class="fa fa-'.$icon.'"></i></a>';
}
function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" class="exclude external" target="_blank">$1</a>', $s);
}

function get_download_button($id,$title)
{
  $services = explode(",",config_item("download_services"));
  if(in_array($id,$services))
    return '<a class="list-group-item service service-'.$id.' exclude external" data-s="'.$id.'" target="_download" href="#"><i class="pull-right fa fa-'.$id.'"></i>'.$title.'</a>';
  return '';

}
function get_tabs_trending()
{
  $tabs = config_item("trending_tabs");
  $temp = explode(",",$tabs);

  if(count($temp) <= 1)
    return false;
  $html ='<div class="col-md-12 ">  
    <div class="c">
      <div class="navbar navbar-default">
          <ul class="tabs tabs-ajax nav navbar-nav">              
              <li class="active" data-method="trending_tracks" data-href="#target-custom"><a href="#"><i class="fa fa-music"></i> '.__("label_tracks").'</a></li>';
      if(in_array("artist", $temp))            
        $html .='<li data-method="trending_artists" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-male-female"></i> '.__("label_artists").'</a></li>';
      if(in_array("albums", $temp))            
        $html .= '<li data-method="trending_albums" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-collection-music"></i> '.__("label_albums").'</a></li>';                           
      if(in_array("stations", $temp))            
        $html .= '<li data-method="trending_stations" data-href="#target-custom"><a href="#"><i class="zmdi zmdi-portable-wifi"></i> '.__("label_stations").'</a></li>';                            
    
    $html .= '</ul>
      </div>
    </div>
  </div>  ';
  return $html;
}
?>