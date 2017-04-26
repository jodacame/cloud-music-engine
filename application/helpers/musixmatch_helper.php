<?php

function _search_all($query)
{
	$query 	= urlencode($query);

	if($query == '')
		return false;

	$CI     	=& get_instance(); 
	$url 		="http://music.4p1.co?method=search.all&query=$query&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();	
	
	$json 		= json_decode(_curl($url),TRUE);			


	$save = array();
	foreach ($json['results']['artists'] as $key => $value) 
	{
		$value['genre_1'] 		= $value['primary_genre'];
		$value['genre_2'] 		= $value['secondary_genre'];
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['idsoundcloud']);
		unset($value['primary_genre']);
		unset($value['secondary_genre']);
		unset($value['idx']);
		unset($value['updated']);
		unset($value['twitter']);
		unset($value['tags']);
		$save[] = $value;
		//$CI->Admin->setTableIgnore('artist',$value); 
		
	}

	$CI->Admin->setTable('artist',$save,true); 

	$save = array();
	foreach ($json['results']['tracks'] as $key => $value) 
	{
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['youtube_id']);
		unset($value['updated']);
		unset($value['idx']);	
		$save[] = $value;	
		//$CI->Admin->setTableIgnore('tracks',$value); 
			
	}

	$CI->Admin->setTable('tracks',$save,true); 

	$save = array();
	foreach ($json['results']['albums'] as $key => $value) 
	{
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['crawled']);
		unset($value['updated']);
		unset($value['idx']);
		unset($value['youtube_id']);
		unset($value['length']);	
		$save[] = $value;				
		//$CI->Admin->setTableIgnore('albums',$value); 	

	}
	$CI->Admin->setTable('albums',$save,true); 
	return $json;
	

}

function musixmatch_search_track($query)
{
	$CI     =& get_instance(); 
	$query 	= dslug($query);
	$query 	= slug($query);
	$url 	="http://api.musixmatch.com/ws/1.1/track.search?q_track=$query&apikey=".$CI->config->item("musixmatch_apikey");
	$json 	= json_decode(_curl($url));
	
	
	foreach ($json->message->body->track_list as $key => $value) {
		$track = array();
		$track = array("id" 		=> $value->track->track_spotify_id,
				"track" 			=> $value->track->track_name,
				"popularity" 		=> $value->track->track_rating,
				"album" 			=> $value->track->album_name,			
				"artist" 			=> $value->track->artist_name,	
				"duration" 			=> $value->track->track_length,
				"picture_small" 	=> $value->track->album_coverart_100x100,
				"picture_medium" 	=> $value->track->album_coverart_350x350,
				"picture_extra" 	=> $value->track->album_coverart_500x500
		);
		$tracks[] = $track;
	}
	return $tracks;

}

function _search_artist($query)
{

	$query = urlencode($query);
	if(strtolower(urldecode($query)) == 'various artists')
		return false;

	if($query == '')
		return false;

	$CI     =& get_instance(); 
	$url 		="http://music.4p1.co/?method=artist.search&artist=$query&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();

	$data 		= json_decode(_curl($url),true);

	
	

	
	// Save all artist
	foreach ($data['artists'] as $key => $value) 
	{	
		$value['genre_1'] = $value['primary_genre'];
		$value['genre_2'] = $value['secondary_genre'];
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['idsoundcloud']);
		unset($value['primary_genre']);
		unset($value['secondary_genre']);
		unset($value['idx']);
		unset($value['updated']);
		unset($value['twitter']);
		unset($value['tags']);
		$CI->Admin->setTableIgnore('artist',$value); 
	
		
	}

	
}


function _all_artist_by_id($idmusixmatch,$artist_name)
{

	$CI     			=& get_instance(); 
	$idmusixmatch 		= intval($idmusixmatch);
	$artist_name 			= urlencode(normalize_name($artist_name));
	

	if($idmusixmatch  == 0 || $artist_name == '')
		return false;

	// Info
	$url 		="http://music.4p1.co/?method=artist.get&artist=$artist_name&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();
	
	$data 				= json_decode(_curl($url),TRUE);


	
		

	

	$artist['picture_small'] 	= $data['artist']['picture_small'];
	$artist['picture_medium'] 	= $data['artist']['picture_medium'];
	$artist['picture_extra'] 	= $data['artist']['picture_extra'];
	$artist['genre_1'] 			= normalize_name($data['artist']['primary_genre']);
	$artist['genre_2'] 			= normalize_name($data['artist']['secondary_genre']);
	$artist['country'] 			= $data['artist']['country'];
	$artist['rating'] 			= $data['artist']['rating'];
	$artist['mbid'] 			= $data['artist']['mbid'];
	$artist['idspotify'] 		= $idspotify;
	$artist['crawled'] 			= 1;	
	
	$CI->Admin->updateTable("artist",$artist,array("idmusixmatch" => $idmusixmatch));	
	
	// Albums	
	get_album_artist($data['artist']['artist']);
	get_top_tracks($data['artist']['artist']);
	  
	// Tracks
	//get_all_tracks($data['artist']['artist']);
}
function get_top_tracks($artist)
{
	$artist 	= urlencode($artist);
	$CI     	=& get_instance(); 

	if($artist == '')
		return false;

	$url 		="http://music.4p1.co/?method=artist.topTracks&artist=$artist&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();	
	
	$json 		= json_decode(_curl($url),TRUE);	
	foreach ($json['topTracks'] as $key => $value) {
		
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['youtube_id']);
		unset($value['updated']);
		unset($value['idx']);
		$save[] = $value;
		//$CI->Admin->setTableIgnore('tracks',$value); 
	}
	$CI->Admin->setTable('tracks',$save,true); 
}
function get_related_artist($artist)
{
	$artist 	= urlencode($artist);
	$CI     	=& get_instance(); 

	if($artist == '')
		return false;

	$url 		="http://music.4p1.co/?method=artist.related&artist=$artist&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();	
	
	$json 		= json_decode(_curl($url),TRUE);	
	return $json['related'];
	
}
function get_all_tracks($artist)
{
	$artist 	= urlencode($artist);


	if($artist == '')
		return false;

	$CI     	=& get_instance(); 
	$url 		="http://music.4p1.co/?method=artist.allTracks&artist=$artist&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();	
	
	$json 		= json_decode(_curl($url),TRUE);			
	
	foreach ($json['tracks'] as $key => $value) 
	{
		$value['idmusixmatch'] 	= $value['idx'];
		$id 	= $value['idx'];
		unset($value['youtube_id']);
		unset($value['updated']);
		unset($value['idx']);
		$CI->Admin->setTableIgnore('tracks',$value); 	
		unset($value['idmusixmatch']);
		$CI->Admin->updateTable("tracks",$value,array("idmusixmatch" => $id));	
	}
}

function get_album_artist($artist)
{
	$CI     			=& get_instance(); 
	$artist 			= urlencode(normalize_name($artist));
	

	if($artist == '')
		return false;

		
	$url 		="http://music.4p1.co/?method=artist.albums&artist=$artist&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();		
	$data 			= json_decode(_curl($url),TRUE);
	

	foreach ($data['albums'] as $key => $value) {
		$value['idmusixmatch'] 	= $value['idx'];
		unset($value['crawled']);
		unset($value['updated']);
		unset($value['idx']);
		unset($value['youtube_id']);
		unset($value['length']);		
		$CI->Admin->setTableIgnore('albums',$value); 	
	}

}
function get_album_by_id($artist,$album)
{
	$CI     			=& get_instance(); 
	$artist 			= urlencode(normalize_name($artist));
	$album 				= urlencode(normalize_name($album));
	if($artist == '' || $album == '')
		return false;
	$url 		="http://music.4p1.co/?method=album.get&artist=$artist&album=$album&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();	
	
	$data 			= json_decode(_curl($url),TRUE);
	
	$update['release_date'] 	= $data['album']['release_date'];
	$update['picture_small'] 	= $data['album']['picture_small'];
	$update['picture_medium'] 	= $data['album']['picture_medium'];
	$update['picture_extra'] 	= $data['album']['picture_extra'];
	$update['mbid'] 			= $data['album']['mbid'];			
	$update['crawled'] 			= 1;			


	// Tracks Album
	$url 						="http://music.4p1.co/?method=album.tracks&artist=$artist&album=$album&apikey=".config_item("purchase_code")."&source=nexxuz&refer=".base_url();		
	$json 						= json_decode(_curl($url),TRUE);	
	$update['lenght'] 			= '0';
	if($json['tracks'])	
		$update['lenght'] 		= intval(count($json['tracks']));			


	$CI->Admin->updateTable("albums",$update,array("artist" => urldecode($artist),"album" => urldecode($album)));	
	
	
	unset($update['mbid']);
	unset($update['crawled']);
	unset($update['lenght']);


	foreach ($json['tracks'] as $key => $value) 
	{
		$value['idmusixmatch'] 	= $value['idx'];
		$id 	= $value['idx'];
		unset($value['youtube_id']);
		unset($value['updated']);
		unset($value['idx']);
		$CI->Admin->setTableIgnore('tracks',$value); 	
		unset($value['idmusixmatch']);
		$CI->Admin->updateTable("tracks",$value,array("idmusixmatch" => $id));	
	}
	// Update all tracks whit new info album
	$CI->Admin->updateTable("tracks",$update,array("artist" => urldecode($artist),"album" => urldecode($album)));	



}


?>
