<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name: Sitemap Generator For Youtube Music Engine
 * Version: 1.4.3
 * URL: //support.jodacame.com/category/updates/
 */


class Sitemap extends MY_Controller {
 function __construct()
    {    
        parent::__construct();        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_content_type('text/xml');
        $this->load->helper('file');
    }   

	public function index()
	{
		$this->_get_cache("sitemap.xml");			
		// Tracks
		$tracks 			= $this->Admin->sitemap_get_tracks();		
		$data['pages'] 		= ceil($tracks->num_rows()/5000);
		$data['tracks']  	= $this->load->view("sitemap/sitemap_tracks_page",$data,true);	
		// Artist		
		$artist 			= $this->Admin->sitemap_get_artist();		
		$data['pages'] 		= ceil($artist->num_rows()/5000);
		$data['artist'] 	= $this->load->view("sitemap/sitemap_artist_page",$data,true);	
		

		$data['count_stations'] = $this->Admin->sitemap_get_stations();	

		$file = $this->load->view("sitemap/sitemap",$data,true);
		$this->_set_cache("sitemap.xml",$file);
		echo $file;
	}

	/*public function tags()
	{
		$this->_get_cache("sitemap_tags.xml");	
		$tags 			= $this->config->item("genres");
		$tags_array 	= explode(",",$tags);
		$tags 			= $this->config->item("custom_genres");
		$tags_array2 	= explode(",",$tags);
		$data['tags'] 	= array_merge($tags_array,$tags_array2);
		$file = $this->load->view("sitemap_tags",$data,true);
		$this->_set_cache("sitemap_tags.xml",$file);
		echo $file;
	}*/

	public function artist($page = false)
	{
			$filename = "sitemap_artist$page.xml";
			$this->_get_cache($filename);	
			$page = intval($page)-1;		
			$page = intval($page)*5000;	
			$data['artists'] = $this->Admin->sitemap_get_artist($page);					
			$file = $this->load->view("sitemap/sitemap_artist",$data,true);		
			$this->_set_cache($filename ,$file);
			echo $file;
		
	}

	public function tracks($page = '1')
	{
		$filename = "sitemap_tracks$page.xml";
		$this->_get_cache($filename);					
		$page = intval($page)-1;		
		$page = intval($page)*5000;					
		$data['tracks'] = $this->Admin->sitemap_get_tracks($page);												
		$file = $this->load->view("sitemap/sitemap_tracks",$data,true);	
		$this->_set_cache($filename,$file);
		echo $file;				
				
	}




	public function users()
	{
		$this->_get_cache("sitemap_users.xml");				
		$data['users'] = $this->Admin->sitemap_get_users();													
		$file = $this->load->view("sitemap/sitemap_users",$data,true);	
		$this->_set_cache("sitemap/sitemap_users.xml",$file);
		echo $file;					
				
	}

	public function playlist()
	{
		$this->_get_cache("sitemap_playlist.xml");				
		$data['playlist'] = $this->Admin->sitemap_get_playlist();														
		$file = $this->load->view("sitemap/sitemap_playlist",$data,true);	
		$this->_set_cache("sitemap/sitemap_playlist.xml",$file);
		echo $file;
	}



	public function stations()
	{
		$this->_get_cache("sitemap_stations.xml");				
		$data['stations'] = $this->Admin->sitemap_get_stations();													
		$file = $this->load->view("sitemap/sitemap_stations",$data,true);	
		$this->_set_cache("sitemap/sitemap_stations.xml",$file);
		echo $file;	
	}

	protected function _get_cache($file)
	{
		$file_cache = "cache/sitemap/$file";
		if(file_exists($file_cache) && is_readable($file_cache))
		{		
			/*if (time()-filemtime($file_cache) > 24 * 3600) {
			  // file older than 24 hours
				@unlink($file_cache);
			}*/			
			if(file_exists($file_cache))
			{
				/*header('Content-Type: application/xml; charset=utf-8');
				echo read_file($file_cache).$this->_set_benchmark();
				exit;*/
				redirect(base_url().$file_cache,301);
				die();
			}
			else
			{
				return false;
			}

		}
		return false;
	}

	protected function _set_cache($file,$xml)
	{	
		if(!file_exists("cache/sitemap/"))
			mkdir("cache/sitemap/",0777,TRUE);
		if(!is_writable("cache/sitemap/"))
		{
			header('Content-Type: text/html; charset=utf-8');
			die("Please set permissions to folder cache/sitemap if folder not exist read this documentation http://support.jodacame.com/article-categories/sitemap-youtube-music-engine");
		}
		$file_cache = "cache/sitemap/$file";		
		write_file($file_cache, $xml);		
	}

	protected function _set_benchmark()
	{		
		return "<!-- Cache -->";
	}



}