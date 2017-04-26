<?php

class MY_Install {    
    public function __construct() {
        $CI =& get_instance();
        //$CI->load->database();                
        if (is_dir('install')) 
        {
            redirect(base_url()."install");        
        }         
    }
}
