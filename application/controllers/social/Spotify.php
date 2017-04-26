<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spotify extends MY_Controller {

public $redirect_uri = "";
public $client_id = "";
public $client_secret = "";
 function __construct()
    {    
        parent::__construct();       
        $this->redirect_uri 		= base_url()."auth/spotify/process";         
       	$this->client_id 			= $this->config->item("spotify_client_id"); 
        $this->client_secret 		= $this->config->item("spotify_client_secret");
         
		
    }   
	public function login()
	{	
		$url = "https://accounts.spotify.com/authorize/?client_id=".$this->client_id."&response_type=code&redirect_uri=".urlencode($this->redirect_uri)."&scope=user-read-private%20user-read-email%20playlist-read-private%20playlist-modify-public%20playlist-read-private&state=34fFs29kd0a9";
		redirect($url,"location");		
	}

	public function process()
	{	
		$code 	= $this->input->get("code");	
		if($code)
		{			
			$headers[] 								= 'Authorization: Basic '.base64_encode($this->client_id.":". $this->client_secret);
			$post['grant_type'] 					= 'authorization_code';
			$post['redirect_uri'] 					= urlencode($this->redirect_uri);
			$post['code'] 							= $code;

			$token 	= json_decode(_curl("https://accounts.spotify.com/api/token",$post,$headers));						

			$profile = json_decode($this->get_profile($token->access_token));			


			
			if(!$profile->id)
			{
				show_error("NO ID spotify",403);
			}
			// Validate if user exist
			$exist = social_get_user('idspotify',$profile->id);	
			if(!$exist)
			{	
				if($profile->email == '')
					$profile->email = $profile->id."@spotify.com";
				$exist = social_get_user('email',$profile->email);	
			}

			if($profile->email == '')
				show_error("Error conocido",403);

			if($exist)
			{

				$save['idspotify'] 	= $profile->id;	
				if($profile->images[0]->url)
	            	$save['avatar']     = $profile->images[0]->url;
				// First Time
				if($exist['idspotify'] == '')
				{
					$this->Admin->updateTable("users",$save,array("email" => $profile->email));				
				}	
				$exist['spotify'] 				= (array)$token;		
				$exist['spotify']['created'] 	= date("Y-m-d H:i:s");
				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());
			}
			else
			{	
				$email 				= $profile->email;
				$names 				= $profile->name;
				$username			= $profile->id;
				if($names)
				{
					$username = str_ireplace(" ", "", $names);
				}
				if($email && !$username)
				{
					$temp 		= explode("@", $email);
					$username 	= $temp[0];
				}
				
				
				if(!$email)
					$email =  $profile->id."@spotify.com";
				$save['idspotify'] = $profile->id;				
				$save['username'] 	= validate_username($username);				
				$save['email'] 		= $email;
				if($names)
					$save['names'] 		= $names;
				$save['is_admin'] 	= '0';
				$save['password'] 	= sha1(rand(0,99999).date("YmdHis"));
				$save['avatar']     = $profile->images[0]->url;
				if(!$save['avatar'])
					$save['avatar'] = base_url()."assets/images/default_avatar.png";
				$this->Admin->setTable("users",$save);
				$exist = social_get_user('idspotify',$profile->id);
				if(!$exist)
					show_error("Your spotify account not allow login",403);	
				$exist['spotify'] 		= (array)$token;			
				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());				
			}			
			
		}
		
	}
	protected function get_profile($token)
	{		
		$headers[] 				= 'Authorization: Bearer '.$token;
		return _curl("https://api.spotify.com/v1/me",false,$headers);
	}
	public function playlist($idplaylist =false)
	{		
		$this->validate_token(); 
		if(!$idplaylist)
		{

			$playlist 					= json_decode($this->get_playlists($this->session->userdata['user']['spotify']['access_token'],$this->session->userdata['user']['idspotify']));
			$this->DATA['playlists'] 	= $playlist;
			$this->show('spotify_playlists');
		}
		else
		{
			
			$this->DATA['autoplay'] = intval($this->input->get("play"));
			$data = explode("::", $idplaylist);
			$playlist = json_decode($this->get_playlist($this->session->userdata['user']['spotify']['access_token'],$data[0],$data[1]));
			$this->DATA['playlist'] = $playlist;
			$this->show('spotify_playlist');	
		}
		
	}
	protected function get_playlists($token,$userid)
	{
		if(!is_logged())
			show_404();		
		$headers[] 				= 'Authorization: Bearer '.$token;
		return _curl("https://api.spotify.com/v1/users/$userid/playlists?limit=50",false,$headers);		
	}
	protected function get_playlist($token,$userid,$idplaylist)
	{
		if(!is_logged())
			show_404();		 
		$url 							= "https://api.spotify.com/v1/users/".$userid."/playlists/".$idplaylist;						
		$headers[] 						= 'Authorization: Bearer '.$token;
		return _curl($url,false,$headers);												

	}

	protected function refresh_token()
	{
		
		$data 		=  $this->session->userdata['user']['spotify'];  
		
		$url ="https://accounts.spotify.com/api/token";
		$post['grant_type'] 	= 'refresh_token';
		$post['refresh_token'] 	= $data['refresh_token'];
		$headers[] 				= 'Authorization: Basic '.base64_encode($this->client_id.":". $this->client_secret);
		$token 					=  (array)json_decode(_curl($url,$post,$headers));				
		$data['access_token'] 	= $token['access_token'];
		if($data['access_token'] == '')
		{
			show_error("Token no refresh",403);
		}
		$data['token_type'] 	= $token['token_type'];
		$data['expires_in'] 	= $token['expires_in'];
		if($token['refresh_token'])
			$data['refresh_token'] 	= $token['refresh_token'];
		$user 					=  $this->session->userdata['user'];
		$user['spotify'] 		= $data;			
		$user['spotify']['created'] 	= date("Y-m-d H:i:s");						
		$this->session->set_userdata(array("user" => $user));		
	}

	protected function validate_token()
	{

		   $data 		=  $this->session->userdata['user']['spotify'];  
		   

	        if($data['access_token'])
	        {
	        	$now  		= strtotime(date("Y-m-d H:i:s"));
		        $created  	= strtotime($data['created']);		
				$diff 		= $now - $created;	

				if($diff >= $data['expires_in'])
				{

					$this->refresh_token();
				}	
	        }
	        else
	        {

	        	show_error("No token active",403);
	        }
	}


}