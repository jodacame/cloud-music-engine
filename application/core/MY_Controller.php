<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

  public $DATA  = Array();
  public $_THEME  = '';
  public $_PANEL  = false;
	public $_is_home	= false;

	public function __construct()
   	{
    	parent::__construct();
      $this->load->library('user_agent');
     /* if($this->agent->is_mobile())
      {
        show_error("Not allowed access to mobile devices",403);
        die();
      }*/
    	$this->load->database();    	
      $this->set_settings();    	
    	
      

      $this->_THEME = "themes/".$this->config->item("theme")."/";
      if(strtolower($this->router->fetch_class() =='backend'))
      {
        if(!is_ajax())
        {
          show_404();
        }
      }
      if(strtolower($this->router->fetch_class() =='panel'))
      {
          $this->validate_update();
          if(!is_admin())
          {
            show_404();
          }
          else
          {
              $this->generate_menu();
              $this->_PANEL = true; 
              $this->_THEME = "admin/";  
          }
          
      }
      
   	}

   	protected function show($page)
   	{
      if(is_sadmin())
          $this->output->enable_profiler(TRUE);
        
        if($this->_is_home)
   		     $this->DATA['SEO']['title']      =  _clean_string(config_item('site_title'));
         else
          $this->DATA['SEO']['title']      =  _clean_string(config_item('site_title'). " - ".urldecode($this->DATA['SEO']['title']));
   		if($this->input->is_ajax_request())
   		{ 
         if($this->agent->is_mobile() && file_exists(APPPATH."views/".$this->_THEME."mobile/".$page.".php"))
          {             
            $this->load->view($this->_THEME."mobile/".$page,$this->DATA);  
          }
          else
   			    $this->load->view($this->_THEME.$page,$this->DATA);	        
        $this->output->append_output($this->load->view('_common/ajax',$this->DATA,TRUE));
   		}
   		else
   		{
        if(!file_exists(APPPATH."views/".$this->_THEME.$page.".php"))
        {
          show_404();
        }
        
        if($this->agent->is_mobile() && file_exists(APPPATH."views/".$this->_THEME."mobile/".$page.".php"))
        {             
          $this->DATA["_PAGE"] = $this->load->view($this->_THEME."mobile/".$page,$this->DATA,true);  
        }
        else
          $this->DATA["_PAGE"] = $this->load->view($this->_THEME.$page,$this->DATA,true);  
   			$this->DATA["page"] = $page;	
        $this->generate_template();
   			$this->load->view($this->_THEME.'index',$this->DATA);	
       

   		}
   		
   	}
  protected function generate_template()
	{
    
    if($this->_PANEL)
      return false;
		$this->DATA['_PLAYER'] 	= $this->load->view($this->custom_common('player'),$this->DATA,TRUE);
		$this->DATA['_SIDEBAR'] = $this->load->view($this->custom_common('sidebar'),$this->DATA,TRUE);
		$this->DATA['_HEADER'] 	= $this->load->view($this->custom_common('header'),$this->DATA,TRUE);
		$this->DATA['_NAVBAR'] 	= $this->load->view($this->custom_common('navbar'),$this->DATA,TRUE);
		$this->DATA['_FOOTER'] 	= $this->load->view($this->custom_common('footer'),$this->DATA,TRUE);
		$this->DATA['_MODALS'] 	= $this->load->view($this->custom_common('modals'),$this->DATA,TRUE);
	}
  protected function custom_common($view)
  {
    if(file_exists(APPPATH."views/".$this->_THEME.$view.".php"))
    {
        return $this->_THEME.$view;
    }
    else
    {
      return "_common/".$view;
    }
    
  }
	protected function set_settings()
	{
		$this->load->model("settings");
	 $settings         = $this->settings->get();
    foreach ($settings->result_array() as $row) 
    {   

      $this->config->set_item($row['var'], $row['value']);  
    }	
    if(config_item('color_theme'))
    {
      $themes  				= $this->settings->themes(config_item('color_theme'));
  		$theme          = $themes->row_array();
      foreach ($theme as $key => $row) {
        $this->config->set_item($key, $row);  
      }
  		
  	}	

    $langs  = $this->db->query("
      SELECT {PRE}languages.* FROM 
      {PRE}languages,
      {PRE}translation
      WHERE
      {PRE}languages.code = {PRE}translation.code_lang
      GROUP BY {PRE}languages.name
      ORDER BY {PRE}languages.name
      ");    
     $this->config->set_item("langs",$langs->result_array());

    // Load Lang
    
    $lang_user = $this->session->lang;
    if($lang_user == '' || $this->input->get("lang"))
    {
      $lang_user = 'en';
      $temp_lang = getLang();
      if($this->input->get("lang"))
        $temp_lang = mb_strtolower($this->input->get("lang"));
      foreach ($langs->result_array() as $key => $value) {
        if($temp_lang == $value['code'])
          $lang_user = $temp_lang;
      }
      
    }
    $this->session->set_userdata('lang',  $lang_user ); 
    $lang_obj   = $this->settings->get_lang($lang_user);
    foreach ($lang_obj->result() as $row) 
    {   
      $lang[$row->code] = $row->translation;
    }
    $this->config->set_item('translation', $lang);  




   


      $config = Array(
            'protocol' => 'smtp',                         
            'smtp_crypto' => $this->config->item("smtp_crypto"),
            'smtp_host' =>$this->config->item("smtp_host"),
            'smtp_port' =>$this->config->item("smtp_port"),
            'smtp_user' => $this->config->item("smtp_user"), // change it to yours
            'smtp_pass' => $this->config->item("smtp_password"), // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
      );
     $this->load->library('email',$config);  

    

	}
  protected function generate_menu()
  {
      $menus        = $this->Admin->getTable("admin_menus");
      $array        = array();
      foreach ($menus->result_array() as $key => $value) 
      {
        $value['idunique'] = $value['idunique'];
        if($value['idparent'] == '')
          $array[$value['idunique']] = $value;
        else
          $array[$value['idparent']]['submenu'][] = $value;

        $info_menu[$value['idunique']] = $value;
        
      }          
      $this->DATA['_MENU']  = $array;
      $this->DATA['_MENU_INFO']  = $info_menu;

  }
  protected function validate_update()
  {
      if(file_exists("update/update.sql"))
      {
        $MD5 = md5_file("update/update.sql");
        if($this->config->item("update_hash") != $MD5)
        {
          $version = explode(".",config_item("version"));
          if($version[0] == '1')
          {
            $this->db->query("TRUNCATE TABLE {PRE}albums;");                                           
            $this->db->query("TRUNCATE TABLE {PRE}artist;");                                           
            $this->db->query("TRUNCATE TABLE {PRE}tracks;");                                           
            $this->db->query("TRUNCATE TABLE {PRE}users_history;");                                                       
            $this->db->query("DELETE FROM {PRE}likes where type IN (1,2,3);");                                
            $this->db->query("TRUNCATE TABLE {PRE}sessions;");                                                      
          }

          $sql  = file_get_contents("update/update.sql");
          $sqls   = explode(";\n",$sql);          
          foreach ($sqls as $key => $value) 
          {               
            if($value != '')
            {
              $this->db->query($value);                                           
            }           
          } 
          $this->db->query("UPDATE {PRE}settings SET value = '$MD5' WHERE var='update_hash';");                                   
        }        
      }
  }
}
?>