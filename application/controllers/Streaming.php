<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Streaming extends MY_Controller {

	public function index()
	{
		
		$type = (String)$this->input->get("type");		
		if($type == 'station')
		{
			$this->station($this->input->get("stationID"));
			return false;
		}
		$artist = ltrim(urldecode($this->input->get("artist")));
		$track 	= ltrim(urldecode($this->input->get("track")));
		$country_code 	= ltrim(urldecode($this->input->get("country_code")));
		
		// Fix some songs
		$temp = explode("-", $track);
		$track_temp = rtrim(ltrim($temp[0]));
		
		$services = explode(",",  $this->config->item("streaming_engine"));
		/*if($this->agent->is_mobile())
		{
			// Force mp3 for mobile divices									
			$services = array("soundcloud","vk");


		}*/

		// Local Search		
		$data 	= $this->Admin->getTable("tracks",array("artist" =>$artist,"track" => $track));
		$local 	= $data->row();
		if($local->streaming_url != '')
		{

			$json['source'] 	= 'cloud (Custom File)';
			$json['stream'] 	=$local->streaming_url;
			$this->output->set_content_type('application/json')->set_output(json_encode($json));			
			return;	
			
		}
		
		
		
		if(in_array("soundcloud", $services))
		{
			if($local->soundcloud_id > 0)
			{				
				$json['stream'] 	= 'https://api.soundcloud.com/tracks/'.$local->soundcloud_id.'/stream?client_id='.config_item('soundcloud_client_id');
				$json['source'] 	= 'Soundcloud (Custom Track)';					
				$this->output->set_content_type('application/json')->set_output(json_encode($json));			
				return false;
				
			}
			// Soundcloud
			$query = $artist." ".$track;
			$json['query']		= $query;		
			$url ="http://api.soundcloud.com/tracks.json?client_id=".config_item('soundcloud_client_id')."&q=".slug($query)."&limit=1&track_type=original&filter=public";
			$data = json_decode(_curl($url));
			if(count($data) > 0)
			{	
				$exclude = array("shoutcast","episode","season","vs",".com","remix","dj","ringtone","mix","ft","(",")","[","]");
				$json['source'] 	= 'soundcloud';

				foreach ($data as $key => $value) {		
					//print_p($value);
					foreach ($exclude as $key2 => $value2) {
						if(strpos(mb_strtolower($value->title,"UTF-8"), $value2) !== FALSE)
							$remix = true;
					}	

					similar_text(mb_strtolower(normalizer($query),"UTF-8"), mb_strtolower(normalizer($value->title),"UTF-8"), $percent);
				/*	print_p($value);
					echo "aaa".mb_strtolower(normalizer($query),"UTF-8")."<br>";
					echo "bbb".mb_strtolower(normalizer($value->title),"UTF-8")."<br>";
					die();*/
					if($value->track_type && $value->track_type != 'original' || $value->duration > 1000000)
						$novalid = true;
					if($remix || $novalid)
					{

						$percent = 0;
					}
					$json['percent']['full_title']		= $percent;	
					if($percent>85)
					{
						
						$continue = true;
					}
					else
					{

						if($percent>50)
						{
							similar_text(mb_strtolower($track,"UTF-8"), mb_strtolower($value->title,"UTF-8"), $percent);
							if($percent>20 && strpos(mb_strtolower($value->title,"UTF-8"), mb_strtolower($track,'UTF-8')) !== FALSE)
								$continue = true;

						}	
						$json['percent']['track']		= $percent;	
					}
					if(!$continue && $this->agent->is_mobile())
					{	
						
						$continue = true;
					}
					if($value->streamable && $continue)
					{	
						$json['original_title']	= $value->title;		
						$json['track_type']		= $value->track_type;							
						$json['stream'] 		= $value->stream_url.'?client_id='.config_item('soundcloud_client_id');
						break;
					}
				}
				if($json['stream'])
				{
					$this->output->set_content_type('application/json')->set_output(json_encode($json));			
					return;	
				}
				
			}
		}





		if(in_array("mp3skull", $services))
		{
			// Mp3Skull		
	 		$query = mb_strtolower(str_ireplace(" ", "_",$query));        
	        $output = _curl("https://mp3skull.yoga/mp3/$query.html");
			preg_match('/<div class=\"download_button\" onclick=\"(.*?)\">(.*)<\/div>/isU', $output, $match);
			$a = explode("</a>",$match[0]);
			preg_match('/<a href=\"(.*?)\" rel=\"nofollow\" target=\"_blank\">/isU', $a[0], $match2);
			preg_match('/<div class=\"mp3_title\">(.*)<\/div>/isU', $output, $match3);
			$json['original_title'] = strip_tags($match3[1]); 
			$json['stream'] = $match2[1]; 
			$json['url'] 	= "https://mp3skull.yoga/mp3/$query.html";
			$json['source'] = 'cloud';
			similar_text(mb_strtolower(normalizer($query),"UTF-8"), mb_strtolower(normalizer($json['original_title']),"UTF-8"), $percent);
			$json['percent']['full_title']		= $percent;	
			foreach ($exclude as $key2 => $value2) {
				if(strpos(mb_strtolower($json['original_title'],"UTF-8"), $value2) !== FALSE)
					$remix = true;
			}	
			if($json['stream'] && $percent> 50 && !$remix)
			{
				$this->output->set_content_type('application/json')->set_output(json_encode($json));			
				return;	
			}
		}


		// Local Search		
		$data 	= $this->Admin->getTable("tracks",array("artist" =>$artist,"track" => $track));
		$local 	= $data->row();

		if($local->streaming_url != '' && $this->config->item("streaming_engine") == 'external')
		{

			redirect($local->streaming_url);	
			exit;
		}
		if($local->youtube_id != '')
		{
			$code 	= $local->youtube_id;
		}
		/*else
		{
			// Search on Youtube				
			$artist_temp = str_ireplace("Various Artists","",$artist);
			if($artist_temp == '')
				 $artist_temp  = " song";
			$code 	= getYoutube($artist_temp,str_ireplace("(Album Version)", "", $track_temp));

			//$this->Admin->updateTable('tracks',array("youtube_id" => $code),array("artist" =>$artist,"track" => $track));
		}*/

		


		if(in_array("youtube", $services))
		{
			// Search on Youtube				
			$artist_temp = str_ireplace("Various Artists","",$artist);
			$code 	= getYoutube($artist_temp,str_ireplace("(Album Version)", "", $track_temp),$country_code);
			$json['source'] 	= 'youtube';
			$json['id'] 		= $code;
			$this->output->set_content_type('application/json')->set_output(json_encode($json));			
			return false;
		}

		// VK.com Streaming
		if(in_array("vk", $services))
		{
			// VK
			$data = $this->vk_audio($artist,$track);
			if($data)
			{
				$this->output->set_content_type('application/json')->set_output(json_encode($data));			
				return false;
			}	
		}


		if(in_array("fly", $services))
		{
		
			$downloaded = $this->try_download_mp3($code,$artist,$track);
			$this->process_download($downloaded);	
			$downloaded = $this->try_download_mp3_2($code,$artist,$track);
			$this->process_download($downloaded);		
			$downloaded = $this->try_download_mp3_3($code,$artist,$track);
			$this->process_download($downloaded);
			$downloaded = $this->try_download_mp3_4($code,$artist,$track);
			$this->process_download($downloaded);
		}

		
		$json['source'] 	= 'error';
		$json['stream'] 	= '';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));			


		/*
					
		if($code)
		{
			

			
				//$url = "http://cloud.andthemusic.net/lib/?code=".$code;
				$this->load->library('user_agent');
				//$format = 'worstaudio'; 
				$format = 'worst';
				if($this->agent->is_mobile())
					$format = '140';
				$string2 = './lib/youtube-dl --rm-cache-dir -q -s -j -f '.$format.' --no-check-certificate    --no-call-home --youtube-skip-dash-manifest --skip-download  https://www.youtube.com/watch?v='.$code;
				
				if($local->streaming_url != '')
				{
					$link = $local->streaming_url;		    				
				}
				else
				{
					$data = exec($string2, $result, $status);		    
				    $a 		= json_decode($data);
				    print_p($data);
				    $link = $a->url;
				    //$this->Admin->updateTable('tracks',array("streaming_url" => $link),array("artist" =>$artist,"track" => $track));		    				
				}
				if($link)
				{
					redirect($link);	
					exit;
				}
				else
				{					
					show_error("No Video Found!",404);
				}				
			
		}
		else
		{
			sleep(1);
			show_404();
			//redirect("http://listen.radionomy.com/abc-jazz");
		}*/
	}

	protected function station($id)
	{
		$station = $this->Admin->getTable("stations",array("idstation" => intval($id)));		
		$data = $station->row();	
		$json['source'] 	= 'station';
		$json['stream'] 	= $data->url.$data->mount;
		$this->output->set_content_type('application/json')->set_output(json_encode($json));			
		return;
	}
	public function get_info()
	{
		$id = intval($this->input->get("id"));		
		$station = $this->Admin->getTable("stations",array("idstation" => intval($id)));		
		$data = $station->row_array();
		unset($data['apikey']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));			
	}

	public function get_current()
	{
		/* TODO: Guardar cache de la solicitud (guardar el current en la tabla de la estacion) */
		$source = $this->input->post("type");

		switch ($source) {
			case 'radionomy':
				$this->get_current_radionomy();
				break;
			case 'shoutcast_v1':
				$this->get_current_shoutcast_v1();
				break;		
			case 'shoutcast_v2':
				$this->get_current_shoutcast_v2();
				break;	
			case 'icecast2':
				$this->get_current_icecast2();
				break;	

			default:
				# code...
				break;
		}
		
	}
	protected function get_current_radionomy()
	{
		$guid 					= $this->input->post("guid");
		$apikey 				= $this->config->item("radionomy_apikey");
		if($apikey)
		{
			$data 					= _curl("http://api.radionomy.com/currentsong.cfm?radiouid=$guid&apikey=$apikey&callmeback=yes&type=xml");		
			$data 					= simplexml_load_string($data);		
			$json['artist'] 		= (String)$data->track->artists;
			$json['track'] 			= (String)$data->track->title;
			$json['callmeback'] 	= intval((String)$data->track->callmeback)+3000;
		}
		else
		{
			$json['artist'] 		= 'Required API KEY Radionomy';
			$json['track'] 			= 'Required API KEY Radionomy';
			$json['callmeback'] 	= 3000000;	
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));			
	}
	protected function get_current_shoutcast_v1()
	{
		
		$url 	= explode(";", $this->input->post("url"));		

		

		$data 	= _curl($url[0]);		

	

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
		$json['callmeback'] 	= rand(80000,150000);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));					    
		
	}

	protected function get_current_shoutcast_v2()
	{
		
		$url 	= explode(";", $this->input->post("url"));		

		

		
		$header = get_header_curl($url[0]."stats");			
		if(strpos($header, "xml") !== false)
		{	
			$data 	= _curl($url[0]."stats");	
			$data 	= simplexml_load_string($data);
		
			$song 					= explode(" - ",(String)$data->SONGTITLE);

			$json['artist'] 		= (String)$song[0];
			$json['track'] 			= (String)$song[1].$song[2];
		}
		$json['callmeback'] 	= rand(80000,150000);
		if($json['artist'] == '')
		{
			$this->load->helper("shoutcast_v2");
			$data = getMp3StreamTitle($url[0]);
			if($data)
			{
				$json['track'] 			= $data['name'];
				$json['artist'] 		= $data['genre'];
				$json['callmeback'] 	= '35000';
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));					    
		
	}

	public function get_current_icecast2()
	{
			
		
		$this->load->helper("icecast2");
		$url 	= $this->input->post("url");		
		$mount 	= $this->input->post("mount");				
		$json 	= get_current_song($url,$mount);		
		$this->output->set_content_type('application/json')->set_output(json_encode($json));					    
		
	}
	protected function process_download($downloaded,$artist,$track)
	{
	
		if($downloaded)
		{
			$streaming_url = $downloaded['remote'];
			if($downloaded['local'])
			{
				$streaming_url = $downloaded['local'];
				$this->Admin->updateTable('tracks',array("streaming_url" => $downloaded['local']),array("artist" =>$artist,"track" => $track));
			}			
		}

		$json['source'] 	= 'link';
		$json['stream'] 	= $streaming_url;
		$this->output->set_content_type('application/json')->set_output(json_encode($json));			
		return;
		
	}
	protected function try_download_mp3($code,$artist,$track)
	{
				

		_curl("https://mp3skull.onl/api/youtube/frame/#/?id=".$code);					
		$ch = curl_init("http://serve01.mp3skull.onl/get?id=".$code);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 3); //timeout in seconds
		//curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE , 3000000); 

	    curl_exec($ch);	    
	    if(strpos(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), "audio") !== false)
	    {
	    	$url = $this->download_mp3("http://serve01.mp3skull.onl/get?id=".$code,$artist,$track,'1');
	    	//redirect("http://serve01.mp3skull.onl/get?id=".$code);
	    	return $url;	    		    	
	    }
	    return false;
		
	}
	protected function try_download_mp3_2($code,$artist,$track)
	{
		
		
		$json = json_decode(_curl("http://www.youtubeinmp3.com/fetch/?format=JSON&video=http://www.youtube.com/watch?v=$code"));
		if($json->link)
		{

			$header = get_header_curl($json->link); 			
			
		    if(strpos($header, "audio") !== false)
		    {
		    	return $json->link;
		    	//$url = $this->download_mp3($json->link,$artist,$track,'2');
		    	//redirect("http://serve01.mp3skull.onl/get?id=".$code);
		    	return $url;	    		    	
		    }
		    return false;
		}
	    return false;
		
	}

	protected function try_download_mp3_3($code,$artist='',$track='')
	{
		
		
		$json = _curl("http://www.theyoump3.com/a/pushItem/?item=https%3A//www.youtube.com/watch%3Fv%3D$code&el=na&bf=false&r=1");
		$json = (_curl("http://www.theyoump3.com/a/itemInfo/?video_id=$code&ac=www&t=grp&r=1"));
		$json = ("{".str_ireplace("info =", '"info":', $json)."}");
		$json = json_decode(str_ireplace("};", "}", $json));

		$download_link = "http://www.theyoump3.com/get?ab=128&video_id=$code&h=".$json->info->h."&r=1";
		
		
			
			$ch = curl_init($download_link); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
		    curl_exec($ch);	    
		    
		    if(strpos(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), "audio") !== false)
		    {
		    	$url = $this->download_mp3($download_link,$artist,$track,'3');
		    	//redirect("http://serve01.mp3skull.onl/get?id=".$code);
		    	return $url;	    		    	
		    }
		
	    return false;
		
	}

	
	protected function try_download_mp3_4($code,$artist='',$track='')
	{
		
			
			//www.videograbby.com
		
			$json = json_decode(_curl("http://158.69.116.56/api/audio_link/normal/mp3/1/".base64_encode("http://www.youtube.com/watch?v=".$code)));
			if($json->link)
			{
				$download_link = "http://158.69.116.56".$json->link;
				
				$ch = curl_init($download_link); 
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
			    curl_exec($ch);	    
			    //die(curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
			    if(strpos(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), "audio") !== false || strpos(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), "octet-stream") !== false)
			    {
			    	$url = $this->download_mp3($download_link,$artist,$track,'4');
			    	//redirect("http://serve01.mp3skull.onl/get?id=".$code);
			    	return $url;	    		    	
			    }
			}
		
	    return false;
		
	}


	protected function download_mp3($url,$artist,$track,$method = '0')
	{	
		$json['remote'] = $url;
		if($this->config->item("download_service") == '1' && 1==2)
		{


				

			$artist 	= _url_title($artist,true);
			$track 		= _url_title($track,true);
			if($artist == '')
				$artist  = sha1($url);
			if($track == '')
				$track  = sha1($url);

			$letter = substr($artist, 0,1);
			if($letter == '')
				$letter = substr(sha1($artist), 0,1);

			$letter = strtoupper($letter);

			$folder = $this->config->item('folder_mp3');
	    	// Try download MP3
	    	if(!file_exists("./".$folder))
	    		mkdir("./".$folder);
	    	if(!file_exists("./".$folder."/".$letter))
	    		mkdir("./".$folder."/".$letter);
	    	if(!file_exists("./".$folder."/".$letter."/".$artist))
	    		mkdir("./".$folder."/".$letter."/".$artist);

	    	$folder 		= "./".$folder."/".$letter."/".$artist."/";
	    	$file_name 		= $track."-".sha1($track.date("YmdHis")).$method.".mp3";
			$fp = fopen($folder.$file_name , 'w');
			$out = _curl($url);
			fwrite($fp, $out);
			fclose($fp);			
			$json['local']  = base_url().str_ireplace("./", "",$folder).$file_name;
		}
		return $json;
			
	}

	protected function vk_audio($artist,$track)
	{	
		
		$token = config_item('vk_token');
		if(!$token)
			return false;
		//$data =  json_decode(_url("https://api.vk.com/method/users.get?user_ids=$userid&fields=photo_big,nickname,screen_name,email&access_token=".$token));
		$query 	= urlencode($artist." ".$track);		
		$data 	=  json_decode(_curl("https://api.vk.com/method/audio.search?q=$query&access_token=$token&count=1&v=5.45",false,false,false,false,"./ffchainvk.crt"));

	
		
		if($data->response->items[0]->url)
		{

			//$header = get_header_curl($data->response->items[0]->url); 						
		    //if(strpos($header, "audio") !== false)
		    //{
				if(mb_strtolower($artist,"utf8") == mb_strtolower($data->response->items[0]->artist,"utf8") && mb_strtolower($track,"utf8") == mb_strtolower($data->response->items[0]->title,"utf8"))
				{
					//print_p($data);
					$json['vkid']		= $data->response->items[0]->owner_id."_".$data->response->items[0]->id;
					//$json['token']		= $token;
					$json['query']		= urldecode($query);
					$json['source'] 	= 'vk (Vk.com)';
					$json['stream'] 	= base_url()."streaming/vk?token=".base64_encode(urlencode($data->response->items[0]->url));			
					//$json['stream'] 	= $data->response->items[0]->url;			
					//$json['stream'] 	= str_ireplace("http://", "//", $json['stream']);

					return $json;	
				}
			//}
		}
		return false;
	}

	

	public function vk()
	{
		$url = urldecode(base64_decode($this->input->get("token")));
		
		header('Content-Type: octet-stream');
	    header('Content-Disposition: filename="vk.mp3"');	  
	    $audio=  _curl($url);
	    header('Content-length: '.strlen($audio));
	    echo $audio;
	}

}