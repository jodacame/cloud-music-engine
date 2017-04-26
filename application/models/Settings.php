<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Model 
{

	function get()
	{
		return $this->db->get("settings");
	}
	function themes($theme = false)
	{
		if($theme)
			return $this->db->get_where("themes",array("name_theme" => $theme));
		return $this->db->get("themes");
	}

	function get_lang($code)
	{
		$this->db->select("code,translation");
		return $this->db->get_where("translation",array("code_lang" => $code));	
	}

}

/* End of file settings.php */
/* Location: ./application/models/settings.php */