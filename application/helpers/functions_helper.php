<?php

function _curl($url,$post = false,$headers = false,$json = false,$put = false,$cert=false) {    
    $CI     =& get_instance();  

   // $hash   = sha1($url);
   
    //_log("CURL: ".$url);
    $ch = curl_init(); 
    //curl_setopt($ch, CURLOPT_HEADER, 0);  
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    //curl_setopt($ch,CURLOPT_USERAGENT,"Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);    
    curl_setopt($ch,CURLOPT_REFERER,base_url());  
    if($post)
    {
        $fields_string  = "";
        if(is_array($post))
        {
            foreach($post as $key => $value)
            {
                $fields_string .= $key."=".$value."&";
            }
            $fields_string          =rtrim ($fields_string,'&');
        }
        else
        {
            $fields_string          = $post;   
        }
        
        if($json)
        {
            $headers[]              = 'Accept: application/json';           
            $headers[]              = 'Content-Type: application/json';         
            
            $fields_string = json_encode($post);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POST,count($post));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    }
    if(strtolower(parse_url($url, PHP_URL_SCHEME)) == 'https')
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
        if($cert)
        {            
            curl_setopt($ch, CURLOPT_CAINFO, $cert); 
        }
    }
    if($CI->config->item("proxy") != '')
    {       
        curl_setopt($ch, CURLOPT_PROXY, $CI->config->item("proxy"));
    }
     if($headers)
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if($put)
    {
        if($put === true)
            $put = "PUT";
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $put);
        //curl_setopt($ch, CURLOPT_PUT, true);
    }

    curl_setopt($ch, CURLOPT_URL, $url); 
    $data = curl_exec($ch);
    curl_close($ch); 
     //_log("CURL END");
    return $data;
}

function is_logged()
{
    $CI     =& get_instance();
    
    if(intval($CI->session->userdata['user']['id'])>0)
        return true;
    return false;
}
function is_admin()
{
    $CI     =& get_instance();    
    if(intval($CI->session->userdata['user']['is_admin'])>0)
        return true;
    return false;
}
function is_sadmin()
{
    $CI     =& get_instance();    
    if(intval($CI->session->userdata['user']['is_admin'])>0)
        return true;
    return false;
}
function is_ajax()
{
    $CI     =& get_instance();   
    return $CI->input->is_ajax_request();
}
function is_mobile()
{
    $CI     =& get_instance();   
    return $CI->agent->is_mobile();
}
function getUserID()
{
    $CI     =& get_instance();
    return intval($CI->session->userdata['user']['id']);
}
function is_spotify()
{
    $CI     =& get_instance();    
    if($CI->session->userdata['user']['spotify']['access_token'])
        return true;
    return false;
}
function tdrows($elements)
{
    $str = "";
    foreach ($elements as $element) {
        $str .= $element->nodeValue . "||||";
    }

    return $str;
}

function getCountryCode()
{
   
    $CI     =& get_instance();  
    if($CI->session->geoplugin_countryCode)
        return $CI->session->geoplugin_countryCode;
    $ip         = $CI->input->ip_address();
    $url = "http://www.geoplugin.net/json.gp?ip=$ip";
    $data = json_decode(_curl($url));
    $code = $data->geoplugin_countryCode;
    if($code != '')
        $CI->session->set_userdata('geoplugin_countryCode', $code);
    if($code == '')
        $code = 'us';
    return $code;

}

function getLang()
{

    $lang = mb_strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    if($lang != '')
        return $lang;
    return 'en';
}
function getYoutube($artist,$track,$country_code)
{   
    if(!$country_code)
        $country_code = 'us';
    $CI     =& get_instance();      
    
    $artist = urldecode($artist);
    
    $track  = urldecode($track);

    $query  = urlencode($artist." ".$track);

     
    
    
    $url = "https://www.googleapis.com/youtube/v3/search?videoEmbeddable=true&part=snippet&q=$query&type=video&maxResults=1&key=".trim($CI->config->item("youtube_apikey"))."&regionCode=".getCountryCode();
  
  
    
    $json   = _curl($url);  
    
    
    //print_p($json);
    $temp = json_decode($json);

    if($temp->error->errors)
    {
        $jtmep['error'] = true;
        $jtmep['message'] = $temp->error->errors[0]->message;
        return json_encode($jtmep);        
    }    
    return $temp->items[0]->id->videoId;  
}

function get_artist_info($artist)
{
    $CI     =& get_instance();   
    $lang   = $CI->session->user['lang'];
    if(!$lang)
        $lang = 'en';

    // Search Local
    $bio = $CI->Admin->getTable("artist_bio",array("artist" => dslug($artist),"lang" => $lang));
    if($bio->num_rows() > 0)
    {
        return $bio->row_array();
    }

    $url    = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=$artist&api_key=".$CI->config->item("lastfm_apikey")."&format=json&autocorrect=1&lang=".$lang;
    $json   = _curl($url);
    $json   = str_ireplace("#text", "text", $json);
    $json = json_decode($json);
    
    $save['genre_1']        = $json->artist->tags->tag[0]->name;
    $save['genre_2']        = $json->artist->tags->tag[1]->name;
    
    $data['lang']            = $lang;
    $data['artist']          = dslug($artist);
    $data['bio']            = $json->artist->bio->content;
    // Fixed Genres 
    $CI->Admin->updateTable("artist",$save,array("artist" => dslug($artist)));    
    // BIO SAVE
    $CI->Admin->setTableIgnore("artist_bio",$data);
    return $data;


}
function get_tracks_genres($genre)
{
    $CI     =& get_instance(); 
    $data = $CI->db->query("SELECT {PRE}artist.* 
        FROM        
        {PRE}artist
        where         
        genre_1 = '$genre' OR genre_2 = '$genre'        
        ORDER BY likes,crawled DESC
        limit 250
         ");
     return $data->result_array();
}
function get_popular_genres()
{
    $query ="SELECT  avg(rating) as likes,picture_medium as image, genre_2  as name FROM `{PRE}artist` where rating > 0 AND genre_2 != '' group by genre_2  HAVING COUNT(*) > 5 order by likes desc limit 500";
    $CI     =& get_instance(); 
    $data = $CI->db->query($query);    
    $temp = $data->result_array();

 
    return $temp;
}
function get_lyric($artist,$track)
{   
     _log("Searching Lyric: ".dslug($track));
    $CI     =& get_instance(); 
    $track = dslug($track);
    $track = explode("-", $track);
    $track = rtrim(ltrim($track[0]));
    $track = slug($track);
   
    // Search Local
    $lyric = $CI->Admin->getTable("tracks_lyrics",array("artist" => dslug($artist),"track" => dslug($track)));
    
    if($lyric->num_rows() > 0)
    {
        $temp = $lyric->row();
        if(!$temp->lyric)
        {

             $temp->lyric = '<div class="alert alert-warning">                                                                                          
                                '.__("label_lyric_nofound").'                                                                                                       
                                </div>';
             
        }
         if($CI->config->item("purchase_code") == '')
        {
              $temp->lyric = '<div class="alert alert-warning">                                                                                          
                                The license key is not valid                                                                                                      
                                </div>';
        }

        return $temp->lyric."<!--Cache -->";
    }


   
    $lyric = get_lyric_vagalume($artist,$track);

    $save['artist'] = dslug($artist);
    $save['track']  = dslug($track);
    $save['lyric']  = $lyric;    
    $CI->Admin->setTableIgnore("tracks_lyrics",$save);
    return $lyric;
}

function get_lyric_vagalume($artist,$track)
{

    $url    = "http://api.vagalume.com.br/search.php?art=$artist&mus=$track";   
    $data   = _curl($url);      
    $lyric = json_decode($data);    

    if($lyric->type == 'exact')
        $l = nl2br($lyric->mus[0]->text);
    return $l;
}


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
function dslug($string)
{
    //$string = str_ireplace("-", "+", $string);
    //return urldecode($string);
    $string = urldecode($string);
    //$string = stripslashes($string);
    $string = addslashes($string);
    
    $string = str_ireplace("/", "-", $string);
    


    return $string;
}

function _ucwords($str)
{
    return mb_convert_case(mb_strtolower($str), MB_CASE_TITLE, "UTF-8");
}
function _strtolower($str)
{
    return mb_strtolower($str);
}

function _url_title($string,$remove=false)
{
    $string = mb_strtolower($string, 'UTF-8');    
    if($remove)
    {
        $string = str_ireplace("'", "",$string);
    }
    $string = str_ireplace("'", "%27",$string);
    $string = str_ireplace('"', "",$string);
    $string = str_ireplace('(', " ",$string);
    $string = str_ireplace(')', " ",$string);
    $string = str_ireplace(',', " ",$string);
    $string = str_ireplace(" ", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("+", "-",$string);
    $string = str_ireplace('&', "and",$string);
    $string = str_ireplace('*', "",$string);
    return $string;
}
function _clean_special($string) {
   

   return preg_replace('/[^a-zA-Z0-9ñÑ\s]/', '', $string);
}

function _clean_string($string)
{
    $string = str_ireplace("'", "",$string);
    $string = str_ireplace('"', " ",$string);                
    return $string;
}

function slug($string)
{    
    $string = normalize_name($string);
    return urlencode($string);
    return _url_title(convert_accented_characters($string));
}
function get_slug($slug)
{
    $CI     =& get_instance();     
    return $CI->config->item('slug_'.$slug);
}
function prepare($json)
{
    $json =  str_ireplace("</a","</span",str_ireplace("<a", "<span", $json));
    $json = str_ireplace("#text", "text", $json);
    return $json;
}
function mmss($seconds) {
  $t = round($seconds/1000);
  return sprintf('%02d:%02d', ($t/60%60), $t%60);
}
function _log($data)
{   
    $CI         =& get_instance(); 
    if($data == 'query' || $data=='db')
        $data = $CI->db->last_query();
    
    Console::log($data);
}
function track($artist,$album,$track)
{
    
    $CI         =& get_instance(); 
    $obj        = $CI->db->get_where("tracks",array("artist" => urldecode($artist),"track" => urldecode($track),"album" => urldecode($album)));
    _log("Searching Track: ".dslug($track));   
    if($obj->num_rows() == 0)        
    {
        _log("Track No Found");
        _log("Searching Track without Album");        
        $obj        = $CI->db->get_where("tracks",array("artist" => urldecode($artist),"track" => urldecode($track)));        
        if($obj->num_rows() == 0)  
        {
            _log("Track No Found");
            _log("Searching Track on API");
            _search_all(dslug($track)." ".dslug($artist));               
        }    
    }    
    if($obj->num_rows() == 0)         
        $obj        = $CI->db->get_where("tracks",array("artist" => dslug($artist),"track" => dslug($track),"album" => dslug($album)));
            
    if($obj->num_rows() == 0)
    {
        _log("Track No Found");
        _log("Searching Similar Track");
        $temp = explode(" ",dslug($artist));
        $artist2 = $temp[0];
        $CI->db->like("artist",$artist2);
        $obj        = $CI->db->get_where("tracks",array("track" => dslug($track)));
    }          
        
    
   // echo $CI->db->last_query();
    $data = $obj->row_array();


    return $data;
}
function similar_name_track($query)
{
    
    $CI         =& get_instance(); 
    $query      = addslashes(dslug($query));
    $obj        = $CI->db->query("SELECT * FROM {PRE}tracks WHERE track like '%$query%' GROUP BY track,artist limit 10");
    
    $data = $obj->result_array();
    return $data;
}

function album($artist,$album)
{

    $artist_ok = $artist;
    $CI     =& get_instance(); 
    
    // Album
    $obj      = $CI->db->get_where("albums",array("artist" => urldecode($artist),"album" => urldecode($album)));    
    $data       = $obj->row_array();
    _log("Artist: ". dslug($artist));
    _log("Album: ". dslug($album));
    if(count($data)==0)
    {   
        _log("Album No Found");
        //_search_artist(dslug($artist));
        get_album_by_id(dslug($artist),dslug($album));
        _log("Search Album on API: ".dslug($artist)." ".dslug($album));
        $artist = $CI->db->get_where("artist",array("artist" => urldecode($artist)))->row_array();                            
        if($artist)
        {   
            $obj      = $CI->db->get_where("albums",array("artist" => urldecode($artist),"album" => urldecode($album)));    
            $data       = $obj->row_array();
        }
    }
    _log($data);
    if(intval($data['crawled']) == 0 || getDaysDiff($data['updated'],date("Y-m-d H:i:s")) >= 15 || count($data) == 0)    
    {
        _log("Crawling Album....");
        get_album_by_id($data['artist'],$data['album']);        
        $CI->Admin->updateTable('albums',array("crawled"=> 1),array("idalbum" => $data['album']['idalbum']));  
    }
    $obj      = $CI->db->get_where("albums",array("artist" => urldecode($artist_ok),"album" => urldecode($album)));    
    $data['album'] = $obj->row_array();
    $obj      = $CI->db->get_where("tracks",array("artist" => urldecode($artist_ok),"album" => urldecode($album)));    

    $data['tracks'] = $obj->result_array();

    if(!$data['album'])
    {
         $data['album']['album'] = $data['tracks'][0]['album'];
         $data['album']['artist'] = $data['tracks'][0]['artist'];
    }
    
    return $data;
}
function  similar($genre_1,$idartist)
{
    $CI         =& get_instance(); 
    if($genre_1)
        return  $CI->db->query("SELECT * FROM {PRE}artist WHERE genre_1 = '$genre_1' AND  idartist != $idartist ORDER BY likes,rating desc LIMIT 24")->result_array();
    return false;
}

function artist_by_id($id)
{
    $CI         =& get_instance(); 
    $data       = _artist_by_id($id);   
    $CI->Admin->setTableIgnore('artist',$data);   
}
function track_by_id($id)
{
    $CI         =& get_instance(); 
    $data       = _track_by_id($id);   
    $CI->Admin->setTableIgnore('tracks',$data);   
}
function album_by_id($id)
{
    $CI         =& get_instance(); 
    $data       = _album_by_id($id);   
    $CI->Admin->setTableIgnore('albums',$data['album']);   
    $CI->Admin->setTable('tracks',$data['tracks'],true);   
}
function artist($artist,$showError = true)
{
    $CI     =& get_instance(); 
    
     _log("Artist: ". dslug($artist));

    $obj    = $CI->db->get_where("artist",array("artist" => urldecode($artist)));
    if($obj->num_rows() == 0)
    {
        _log("Artist No Found");
        _log("Searching Artist on API");        
        search_all(dslug($artist));
        $obj    = $CI->db->get_where("artist",array("artist" => urldecode($artist)));
    }
    $data   = $obj->row_array();     

    if(count($data) == 0)    
    {
       _log("Crawling artist");
        _search_artist(dslug($artist));
        //search_all(dslug($artist));
        $obj    = $CI->db->get_where("artist",array("artist" => urldecode($artist)));
    }   
    
    
    if($obj->num_rows() == 0)
    {       
            _log("Artist No Found");       
            return false;
    }

    $data                   = $obj->row_array();      

    // Update Every X Days
    if(intval($data['crawled']) == 0|| getDaysDiff($data['updated'],date("Y-m-d H:i:s")) >= 15)    
    {
        _all_artist_by_id($data['idmusixmatch'],$data['artist']);
         _log("Crawling artist");
        $CI->Admin->updateTable('artist',array("crawled"=> 1),array("idartist" => $data['idartist']));  
    }
    _log("Get Albums");
    $obj = $CI->Admin->getTable("albums",array("artist" =>  $data['artist'])) ;
    $data['albums']         = $obj->result_array();     
    _log("Get Related");
    $data['similar']        = similar($data['genre_1'],$data['idartist']);
    _log("Get Info");
    $data['info']           = get_artist_info($artist);
    return $data;
}

function top_tracks($artist)
{
    $CI     =& get_instance(); 

    $obj = $CI->db->query("SELECT * from {PRE}tracks where artist = '".dslug($artist)."' GROUP BY track order by likes,popularity DESC LIMIT 50");       
    return $obj->result_array() ;
             
    
}
function lyric($artist,$track)
{

    $artist     = urlencode(dslug($artist));
    $track     = urlencode(dslug($track));    
    return _lyric($artist,$track);
}
function search_artist($query)
{

    $query     = urlencode(dslug($query));
    return _search_artist($query);
}
function search_album($query)
{
    $query     = urlencode(dslug($query));
    return _search_album($query);
}
function search_track($query)
{
    $query     = urlencode(dslug($query));
    return _search_track($query);
}
function search_playlist($query)
{
    $query     = urlencode(dslug($query));
    return _search_playlist($query);
}
function _debug($msg)
{
    Console::log_memory();
    if(is_array($msg))
    {
        Console::log(date("H:i:s"));
        Console::log($msg);
    }
    else
        Console::log(date("H:i:s")." ".$msg);
}
function search_all($query)
{
    
    $CI     =& get_instance(); 

    _log("Searching ".$query);

    $temp_search    = _search_all($query);


    $query          = urldecode(dslug($query));
    
    //$query =$CI->db->escape_str($query);
    $query =addslashes($query);

   
    
    foreach ($temp_search['results']['tracks'] as $key => $value) 
        $keys[] = $value['idx'];    

    foreach ($temp_search['results']['albums'] as $key => $value) 
        $keys_albums[] = $value['idx'];

    foreach ($temp_search['results']['artists'] as $key => $value) 
        $keys_artists[] = $value['idx'];

   
    
        if(config_item('search_engine') == 'remote')
        {
            _log("Using Remote API");
            // Tracks
           if(count($keys) == 0)        
                 $obj_tracks    = $CI->db->query("SELECT * FROM {PRE}tracks WHERE MATCH(artist,track) AGAINST('$query' IN BOOLEAN MODE) GROUP BY artist,track ORDER BY MATCH(artist,track) AGAINST('$query' IN BOOLEAN MODE) DESC   limit 50");                                          
           else           
                $obj_tracks    = $CI->db->query("SELECT * FROM {PRE}tracks WHERE  idmusixmatch IN (".implode(",", $keys).")");                            

            // Albums
            if(count($keys_albums) == 0)
                $obj_albums    = $CI->db->query("SELECT * FROM {PRE}albums WHERE MATCH(artist,album) AGAINST('$query') GROUP BY album ORDER BY MATCH(artist,album) AGAINST('$query') DESC   limit 50");        
            else
                $obj_albums    = $CI->db->query("SELECT * FROM {PRE}albums WHERE  idmusixmatch IN (".implode(",", $keys_albums).")");                            
            
            // Artist
            if(count($keys_artists) == 0)
                $obj_artists    = $CI->db->query("SELECT * FROM {PRE}artist WHERE MATCH(artist) AGAINST('$query') GROUP BY artist ORDER BY MATCH(artist) AGAINST('$query') DESC   limit 50");        
           else 
                $obj_artists    = $CI->db->query("SELECT * FROM {PRE}artist WHERE  idmusixmatch IN (".implode(",", $keys_artists).")");                            
            
           
        }
        else
        {
            // Tracks
            $obj_tracks    = $CI->db->query("SELECT * FROM {PRE}tracks WHERE MATCH(track,artist) AGAINST('$query' IN BOOLEAN MODE) GROUP BY track,artist ORDER BY MATCH(track,artist) AGAINST('$query' IN BOOLEAN MODE) DESC   limit 50");           
            if($obj_tracks->num_rows() == 0)
                $obj_tracks    = $CI->db->query("SELECT * FROM {PRE}tracks WHERE artist LIKE '%$query%' OR track LIKE '%$query%'  order by popularity DESC limit 50");        

            // Albums
            $obj_albums    = $CI->db->query("SELECT * FROM {PRE}albums WHERE MATCH(artist,album) AGAINST('$query') GROUP BY album ORDER BY MATCH(artist,album) AGAINST('$query') DESC   limit 50");        

            // Artist
            $obj_artists    = $CI->db->query("SELECT * FROM {PRE}artist WHERE MATCH(artist) AGAINST('$query') GROUP BY artist ORDER BY MATCH(artist) AGAINST('$query') DESC   limit 50");        
        }       
           
        $json['tracks'] =  $obj_tracks->result_array();    
        // Artist   
        
        $json['artists'] =  $obj_artists->result_array();
        
        
        $json['albums'] =  $obj_albums->result_array();
    
    

    _log("Searching Playlist");
        
         // Playlist
    
     $obj    = $CI->db->query("SELECT {PRE}playlists.idplaylist,artist,{PRE}playlists.image,{PRE}playlists.image as picture_small,{PRE}playlists.image as picture_medium,{PRE}playlists.image as picture_extra,track,name, MATCH ( artist, track, name) 
                AGAINST ('+".$query."' IN BOOLEAN MODE) as score
                FROM {PRE}playlists,{PRE}playlists_tracks
                WHERE
                MATCH ( artist, track, name) AGAINST ('+".$query."' IN BOOLEAN MODE)
                AND {PRE}playlists.idplaylist = {PRE}playlists_tracks.idplaylist
                group by name ORDER BY score desc limit 50;
                "); 
    
        //echo $CI->db->last_query();
        
          $json['playlists'] = $obj->result_array();  


          // Stations
    _log("Searching Stations");
     $obj    = $CI->db->query("SELECT {PRE}stations.*, 
                MATCH ( artist, track,title,description,genre) 
                AGAINST ('+".$query."' IN BOOLEAN MODE) as score
                FROM {PRE}stations_tracks,{PRE}stations
                WHERE
                MATCH ( artist, track,title,description,genre) AGAINST ('+".$query."' IN BOOLEAN MODE) 
                AND {PRE}stations.idstation = {PRE}stations_tracks.idstation
                group by title,cover ORDER BY score desc  limit 50;
                ");
  
        //echo $CI->db->last_query();
        
          $json['stations'] = $obj->result_array();
          
    // Users
    _log("Searching Users");
        $obj    = $CI->db->query("SELECT username,avatar,likes from {PRE}users where username like '%$query%' or email like '%$query%' limit 50");
  
        //echo $CI->db->last_query();
        
          $json['users'] = $obj->result_array();
    
    // Lyrics    
    /*$obj    = $CI->db->query(" SELECT * FROM {PRE}tracks_lyrics WHERE MATCH (lyric) AGAINST ('$query');");  
    
    $json['lyrics'] = $obj->result_array();*/



        



    return $json;    
       
    
    
}

function searchStation($query,$limit = 50)
{
    $query = addslashes($query);
     $CI     =& get_instance(); 
       $obj    = $CI->db->query("SELECT {PRE}stations.*, 
                MATCH ( artist, track,title,description,genre) 
                AGAINST ('+".$query."' IN BOOLEAN MODE) as score
                FROM {PRE}stations_tracks,{PRE}stations
                WHERE
                MATCH ( artist, track,title,description,genre) AGAINST ('+".$query."' IN BOOLEAN MODE) 
                AND {PRE}stations.idstation = {PRE}stations_tracks.idstation
                group by title,cover ORDER BY score desc  limit $limit;
                ");
  
        //echo $CI->db->last_query();
        
          return $obj->result_array();

}
function playlist_artist($artist)
{       
    
    $CI     =& get_instance();   
    $artist = addslashes(dslug($artist));
    $obj    = $CI->db->query("SELECT {PRE}playlists.idplaylist,artist,{PRE}playlists.image,{PRE}playlists.image as picture_small,{PRE}playlists.image as picture_medium,{PRE}playlists.image as picture_extra,track,name
                FROM {PRE}playlists,{PRE}playlists_tracks
                WHERE   
                {PRE}playlists_tracks.artist = '$artist'             
                AND {PRE}playlists.idplaylist = {PRE}playlists_tracks.idplaylist
                group by name ORDER BY likes desc limit 10;
                "); 
      return $obj->result_array();
}
function get_new_releases()
{
    $CI     =& get_instance();
    $data = $CI->db->query("SELECT * FROM {PRE}albums  WHERE release_date != '' and album not like '%karaoke%' AND lenght > 0 ORDER BY release_date DESC limit 50");
    //$data = $CI->Admin->getTable("albums",false,"release_date desc",false,0,50);
    return $data->result_array();

}
function get_trending($type = 'tracks',$object = false)
{   
    
    $CI     =& get_instance();  

  

    switch ($type) {
        case 'tracks':        
              if($CI->config->item("trending_tracks_source") == 'musixmatch')
                    return get_trending_musixmatch($type);   
             if($CI->config->item("trending_tracks_source") == 'itunes')
                    return get_trending_itunes($type);    
             $obj = $CI->db->query("SELECT 
                            count(*) as likes,
                            {PRE}tracks.idtracks,
                            {PRE}tracks.track,
                            {PRE}tracks.album,
                            {PRE}tracks.artist,
                            {PRE}tracks.picture_small,
                            {PRE}tracks.picture_medium,
                            {PRE}tracks.picture_extra
                            FROM
                            {PRE}tracks,{PRE}likes
                            WHERE 
                            {PRE}likes.type=3 AND
                            {PRE}likes.idtarget = {PRE}tracks.idtracks AND
                            {PRE}likes.created >= ( CURDATE() - INTERVAL 180 DAY )
                            GROUP BY {PRE}tracks.artist,{PRE}tracks.track
                            ORDER BY likes DESC,created desc
                            LIMIT 50");
            break;
          case 'artists':
             $obj = $CI->db->query("SELECT 
                            count(*) as likes,
                            {PRE}artist.idartist,                                                      
                            {PRE}artist.artist,
                            {PRE}artist.picture_small,
                            {PRE}artist.picture_medium,
                            {PRE}artist.picture_extra
                            FROM
                            {PRE}artist,{PRE}likes
                            WHERE 
                            {PRE}likes.type=1 AND
                            {PRE}likes.idtarget = {PRE}artist.idartist AND
                            {PRE}likes.created >= ( CURDATE() - INTERVAL 180 DAY )
                            GROUP BY {PRE}artist.artist
                            ORDER BY likes DESC,created desc
                            LIMIT 50");
            break;
          case 'albums':
             $obj = $CI->db->query("SELECT 
                            count(*) as likes,
                            {PRE}albums.idalbum,                            
                            {PRE}albums.album,
                            {PRE}albums.artist,
                            {PRE}albums.picture_small,
                            {PRE}albums.picture_medium,
                            {PRE}albums.picture_extra
                            FROM
                            {PRE}albums,{PRE}likes
                            WHERE 
                            {PRE}likes.type=2 AND
                            {PRE}likes.idtarget = {PRE}albums.idalbum AND
                            {PRE}likes.created >= ( CURDATE() - INTERVAL 180 DAY )
                            GROUP BY {PRE}albums.artist,{PRE}albums.album
                            ORDER BY likes DESC,created desc
                            LIMIT 50");
            break;
          case 'stations':
             $obj = $CI->db->query("SELECT 
                            count(*) as likes,
                            {PRE}stations.*                                                      
                            FROM
                            {PRE}stations,{PRE}likes
                            WHERE 
                            {PRE}likes.type=5 AND
                            {PRE}likes.idtarget = {PRE}stations.idstation                            
                            GROUP BY {PRE}stations.idstation
                            ORDER BY likes DESC,created desc
                            LIMIT 50");
            break;

        default:
            # code...
            break;
    }
    if($object)
        return $obj;
    
    return  $obj->result_array();
    
}

function get_trending_musixmatch($type)
{
    $CI     =& get_instance();  
    if($type == 'tracks')
    {
        $url    = "http://api.musixmatch.com/ws/1.1/chart.tracks.get?page=1&page_size=50&country=".getCountryCode()."&apikey=".$CI->config->item('musixmatch_apikey');
        $json   = json_decode(_curl($url));
        foreach ($json->message->body->track_list as $key => $value) 
        {
         
                            $track = array();                           
                            $track['track']             = normalize_name($value->track->track_name);
                            $track['album']             = normalize_name($value->track->album_name);
                            $track['artist']            = normalize_name($value->track->artist_name);
                            $track['picture_small']     = str_ireplace("http://", "//", $value->track->album_coverart_100x100);
                            $track['picture_medium']    = str_ireplace("http://", "//", $value->track->album_coverart_500x500);
                            if(!$track['picture_medium'])
                                $track['picture_medium'] = $track['picture_small'];
                            $track['picture_extra']     = str_ireplace("http://", "//", $value->track->album_coverart_800x800);
                            if(!$track['picture_extra'])
                                $track['picture_extra'] = $track['picture_medium'];
                               
                            
        }
        
    }
    return $return;
}
function get_trending_itunes()
{
    $url    = "https://itunes.apple.com/us/rss/topsongs/limit=100/json";
    $data   = _curl($url); 
    $data   = str_ireplace("itms:", "", $data);
    $data   = str_ireplace("im:", "", $data);  
    $data   = json_decode($data);   

     foreach ($data->feed->entry as $key => $value) {

        $json[]     = array('artist' => $value->artist->label,
                            'track' => $value->name->label,
                            'album' => $value->collection->name->label,
                            'picture_small' => $value->image[2]->label,
                            'picture_medium' => $value->image[2]->label,
                            'picture_extra' => $value->image[2]->label,

                            );
    }
    return $json;
}
function get_trending_deezer()
{
    $url    = "http://api.deezer.com/chart/0/tracks?limit=100";
    $data   = _curl($url);          
    $data   = str_ireplace("itms:", "", $data);
    $data   = str_ireplace("im:", "", $data);
    $data   = json_decode($data);
    
    foreach ($data->data as $key => $value) {
        $json[]     = array('artist' => $value->artist->name,
                            'track' => $value->title,
                            'album' => $value->album->title,
                            'picture_small' => $value->album->cover_small,
                            'picture_medium' => $value->album->cover_medium,
                            'picture_extra' => $value->album->cover_big,

                            );
    }
    return  $json;
}
function print_p($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function validate_picture($img)
{
    if($img == '')
    {
        $img = base_url()."assets/images/no-picture.png";
    }
    return $img;
}
function __($code)
{
    $translation = config_item('translation');
    $label = $translation[$code];    
    
    if($label)
        return $label;
    return $code;
}
function createFolder($folder)
{
    if(!file_exists($folder))
    {
        mkdir($folder);
    }
       
}
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function uploadImage($folder,$file_name,$input)
{

       
        $CI     =& get_instance();          
        $config['upload_path']      = $folder;
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = return_bytes(ini_get('post_max_size'));              
        $config['overwrite']        = FALSE;             
        $config['file_name']        = $file_name;
        
        $CI->load->library('upload', $config);
        if ( ! $CI->upload->do_upload($input))
        {               
            $r =  strip_tags($CI->upload->display_errors());      
            return array('error' =>  $r);
        }
        else
        {
            
            $r = $CI->upload->data();     
            $config['image_library']    = 'gd2';
            $config['source_image']     = $config['upload_path']."/".$r['file_name'];
            $config['create_thumb']     = FALSE;
            $config['maintain_ratio']   = TRUE;
            $config['width']            = 600;
            $config['height']           = 600;            
            $CI->load->library('image_lib', $config);           
            if (!$CI->image_lib->resize())
            {
                    echo $CI->image_lib->display_errors();
                    die();
            }
            return array("image" => $r['file_name']);            
        }
}

function ago($time)
{
    
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference ".__($periods[$j]);
}

function normalizer($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        $cadena = str_ireplace("-", " ", $cadena);        
        $cadena = ltrim($cadena);
        $cadena = rtrim($cadena);
        return utf8_encode($cadena);
}

function get_header_curl($url)
{

    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); //timeout in seconds
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER,true);
    //curl_setopt($ch, CURLOPT_NOBODY, true);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    curl_exec($ch);     

    return curl_getinfo($ch, CURLINFO_CONTENT_TYPE);                
}

function isok($code)
{

    if(!$code)
        return array("error" => "Key Empty");
  

    $license = json_decode(_curl("http://key.nexxuz.com?key=$code"));    
    if(!$license->date)
        return array("error" => "Key No valid");      
     $return['created_at']      = $license->date;
     $return['product_name']    = "Nexxuz: Cloud Music Engine";
     $return['license']         = $license->type." <i>(IP Address Authorized: ".$license->ipserver.")</i>";
     $return['buyer']           = $license->buyer;      
    return $return;
}

function search_itunes($query)
{
    $CI         =& get_instance();  
    $id         = $CI->config->item("itunes_afiliate");
    if($id  == '')
         $id = '10lJNg';
    $query      = slug($query);   
    $url       = "http://itunes.apple.com/search?term=$query&media=music&at=$id&limit=1&country=".getCountryCode();
    $data = _curl($url);
    return $data;
}

function more($string,$len=100)
{    
    return ltrim(substr(strip_tags($string), 0,$len))."...";
}
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}  

function email($to,$subject,$message)
{   

        $CI         =& get_instance();  
        //$CI->email->clear();
        $CI->email->set_newline("\r\n");
        $CI->email->to($to);
        $CI->email->from(config_item("smtp_from"),config_item("site_title"));
        $CI->email->subject($subject);
        $CI->email->message($message);
        $CI->email->send();

}

function normalize_name($str)
{
    $str = str_replace("&","And", $str);
    $remove = array("/","+","?","&","[","]");
    $str = str_replace($remove, " ",$str);
    return $str;
}
function set_https_url($url,$force = true)
{
    if($force)
        return str_ireplace("http://", "https://",$url);
    return $url;
}

function getDaysDiff($date_start,$date_end)
{
    $days   = (strtotime($date_start)-strtotime($date_end))/86400;
    $days   = abs($days); $days = floor($days);     
    return $days;
}