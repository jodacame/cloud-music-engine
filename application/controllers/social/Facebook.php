<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends MY_Controller {

public $redirect_uri = "";
public $client_id = "";
public $client_secret = "";
 function __construct()
    {    
        parent::__construct();       
        $this->redirect_uri 		= base_url()."auth/facebook/process";         
        $this->client_id 			= $this->config->item("facebook_app_id");
        $this->client_secret 		= $this->config->item("facebook_app_secret");
		
    }   
	public function login()
	{	
		$url = "https://www.facebook.com/dialog/oauth?client_id=".$this->client_id."&redirect_uri=".$this->redirect_uri."&scope=public_profile,email&response_type=code";		
		redirect($url,"location");		
	}

	public function process()
	{	
		$code 	= $this->input->get("code");	
		if($code)
		{			
			$token 	= json_decode(_curl("https://graph.facebook.com/v2.3/oauth/access_token?client_id=".$this->client_id."&redirect_uri=".$this->redirect_uri."&client_secret=".$this->client_secret."&code=$code"));									
			$profile = json_decode($this->get_profile($token->access_token));			
			
			if(!$profile->id)
			{
				show_error("NO ID FACEBOOK",403);
			}
			// Validate if user exist
			$exist = social_get_user('idfacebook',$profile->id);	
			if(!$exist)
			{	
				if($profile->email == '')
					$profile->email = $profile->id."@facebook.com";
				$exist = social_get_user('email',$profile->email);	
			}
			
			if($profile->id == '')
				show_error("Error conocido",403);

			if($exist)
			{
				$save['idfacebook'] 	= $profile->id;	
	            $save['avatar']     	= 'https://graph.facebook.com/'.$profile->id.'/picture?type=large';
				// First Time
				if($exist['idfacebook'] == '')
				{
					$this->Admin->updateTable("users",$save,array("email" => $profile->email));				
				}				
				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());
			}
			else
			{	
				$email 				= $profile->email;
				$names 				= $profile->name;
				if($names)
				{
					$username = str_ireplace(" ", "", $names);
				}
				if($email && !$username)
				{
					$temp 		= explode("@", $email);
					$username 	= $temp[0];
				}
				if(!$username)
					$username		= $profile->id;
				
				if(!$email)
					$email =  $profile->id."@facebook.com";
				$save['idfacebook'] = $profile->id;				
				$save['username'] 	= validate_username($username);				
				$save['email'] 		= $email;
				if($names)
					$save['names'] 		= $names;
				$save['is_admin'] 	= '0';
				$save['password'] 	= sha1(rand(0,99999).date("YmdHis"));
				$save['avatar']     = 'https://graph.facebook.com/'.$profile->id.'/picture?type=large';
				$this->Admin->setTable("users",$save);
				$exist = social_get_user('idfacebook',$profile->id);
				if(!$exist)
					show_error("YOur facebook account not allow login",403);				
				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());				
			}			
			
		}
		
	}
	protected function get_profile($token)
	{		
		$appsecret_proof= hash_hmac('sha256', $token, $this->client_secret); 
		return _curl("https://graph.facebook.com/v2.3/me?access_token=".$token."&appsecret_proof=".$appsecret_proof);
	}
}