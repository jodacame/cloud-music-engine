<?php
function get_tracklist($datastation)
{
		$idstation 			= $datastation['idstation'];
		$url 	= explode("/", $datastation['url']);			
		$data = get_current_song($datastation['url'],$datastation['mount']);
		$json[0]['idstation'] 		= $idstation;
		$json[0]['artist'] 			= $data['artist'];
		$json[0]['track'] 			= $data['track'];
		if($json[0]['artist'] == '')
			$json[0]['artist'] = $datastation['title'];
		if($json[0]['track'] == '')
			$json[0]['track'] = $datastation['genre'];
	
	return $json;
}

function get_current_song($url,$mount)
{

				
		
		$data 	= _curl($url_ok);
		$json_t 	= json_decode($data);
		
		
		$temp 		= explode(" - ", $json_t->icestats->source->title);		

		
		$artist 	= (String)$temp[0];
		if($temp[1] != '')
		{
			if(is_array($temp[1]))
				$track 		= implode(" ", $temp[1]);
			else
				$track = $temp[1];
		}
		else
			$track 		= $json_t->icestats->source->genre;

		if($json_t->icestats->source->artist)
		{
			$artist = $json_t->icestats->source->artist;
			$track 	= $json_t->icestats->source->title;
		}
		$json['artist'] 		= $artist;
		$json['track'] 			= $track;
		$json['callmeback'] 	= '150000';	
		

		if($json['artist'] !='')	
		{
			
			return $json;
		}

		// HTML DOC 
		$url_ok = $url."/status.xsl?mount=$mount";		

		$data 	= _curl($url_ok);	
		if(preg_match_all('/<td\s[^>]*class=\"streamdata\">(.*)<\/td>/isU', $data, $match)){
			$stream['info']['status'] = 'ON AIR';
			$stream['info']['title'] = $match[1][0]; 
			$stream['info']['description'] = $match[1][1]; 
			$stream['info']['type'] = $match[1][2]; 
			$stream['info']['start'] = $match[1][3]; 
			//$stream['info']['bitrate'] = $match[1][4]; 
			$stream['info']['listeners'] = $match[1][4]; 
			$stream['info']['msx_listeners'] = $match[1][5]; 
			$stream['info']['genre'] = $match[1][7]; 
			$stream['info']['stream_url'] = $match[1][8];
			$stream['info']['artist_song'] =strip_tags($match[1][9]);
				$x = explode(" - ",$match[1][9]); 
			$stream['info']['artist'] = $x[0]; 
			$stream['info']['song'] = $x[1];
		}
		else{
			$stream['info']['status'] = 'OFF AIR';
		}
		
		$json['artist'] = $stream['info']['artist'];		
		$json['track'] = $stream['info']['song'];

		if($json['artist'] !='')	
		{
			$json['callmeback'] 	= '150000';	
			return $json;
		}

		// HTML DOC
				
		$url_ok = $url."/status.xsl?mount=$mount";		




		$data 	= _curl($url_ok);		
		


		$DOM = new DOMDocument;
		$DOM->loadHTML($data);
		$data = '';
		$items = $DOM->getElementsByTagName('tr');
		    foreach ($items as $node) {
		        $data .= tdrows($node->childNodes) . "<br>";
		    }

		    $arr = explode("<br>", $data);
		    foreach ($arr as $key => $value) {
		    	$tmp = explode("||||", $value);
		    	$tmp[0] = str_ireplace(":","", $tmp[0]);
		    	$tmp[0] = rtrim($tmp[0]);
		    	$tmp[0] = ltrim($tmp[0]);
		    	$el[$tmp[0]] = $tmp[1];
		    }	
		    
		$song 					= explode(" - ",$el['Current Song']);
		$json['artist'] 		= (String)$song[0];
		$json['track'] 			= (String)$song[1].$song[2];
		$json['callmeback'] 	= '150000';

/*
		$data = getMp3StreamTitle($url.$mount,19200);
		$temp = explode("~",$data);

		$json['artist'] = $temp[0];
		$json['track'] 	= $temp[1];*/

		if(trim($json['artist']) == '')
			$json['artist'] = __("lanel_no_available");
		if(trim($json['track']) == '')
			$json['track'] = __("lanel_no_available");

		return $json;
}

/* Please be aware. This gist requires at least PHP 5.4 to run correctly.
 * Otherwise consider downgrading the $opts array code to the classic "array" syntax.
*/
function getMp3StreamTitle($streamingUrl, $interval, $offset = 0, $headers = true)
	{
		$needle = 'StreamTitle=';
		$ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36';
		$opts = [
			'http' => [
				'method' => 'GET',
				'header' => 'Icy-MetaData: 1',
				'user_agent' => $ua
			]
		];
		if (($headers = get_headers($streamingUrl)))
			foreach ($headers as $h)
				if (strpos(strtolower($h), 'icy-metaint') !== false && ($interval = explode(':', $h)[1]))
					break;
		$context = stream_context_create($opts);
		if ($stream = fopen($streamingUrl, 'r', false, $context))
		{
			while($buffer = stream_get_contents($stream, $interval, $offset)) {
				if (strpos($buffer, $needle) !== false)
				{
					fclose($stream);
					$title = explode($needle, $buffer)[1];
					return substr($title, 1, strpos($title, ';') - 2);
				}
				
				$offset += $interval;
			}
		}
	}
