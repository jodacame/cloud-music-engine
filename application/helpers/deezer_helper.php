<?php

function _artist($query)
{
	
				
		
		$url 				= "http://api.deezer.com/search/artist?q=$query&limit=1";				
		$json 				= _curl($url);		
		$json  				= json_decode($json);
		$idartist 			= $json->data[0]->id;				
		$data['artist']		= $json->data[0]->name;
		$data['picture']	= $json->data[0]->picture_big;
		$data['mbid']		= $json->data[0]->id;
		$data['name']		= $json->data[0]->name;
		$data['plays']		= 0;
		$json  				= json_decode(_curl($json->data[0]->tracklist));
		foreach ($json->data as $key => $value) {
			
			$data['toptracks'][] = array('name' => $value->title,'artist' => $value->artist->name,'picture' => $value->album->cover_medium,'album' => $value->album->title);
		}
		
		return $data;


}
function _search_track($query)
{
	
	$url 	= "https://api.deezer.com/search/track?q=$query&limit=100";							
	$json 	= _curl($url);		
	$json  	= json_decode($json);				
	$data 	= array();
	$unique	= array();
	foreach ($json->data as $key => $value) 
	{
		$data_t = array();
		$data_t['name'] 			= $value->title;
		$data_t['artist'] 			= $value->artist->name;		
		$data_t['deezer'] 			= $value->id;		
		$data_t['album'] 			= $value->album->title;		
		$data_t['album_id']			= $value->album->id;		
		$data_t['plays']			= $value->rank;		
		$data_t['picture_small'] 	= $value->album->cover."?size=small";
		$data_t['picture_medium'] 	= $value->album->cover."?size=medium";
		$data_t['picture_extra'] 	= $value->album->cover."?size=big";
		if(!$unique[sha1($value->title.$value->artist->name)])
			$data[] = $data_t;
		$unique[sha1($value->title.$value->artist->name)] = true;
	
	}	
	return $data;	

}


function _search_album($query)
{
		
	
	$url ="https://api.deezer.com/search/album?q=$query&limit=100";						
	$json = _curl($url);		
	$json  = json_decode($json);				
	$data 	= array();
	foreach ($json->data as $key => $value) 
	{
		
		$data_t = array();
		$data_t['name'] 			= $value->title;
		$data_t['artist'] 			= $value->artist->name;		
		$data_t['deezer'] 			= $value->id;		
		$data_t['picture_small'] 	= $value->cover."?size=small";
		$data_t['picture_medium'] 	= $value->cover."?size=medium";
		$data_t['picture_extra'] 	= $value->cover."?size=big";
		$data[] = $data_t;
	
	}		
	return $data;
}

function _search_artist($query)
{

	$url 		= "http://api.deezer.com/search/artist?q=$query&limit=50";		
	$json 		= _curl($url);		
	$json  		= json_decode($json);
	$data 		= array();
	foreach ($json->data as $key => $value) 
	{
		$data_t = array();
		$data_t['name'] 			= $value->name;
		$data_t['mbid'] 			= $value->mbid;
		$data_t['deezer'] 			= $value->id;
		$data_t['picture_small'] 	= $value->picture_small;
		$data_t['picture_medium']	= $value->picture_medium;		
		$data_t['picture_extra'] 	= $value2->picture_big;		
		$data[] = $data_t;
	}	
	return $data;

}

	
function _search_playlist($query)
{
	
	$url 		= "http://api.deezer.com/search/playlist?q=$query&limit=10";		
	$json 		= _curl($url);		
	$json  		= json_decode($json);
	$data 		= array();
	
	foreach ($json->data as $key => $value) 
	{
		$data_t = array();
		$data_t['name'] 			= $value->title;
		$data_t['user'] 			= $value->user->name;			
		$data_t['deezer'] 			= $value->id;
		$data_t['source'] 			= 'deezer';
		$data_t['lenght'] 		= $value->nb_tracks;
		$data_t['picture_small'] 	= $value->picture."?size=small";
		$data_t['picture_medium'] 	= $value->picture."?size=medium";
		$data_t['picture_extra'] 	= $value->picture."?size=big";		
		$data[] = $data_t;
	}	
	return $data;
}


	
