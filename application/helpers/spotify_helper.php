<?php
function _track($artist,$track)
{
	return false;
}



function _search_artist($query)
{
	$query = urlencode($query);
	if(strtolower(urldecode($query)) == 'various artists')
		return false;
	$CI     =& get_instance(); 
	$url		= "https://api.spotify.com/v1/search?q=$query&type=artist";
	$data 		= json_decode(_curl($url));
	
	// Save all artist
	foreach ($data->artists->items as $key => $value) 
	{
		$slug 						= str_ireplace("/", "-", $value->name);
		$value->name				= str_ireplace("/", "-", $value->name);
		$artist['id']				= $value->id;
		$artist['artist']			= $value->name;
		$artist['slug']				= $slug;
		$artist['genre_1']			= $value->genres[0];
		$artist['genre_2']			= $value->genres[1];
		$artist['picture_small']	= $value->images[2]->url;
		$artist['picture_medium']	= $value->images[1]->url;
		$artist['picture_extra']	= $value->images[0]->url;		
		$save[] = $artist;
	}
	$CI->Admin->setTable('artist',$save,true); 
}

function _search_track($query)
{
	$query = urlencode($query);
	if(strtolower(urldecode($query)) == 'various artists')
		return false;
	$CI     =& get_instance(); 
	$url		= "https://api.spotify.com/v1/search?q=$query&type=track";
	$data 		= json_decode(_curl($url));
	
	
	foreach ($data->tracks->items as $key => $value) 
	{
		$slug 						= str_ireplace("/", "-", $value->name);
		$value->name				= str_ireplace("/", "-", $value->name);
		$value->artists[0]->name	= str_ireplace("/", "-", $value->artists[0]->name);
		$tracks[] 	= array('artist' 		=> $value->artists[0]->name,
						'picture_small' 	=> $value->album->images[2]->url,
						'picture_medium' 	=> $value->album->images[1]->url,
						'picture_extra' 	=> $value->album->images[0]->url,
						'track' 			=> $value->name,
						'popularity' 		=> $value->popularity,
						'album' 			=> $value->album->name,
						'id' 				=> $value->id,
						'track_number' 		=> $value->track_number,
						'duration' 			=> $value->duration_ms
		);	
		$save = $tracks;
	}	
	$CI->Admin->setTable('tracks',$save,true); 
}

function _search_album($artist,$album_name,$insert = false)
{
	$query = $artist." ".$album_name;
	$CI         				=& get_instance(); 
	$url 						= "https://api.spotify.com/v1/search?q=".urlencode($query)."&type=album&limit=2";	
	$data 						= json_decode(_curl($url));	
	
	if(count($data->albums->items) == 0)
	{
		$query = $album_name;
		$url 						= "https://api.spotify.com/v1/search?q=".urlencode($query)."&type=album&limit=2";
		$data 						= json_decode(_curl($url));	
	}

	foreach ($data->albums->items as $key => $value) {
		$album = _album_by_id($value->id);		
		
		if($insert)
		{		

		    $CI->Admin->setTableIgnore('albums',$album['album']); 		    
		    $CI->Admin->setTable('tracks',$album['tracks'],true);   
		}
		$albums[] = $album;
	}

	
	return $albums;

}
function _artist_by_id($id)
{
	$url 						= "https://api.spotify.com/v1/artists/".$id;
	$data 						= json_decode(_curl($url));	
	$slug 						= str_ireplace("/", "-", $data->name);
	$data->name					= str_ireplace("/", "-", $data->name);
	$return['id']				= $data->id;
	$return['artist']			= $data->name;
	$return['slug']				= $slug;
	$return['genre_1']			= $data->genres[0];
	$return['genre_2']			= $data->genres[1];
	$return['picture_small']	= $data->images[2]->url;
	$return['picture_medium']	= $data->images[1]->url;
	$return['picture_extra']	= $data->images[0]->url;
	return $return;
}
function _track_by_id($id,$raw = false)
{
	$url 						= "https://api.spotify.com/v1/tracks/".$id;
	$data 						= json_decode(_curl($url));	
	$slug 						= str_ireplace("/", "-", $data->name);
	$data->name					= str_ireplace("/", "-", $data->name);
	$return['id']				= $data->id;
	$return['artist']			= $data->artists[0]->name;		
	$return['album']			= $data->album->name;	
	$return['picture_small']	= $data->album->images[2]->url;
	$return['picture_medium']	= $data->album->images[1]->url;
	$return['picture_extra']	= $data->album->images[0]->url;
	$return['track']			= $data->name;
	$return['track_number']		= $data->track_number;
	$return['duration']			= $data->duration_ms;
	$return['popularity']		= $data->popularity;	
	if($raw)
		return $data;
	return $return;
}

function _album_by_id($id)
{
	// Remove album
	$CI         				=& get_instance(); 
	$CI->Admin->deleteTable('albums',array("id" => $id,"crawled" => '0'));   	    
	
	$url 						= "https://api.spotify.com/v1/albums/".$id;	
	$data 						= json_decode(_curl($url));	
	$slug 						= str_ireplace("/", "-", $data->name);
	$data->name					= str_ireplace("/", "-", $data->name);
	$data->artists[0]->name		= str_ireplace("/", "-",$data->artists[0]->name);
	$return['id']				= $data->id;
	$return['album']			= $data->name;		
	$return['artist']			= $data->artists[0]->name;		
	$return['lenght']			= count($data->tracks->items);		
	$return['release_date']		= $data->release_date;		
	$return['picture_small']	= $data->images[2]->url;
	$return['picture_medium']	= $data->images[1]->url;
	$return['picture_extra']	= $data->images[0]->url;	
	$return['album_type']		= $data->album_type;
	$return['crawled']			= '1';
	$json['album'] 				= $return;
	foreach ($data->tracks->items as $key => $value) {
		$tracks[] 	= array('artist' 		=> $return['artist'],
						'picture_small' 	=> $return['picture_small'],
						'picture_medium' 	=> $return['picture_medium'],
						'picture_extra' 	=> $return['picture_extra'],
						'track' 			=> $value->name,
						'popularity' 		=> 0,
						'album' 			=> $return['album'],
						'id' 				=> $value->id,
						'track_number' 		=> $value->track_number,
						'duration' 			=> $value->duration_ms
		);
	}
	$json['tracks'] 				= $tracks;

	return $json;
}
function _all_artist_by_id($artist_id)
{
	$url 		= "https://api.spotify.com/v1/artists/".$artist_id;
	$data 		= json_decode(_curl($url));		
	$slug 						= str_ireplace("/", "-", $data->name);
	$data->name					= str_ireplace("/", "-", $data->name);
	$return['id']				= $data->id;
	$return['artist']			= $data->name;
	$return['slug']				= $slug;
	$return['genre_1']			= $data->genres[0];
	$return['genre_2']			= $data->genres[1];
	$return['picture_small']	= $data->images[2]->url;
	$return['picture_medium']	= $data->images[1]->url;
	$return['picture_extra']	= $data->images[0]->url;			

	// ALBUMS	
	 
	$url 						= "https://api.spotify.com/v1/artists/".$artist_id."/albums?album_type=single,album,compilation&offset=0&limit=50";
	$data 						= json_decode(_curl($url));		
	$unique = array();
	foreach ($data->items as $key => $value) {		
		$slug 						= str_ireplace("/", "-", $value->name);
		$value->name				= rtrim(ltrim(str_ireplace("/", "-", $value->name)));		
		$album 						= array();
		$album['id']				= $value->id;
		$album['album']				= $value->name;		
		$album['artist']			= $return['artist'];		
		$album['lenght']			= 0;
		$album['release_date']		= '';		
		$album['picture_small']		= $value->images[2]->url;
		$album['picture_medium']	= $value->images[1]->url;
		$album['picture_extra']		= $value->images[0]->url;	
		$album['album_type']		= $value->album_type;
		if(!$unique[sha1(mb_strtolower($value->name,"UTF-8"))])
			$albums[] = $album;
		$unique[sha1(mb_strtolower($value->name,"UTF-8"))] =$value->name;
	}	

	if(count($data->items)>=50)
	{
		$url 						= "https://api.spotify.com/v1/artists/".$artist_id."/albums?album_type=single,album,compilation&offset=50&limit=50";
		$data 						= json_decode(_curl($url));		
			foreach ($data->items as $key => $value) {		
			$slug 						= str_ireplace("/", "-", $value->name);
			$value->name				= rtrim(ltrim(str_ireplace("/", "-", $value->name)));		
			$album 						= array();
			$album['id']				= $value->id;
			$album['album']				= $value->name;		
			$album['artist']			= $return['artist'];		
			$album['lenght']			= 0;
			$album['release_date']		= '';		
			$album['picture_small']		= $value->images[2]->url;
			$album['picture_medium']	= $value->images[1]->url;
			$album['picture_extra']		= $value->images[0]->url;	
			$album['album_type']		= $value->album_type;
			if(!$unique[sha1(mb_strtolower($value->name,"UTF-8"))])
				$albums[] = $album;
			$unique[sha1(mb_strtolower($value->name,"UTF-8"))] =$value->name;
		}
	}

	$unique = array();
	$return['albums'] = $albums;
	$return['tracks'] = _top_tracks($return['id']);
	return $return;
}
function _artist2($query)
{
	$url		= "https://api.spotify.com/v1/search?q=$query&type=artist";
	$data 		= json_decode(_curl($url));

	$artist_id 	= $data->artists->items[0]->id;
	$url 		= "https://api.spotify.com/v1/artists/".$artist_id;
	$data 		= json_decode(_curl($url));	

	//$return['spotify_id']		= $data->id;
	$slug 						= str_ireplace("/", "-", $data->name);
	$data->name					= str_ireplace("/", "-", $data->name);
	$return['id']				= $data->id;
	$return['artist']			= $data->name;
	$return['slug']				= $slug;
	$return['genre_1']			= $data->genres[0];
	$return['genre_2']			= $data->genres[1];
	$return['picture_small']	= $data->images[2]->url;
	$return['picture_medium']	= $data->images[1]->url;
	$return['picture_extra']	= $data->images[0]->url;			

	// ALBUMS	
	$url 						= "https://api.spotify.com/v1/artists/".$artist_id."/albums?album_type=album,single,compilation,appears_on";
	$data 						= json_decode(_curl($url));		

	
	$temp_id_album 				= array();
	foreach ($data->items as $key => $value) {
		$temp_id_album[] = $value->id;
	}

	if($data->next)
	{
		while($data->next != '')
		{		

			$data = json_decode(_curl($data->next));	
			foreach ($data->items as $key => $value) {				
				$temp_id_album[] = $value->id;
			}	

		}
	}

	$album_array = array_chunk($temp_id_album,20);

	$unique = array();
	
	foreach ($album_array as $key_albums => $value_albums) 
	{		
	
		$url 						= "https://api.spotify.com/v1/albums?ids=".implode(",",$value_albums);
		
		$data 						= json_decode(_curl($url));	
		$unique_track = array();
		foreach ($data->albums as $key => $value) 
		{
			
			$playing_time = 0;			
			foreach ($value->tracks->items as $key2 => $value2) 
			{
				if(!$unique_track[sha1($return['artist'].$value2->name.$value->name)])
				{
					$return['artist'] 	= str_ireplace("/", "-", $return['artist']);
					$value2->name 		=  str_ireplace("/", "-", $value2->name);
					$value2->name 		=  str_ireplace('"', "", $value2->name);

					$tracks[] 	= array('artist' 			=> $return['artist'],
									'picture_small' 	=> $value->images[2]->url,
									'picture_medium' 	=> $value->images[1]->url,
									'picture_extra' 	=> $value->images[0]->url,
									'track' 				=> $value2->name,
									'popularity' 				=> $value2->popularity,
									'album' 			=> $value->name,
									'id' 			=> $value->id,
									'track_number' 		=> $value2->track_number,
									'duration' 			=> $value2->duration_ms
					);
					$playing_time = $playing_time + $value2->duration_ms;
					$unique_track[sha1( $return['artist'].$value2->name.$value->name)] = true;
				}
			}
			
			if(!$unique[sha1($value->name)])
			{
				$unique[sha1($value->name)] = true;	
				$albums[] = array("album" => $value->name,
								'picture_small' 	=> $value->images[2]->url,
								'picture_medium' 	=> $value->images[1]->url,
								'picture_extra' 	=> $value->images[0]->url,
								'release_date' 		=> $value->release_date,							
								'lenght' 			=> count($value->tracks->items),
								'artist' 			=> $return['artist'],
								'playing_time ' 	=> $playing_time
				);

			}

			
		}
	}
	
	$return['albums'] = $albums;
	$return['tracks'] = $tracks;
	return $return;
}

function _related_artist($id)
{
	$CI     =& get_instance(); 
	$url ="https://api.spotify.com/v1/artists/$id/related-artists";
	$data 	= json_decode(_curl($url));
	$return = array();
	foreach ($data->artists as $key => $value) {
		$value->name 		=  str_ireplace("/", "-", $value->name);
			$value->name 		=  str_ireplace('"', "", $value->name);	
			
		$return[] = array(	"artist" 				=> $value->name,
							"slug" 					=> $value->name,														
							"id" 					=> $value->id,														
							"genre_1"				=> $value->genres[0],
							"genre_2"				=> $value->genres[1],							
							'picture_small'			=> $value->images[2]->url,
							'picture_medium'		=> $value->images[1]->url,
							'picture_extra'			=> $value->images[0]->url	
							);
	}
	return $return;
}
function _top_tracks($id)
{
	$CI     =& get_instance(); 
	$url 	= "https://api.spotify.com/v1/artists/$id/top-tracks?country=US";
	$data 	= json_decode(_curl($url));
	$x=0;
	foreach ($data->tracks as $key => $value) {
			$value->name 						=  str_ireplace("/", "-", $value->name);
			$value->artists[0]->name 			=  str_ireplace("/", "-", $value->artists[0]->name);
			$value->name 						=  str_ireplace('"', "", $value->name);					
			$save = array("id" 				=> $value->id,
							"track" 			=> $value->name,
							"popularity" 		=> $value->popularity,
							"album" 			=> $value->album->name,							
							"artist" 			=> $value->artists[0]->name,
							"duration" 			=> $value->duration_ms,
							"picture_small" 	=> $value->album->images[2]->url,
							"picture_medium" 	=> $value->album->images[1]->url,
							"picture_extra" 	=> $value->album->images[0]->url,
					);	
			$tracks[] = $save;						
			
	}
	return $tracks;
}
function get_album_by_id(){
	
}
function _search_all($query,$insert = true)
{
	$query 	= urlencode($query);
	$CI     =& get_instance(); 
	$url	= "https://api.spotify.com/v1/search?q=$query&type=artist,track,album&limit=50";
	$data 	= json_decode(_curl($url));


	

	// TRACKS
	$unique	= array();
	foreach ($data->tracks->items as $key => $value) 
	{

		$artists = array();
		foreach ($value->artists as $artist) {

			$artists[] = array("name" => $artist->name);
		}
		
		if(!$unique[sha1($value->name.$artists[0]['name'])])
		{
			
			$value->name 		=  str_ireplace("/", "-", $value->name);
		//	$value->name 		=  str_ireplace('"', "", $value->name);	
			
			$artists[0]['name']= str_ireplace("/", "-", $artists[0]['name']);
			$unique[sha1($value->name.$artists[0]['name'])] = true;
			$save = array("source" 			=> 'spotify',
							
							"idmusixmatch" 				=> $value->id,
							"track" 			=> $value->name,
							"popularity" 		=> $value->popularity,
							"album" 			=> $value->album->name,
							
							"artist" 			=> $artists[0]['name'],
							"duration" 			=> $value->duration_ms,
							"picture_small" 	=> $value->album->images[2]->url,
							"picture_medium" 	=> $value->album->images[1]->url,
							"picture_extra" 	=> $value->album->images[0]->url,
					);	
			$tracks[] = $save;
			unset($save['artists']);
			unset($save['source']);
			unset($save['source']);
			$save['artist'] = str_ireplace("/", "-", $save['artist']);
			if($insert)
				$CI->Admin->setTableIgnore('tracks',$save); 

		}

					
	}
	if($tracks)
	{		
		$return['tracks'] = $tracks;
	}

	// ARTIST
	

	$artists = null;
	foreach ($data->artists->items as $key => $value) 
	{

		$value->name= str_ireplace("/", "-", $value->name);
			$save = array();
			$save = array("source" 			=> 'spotify',
						"idmusixmatch" 				=> $value->id,
						"artist" 				=> $value->name,
						"artists" 			=> $artists,
						"genres" 			=> $value->genres,
						"picture_small" 	=> $value->images[2]->url,
						"picture_medium" 	=> $value->images[1]->url,
						"picture_extra" 	=> $value->images[0]->url,
					);
		$artists[] = $save;
		unset($save['source']);
		unset($save['artists']);
		$save['artist'] = str_ireplace("/", "-", $save['artist']);
		$save['genre_1'] = (String)$save['genres'][0];
		$save['genre_2'] = (String)$save['genres'][1];
	
		unset($save['genres']);
		if($insert)
			$CI->Admin->setTableIgnore('artist',$save); 
		
	}
	if($artists)
		$return['artists'] = $artists;

	
	
	// ALBUMS
	$unique	= array();

	/*foreach ($data->albums->items as $key => $value) 
	{
		
		
		if($value->album_type == 'album')
		{		

			$albums[] = array("source" 			=> 'spotify',
						"id" 				=> $value->id,
						"album" 				=> $value->name,
						"artists" 			=> $artists,
						"artist" 			=> $artists[0]['artist'],
						"picture_small" 	=> $value->images[2]->url,
						"picture_medium" 	=> $value->images[1]->url,
						"picture_extra" 	=> $value->images[0]->url,
					);
		}
		
	}*/

	foreach ($data->tracks->items as $key => $value) 
	{

		$artists = array();
		foreach ($value->artists as $artist) {

			$artists[] = array("name" => $artist->name);
		}
		if(!$unique[sha1($value->album->name.$artists[0]['name'])])
		{
			$artists[0]['name']= str_ireplace("/", "-", $artists[0]['name']);
			$unique[sha1($value->album->name.$artists[0]['name'])] = true;
			$save = array("source" 			=> 'spotify',
						
						"idmusixmatch" 				=> $value->album->id,
						"album" 				=> $value->album->name,
						"artists" 			=> $artists,
						"artist" 			=> $artists[0]['name'],
						"picture_small" 	=> $value->album->images[2]->url,
						"picture_medium" 	=> $value->album->images[1]->url,
						"picture_extra" 	=> $value->album->images[0]->url,
					);
		}
		$albums[] = $save;
		unset($save['source']);
		unset($save['artists']);
		$save['artist'] = str_ireplace("/", "-", $save['artist']);
		if($insert)
			$CI->Admin->setTableIgnore('albums',$save); 
	}
	if($albums)
		$return['albums'] = $albums;

	return $return;
}

	
