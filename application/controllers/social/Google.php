<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google  extends MY_Controller {
	public $redirect_uri = "";
	public $client_id 		= "";
	public $client_secret = "";

	function __construct()
    {    
        parent::__construct();       
        $this->redirect_uri 		= base_url()."auth/google/process";         
        $this->client_id 			= $this->config->item("google_client_id");
        $this->client_secret 		= $this->config->item("google_client_secret");
		
    }   

	public function login()
	{
		
		
		
		//$url ="https://accounts.google.com/o/oauth2/auth?client_id=".$_GOOGLE['client_id']."&redirect_uri=".urlencode($_GOOGLE['redirect_uri'])."&scope=https://www.google.com/m8/feeds/&response_type=code&access_type=offline&approval_prompt=force";
		
		$scope[] = 'https://www.googleapis.com/auth/userinfo.profile';
		$scope[] = 'https://www.googleapis.com/auth/userinfo.email';
		
		//$url ="https://accounts.google.com/o/oauth2/auth?client_id=".$_GOOGLE['client_id']."&redirect_uri=".urlencode($_GOOGLE['redirect_uri'])."&scope=".implode(" ", $scope)."&response_type=code&access_type=offline&approval_prompt=force";
		$url ="https://accounts.google.com/o/oauth2/auth?client_id=".$this->client_id."&redirect_uri=".urlencode($this->redirect_uri)."&scope=".implode(" ", $scope)."&response_type=code&access_type=online";
		redirect($url,"location");
	}
	public function process()
	{
		$code 						= $this->input->get("code");			
		$google_api['grant_type'] 	= 'authorization_code';		
		$google_api['code'] 		= $code;
		$google_api['client_id'] 	= $this->client_id;
		$google_api['redirect_uri'] = $this->redirect_uri;
		$google_api['client_secret']= $this->client_secret;
		$token 						= _curl("https://accounts.google.com/o/oauth2/token",$google_api);
		$token 						= json_decode($token);
		$profile					= json_decode(_curl("https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=".$token->access_token));
		

		if(!$profile->id)
		{
			show_error("NO ID GOOGLE",403);
		}
		// Validate if user exist
		$exist = social_get_user('idgoogle',$profile->id);	
		if(!$exist)
		{	
			if($profile->email == '')
				$profile->email = $profile->id."@google.com";
			$exist = social_get_user('email',$profile->email);	
		}

		if($profile->email == '')
			show_error("Error conocido",403);

		if($exist)
		{
			$save['idgoogle'] 	= $profile->id;	
            $save['avatar']     = $profile->picture;
			// First Time
			if($exist['idgoogle'] == '')
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
				$email =  $profile->id."@google.com";
			$save['idgoogle'] = $profile->id;				
			$save['username'] 	= validate_username($username);				
			$save['email'] 		= $email;
			if($names)
				$save['names'] 		= $names;
			$save['is_admin'] 	= '0';
			$save['password'] 	= sha1(rand(0,99999).date("YmdHis"));
			$save['avatar']     = $profile->picture;
			$this->Admin->setTable("users",$save);
			$exist = social_get_user('idgoogle',$profile->id);
			if(!$exist)
				show_error("Your google account not allow login",403);				
			$this->session->set_userdata(array("user" => $exist));
			redirect(base_url());				
		}			
			
	}
	

}