<?php
function _track($artist,$track)
{
	$CI     =& get_instance();  
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.getInfo&api_key=".$CI->config->item("lastfm_apikey")."&artist=$artist&track=$track&format=json&autocorrect=1";
	
	$json 	= json_decode(prepare(_curl($url)));	

	if($json->error)
	{
		$data['error'] = $json->message;
		//show_error($json->message,500);		
	}
	for($x=0;$x<=4;$x++)
	{
		if($json->track->album->image[$x]->text != '')
		{
			$data['picture'] 	=	$json->track->album->image[$x]->text ;
		}
	}		
	$data['picture'] 	= 	validate_picture($data['picture']);
	$data['track'] 		=	$json->track->name;
	$data['artist']	 	=	$json->track->artist->name;
	$data['mbid'] 		=	$json->track->mbid;
	$data['info'] 		=	$json->track->wiki->content;
	
	if(count($json->track->toptags->tag) == 1)
	{
		$data['tags'][] = $json->track->toptags->tag->name;
	}
	else
	{
		foreach ($json->track->toptags->tag as $key => $value) {
			$data['tags'][] = $value->name;
		}	
	}
	//$data['lyric'] 		= utf8_decode(get_lyric($artist,$track));
	//$data['similar'] 	= _similar_tracks($artist,$track);
	return $data;
}

function _lyric($artist,$track)
{
	$CI     =& get_instance();  
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.getInfo&api_key=".$CI->config->item("lastfm_apikey")."&artist=$artist&track=$track&format=json&autocorrect=1";
	
	$json 	= json_decode(prepare(_curl($url)));	

	if($json->error)
	{
		$data['error'] = $json->message;
		$data['query']['artist'] = urldecode($artist);
		$data['query']['track'] = urldecode($track);
	}
	for($x=0;$x<=4;$x++)
	{
		if($json->track->album->image[$x]->text != '')
		{
			$data['picture'] 	=	$json->track->album->image[$x]->text ;
		}
	}		
	$data['picture'] 	= 	validate_picture($data['picture']);
	$data['track'] 		=	$json->track->name;
	$data['artist']	 	=	$json->track->artist->name;
	$data['mbid'] 		=	$json->track->mbid;
	$data['info'] 		=	$json->track->wiki->content;
	
	if(count($json->track->toptags->tag) == 1)
	{
		$data['tags'][] = $json->track->toptags->tag->name;
	}
	else
	{
		foreach ($json->track->toptags->tag as $key => $value) {
			$data['tags'][] = $value->name;
		}	
	}
	$data['lyric'] 		= utf8_decode(get_lyric($artist,$track));	
	
	return $data;
}


function _artist($artist)
{
	$CI     =& get_instance(); 	
	$url ="http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=$artist&api_key=".$CI->config->item("lastfm_apikey")."&format=json";		
	$json 	= json_decode(prepare(_curl($url)));	

	if($json->error)
	{
		$data['error'] = $json->message;
		//show_error($json->message,500);
	}

	for($x=0;$x<=4;$x++)
	{
		if($json->artist->image[$x]->text != '')
		{
			$data['picture'] 	=	$json->artist->image[$x]->text ;
		}
	}			
	$data['picture'] 	= 	validate_picture($data['picture']);
	$data['artist']	 	=	$json->artist->name;
	$data['mbid'] 		=	$json->artist->mbid;
	$data['info'] 		=	$json->artist->bio->summary;
	
	if(count($json->artist->tags->tag) == 1)
	{
		$data['tags'][] = $json->track->toptags->tag->name;
	}
	else
	{
		foreach ($json->artist->tags->tag as $key => $value) {
			$data['tags'][] = $value->name;
		}	
	}
	
	foreach ($json->artist->similar->artist as $key => $value) {
		for($x=0;$x<=4;$x++)
		{
			if($value->image[$x]->text != '')
			{
				$picture 	=	$value->image[$x]->text ;
			}
		}
		if($value->name != '')
			$data['similar'][] = array("name" => $value->name,"picture" => $picture);
	}
		$data['toptracks'] = _top_tracks ($artist);
	return $data;

}

function _top_tracks($artist)
{
	$CI     =& get_instance(); 
	$url ="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm_apikey")."&format=json";
	$json 	= json_decode(prepare(_curl($url)));	

	if($json->error)
	{
		$data['error'] = $json->message;
	}
	foreach ($json->toptracks->track as $key => $value) {
		$track['name'] 		= $value->name;
		$track['mbid'] 		= $value->mbid;
		$track['artist'] 	= $value->artist->name;
		for($x=0;$x<=4;$x++)
		{
			if($value->image[$x]->text != '')
			{
				$track['picture']  	=	$value->image[$x]->text ;
			}
		}
		$track['picture'] 	= 	validate_picture($track['picture']);
		$data[] = $track;
	}
	return $data;

}

function _similar_tracks($artist,$track)
{
	$CI     =& get_instance(); 	
	$url 	="http://ws.audioscrobbler.com/2.0/?method=track.getsimilar&artist=$artist&track=$track&api_key=".$CI->config->item("lastfm_apikey")."&format=json";
	$json 	= json_decode(prepare(_curl($url)));	

	if($json->error)
	{
		$data['error'] = $json->message;
	}

	foreach ($json->similartracks->track as $key => $value) {
		if($key <=50){
			for($x=0;$x<=4;$x++)
			{
				if($value->image[$x]->text != '')
				{
					$picture 	=	$value->image[$x]->text ;
				}
			}
			$data[] = array("name" => $value->name,"artist" => $value->artist->name,"picture" => $picture);
		}
	}

	return $data;

	
}

function _search_artist($query)
{
	$CI     =& get_instance(); 	
	$url ="http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=$query&api_key=".$CI->config->item("lastfm_apikey")."&format=json";
	$json 	= json_decode(prepare(_curl($url)));	
	$data 	= array();
	if($json->error)
	{
		$data['error'] = $json->message;
	}
	
	foreach ($json->results->artistmatches->artist as $key => $value) {
		$data_t = array();
		$data_t['name'] 			= $value->name;
		$data_t['mbid'] 			= $value->mbid;
		$data_t['picture_small'] 	= $value->image[0]->text;
		$data_t['picture_medium']	= $value->image[2]->text;
		foreach ($value->image as $key2 => $value2) {
			$data_t['picture_extra'] = $value2->text;
		}
		$data[] = $data_t;
	}
	return $data;
}

function _search_album($query)
{
	$CI     =& get_instance(); 	

	$url ="http://ws.audioscrobbler.com/2.0/?method=album.search&album=$query&api_key=".$CI->config->item("lastfm_apikey")."&format=json";
	$json 	= json_decode(prepare(_curl($url)));	
	$data 	= array();
	if($json->error)
	{
		$data['error'] = $json->message;
	}

	
	
	foreach ($json->results->albummatches->album as $key => $value) {
		$data_t = array();
		$data_t['name'] 			= $value->name;
		$data_t['artist'] 			= $value->artist;
		$data_t['mbid'] 			= $value->mbid;
		$data_t['picture_small'] 	= $value->image[0]->text;
		$data_t['picture_medium']	= $value->image[2]->text;
		foreach ($value->image as $key2 => $value2) {
			$data_t['picture_extra'] = $value2->text;
		}
		$data[] = $data_t;
	}
	return $data;
}
function _search_track($query)
{
	$CI     =& get_instance(); 	
	
	$url ="http://ws.audioscrobbler.com/2.0/?method=track.search&track=$query&api_key=".$CI->config->item("lastfm_apikey")."&format=json&limit=100";
	$json 	= json_decode(prepare(_curl($url)));	
	$data 	= array();
	if($json->error)
	{
		$data['error'] = $json->message;
	}

	
	foreach ($json->results->trackmatches->track as $key => $value) {
		$data_t = array();
		$data_t['name'] 			= $value->name;
		$data_t['artist'] 			= $value->artist;
		$data_t['mbid'] 			= $value->mbid;
		$data_t['picture_small'] 	= $value->image[0]->text;
		$data_t['picture_medium']	= $value->image[2]->text;
		foreach ($value->image as $key2 => $value2) {
			$data_t['picture_extra'] = $value2->text;
		}
		$data[] = $data_t;
	}
	return $data;
}
?>