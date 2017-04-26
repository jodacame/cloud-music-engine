<?php
function get_tracklist($data)
{
	$CI     			=& get_instance();  
	$api 				= $CI->config->item("radionomy_apikey");
	$idstation 			= $data['idstation'];
	$radiouid 			= $data['guid'];
	$data				= _curl("https://api.radionomy.com/tracklist.cfm?radiouid=$radiouid&apikey=$api&amount=50&type=xml&cover=YES");	
	$xml 				= simplexml_load_string($data);		
	
	foreach ($xml->track as $key => $value) {
		str_ireplace("http://", "https://",$value->cover);
		$json[] = array("idstation" => $idstation,"artist" => $value->artists,"track" => $value->title,"image" => $value->cover);
	}
	if(count($json) == 0)
	{
		$temp = get_current_track($radiouid);		
		$temp['idstation'] = $idstation;
		unset($temp['callmeback']);
		$json[] = $temp;
	}
	
	return $json;
}

function get_current_track($guid)
{
	$CI     			=& get_instance();  
	$apikey 				= $CI->config->item("radionomy_apikey");
	$data 					= _curl("http://api.radionomy.com/currentsong.cfm?radiouid=$guid&apikey=$apikey&callmeback=yes&type=xml");		
	$data 					= simplexml_load_string($data);		
	$json['artist'] 		= (String)$data->track->artists;
	$json['track'] 			= (String)$data->track->title;
	$json['image'] 			= (String)$data->track->cover;
	$json['callmeback'] 	= intval((String)$data->track->callmeback)+3000;
	return $json;
}