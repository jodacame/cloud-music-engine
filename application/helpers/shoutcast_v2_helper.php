<?php
function get_tracklist($datastation)
{
	$url 	= explode(";", $datastation['url']);		
	$url_ok = trim($url[0])."played.html";
	$header = get_header_curl($url_ok);

	if(strpos($header, "html") !== false)
	{
		$html 	= _curl($url_ok);		
		$DOM = new DOMDocument;
			$DOM->loadHTML($html);
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
			

		$idstation 			= $datastation['idstation'];
		
		

		foreach ($el as $key => $value) {
			if(is_numeric($key))
			{
				$temp = explode("-", $value);
				$artist = rtrim(ltrim($temp[0]));
				$track = rtrim(ltrim($temp[1]));
				$json[] = array("idstation" => $idstation,"artist" => $artist,"track" => $track);	
			}
			
		}
	}
		
	return $json;
}

  function getMp3StreamTitle($steam_url)
    {
    	set_time_limit(2);
    	if(function_exists('get_headers'))
    	{
    		ini_set('default_socket_timeout', 3);
	    	$data = get_headers($steam_url);
	        foreach ($data as $header){        	
	        	if (strpos(strtolower($header), 'icy-description:') !== false)
	        		$result['description'] = str_ireplace("icy-description:", "", $header);
	        	if (strpos(strtolower($header), 'icy-name:') !== false)
	        		$result['name'] = str_ireplace("icy-name:", "", $header);
	        	if (strpos(strtolower($header), 'icy-genre:') !== false)
	        		$result['genre'] = str_ireplace("icy-genre:", "", $header);


	        }

	    }
	    return $result;
    }