<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vk extends MY_Controller {

public $redirect_uri = "";
public $client_id = "";
public $client_secret = "";
 function __construct()
    {    
        parent::__construct();       
        $this->redirect_uri 		= base_url()."auth/vk/process";        
      
		$this->client_id 			= $this->config->item("vk_client_id");
        $this->client_secret 		= $this->config->item("vk_client_secret");

    }   
	public function login()
	{	
		$url = "https://oauth.vk.com/authorize?client_id=".$this->client_id ."&scope=offline,email,audio&redirect_uri=". $this->redirect_uri."&response_type=code&v=5.44";		
		redirect($url,"location");		
	}

	public function process()
	{	
		$code 	= $this->input->get("code");	
		if($code)
		{			
			$token 		= json_decode(_curl("https://oauth.vk.com/access_token?client_id=".$this->client_id."&client_secret=".$this->client_secret."&code=".$code."&redirect_uri=".$this->redirect_uri."&expire=0"));												
			$email 		= $token->email;			
			$userid 	= $token->user_id;			
			$profile 	= json_decode($this->get_profile($token->access_token,$userid));
			
			if(!$userid)
			{
				show_error("NO ID VK",403);
			}
			// Validate if user exist
			$exist = social_get_user('idvk',$userid);	
			if(!$exist)
			{	
				if($email == '')
					$email = $userid."@vk.com";
				$exist = social_get_user('email',$email);	
			}

			if($email == '')
				show_error("Error conocido",403);

			if($exist)
			{
				$save['idvk'] 			= $userid;	
	            $save['avatar']     	= $profile->response[0]->photo_big;
				// First Time
				if($exist['idvk'] == '')
				{
					$this->Admin->updateTable("users",$save,array("email" => $email));				
				}	
				$exist['vk'] 				= (array)$token;		
				$exist['vk']['created'] 	= date("Y-m-d H:i:s");

				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());
			}
			else
			{	
				$email 				= $email;
				$names 				= $profile->response[0]->first_name." ".$profile->response[0]->last_name;
				
				$username 			= $profile->response[0]->nickname;			
				if($username)
					$username  = $username."VK";
				
				

				if($names && !$username)
				{
					$username = str_ireplace(" ", "", $names).$userid;
				}
				if($email && !$username)
				{
					$temp 		= explode("@", $email);
					$username 	= $temp[0];
				}
				if(!$username)
					$username		= $userid;	

				if(!$username)
					$username  = $profile->response[0]->screen_name;
				
				if(!$email)
					$email =  $userid."@vk.com";
				$save['idvk']		= $userid;				
				$save['username'] 	= validate_username($username);				
				$save['email'] 		= $email;
				if($names)
					$save['names'] 		= $names;
				$save['is_admin'] 	= '0';
				$save['password'] 	= sha1(rand(0,999999999).date("YmdHis"));
				$save['avatar']     = $profile->response[0]->photo_big;
				$this->Admin->setTable("users",$save);
				$exist = social_get_user('idvk',$userid);
				if(!$exist)
					show_error("Your VK account not allow login",403);	
				$exist['vk'] 				= (array)$token;		
				$exist['vk']['created'] 	= date("Y-m-d H:i:s");			
				$this->session->set_userdata(array("user" => $exist));
				redirect(base_url());				
			}			
			
		}
		
	}
	protected function get_profile($token,$userid)
	{		
		$this->Admin->setTableIgnore("settings",array("value" => $token,"var" => 'vk_token'));
		$this->Admin->updateTable("settings",array("value" => $token),array("var" => 'vk_token','value' => ''));
		return _curl("https://api.vk.com/method/users.get?user_ids=$userid&fields=photo_big,nickname,screen_name,email&access_token=".$token);
	}
}