<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends MY_Controller {

	public function dashboard()
	{
		$this->DATA['menu'] 	= 'dashboard';	
		if(is_sadmin())
		{
			if($this->input->post("purchase_code"))
			{								
				$this->save_settings();
				redirect(base_url()."admin/dashboard");
			}
			if($this->config->item("purchase_code"))
				$this->DATA['license'] = isok($this->config->item("purchase_code"));			
			else
				$this->DATA['license'] = isok($this->input->post("purchase_code"));			
		}

		$this->DATA['users'] 		= $this->Admin->getCountTable("users");
		$this->DATA['playlists'] 	= $this->Admin->getCountTable("playlists");
		$this->DATA['artists'] 		= $this->Admin->getCountTable("artist");
		$this->DATA['albums'] 		= $this->Admin->getCountTable("albums");
		$this->DATA['tracks'] 		= $this->Admin->getCountTable("tracks");
		$this->DATA['stations'] 	= $this->Admin->getCountTable("stations");
		$this->DATA['ftracks'] 		= $this->Admin->getCountTable("likes",array("type" => '3'));
		$this->DATA['falbums'] 		= $this->Admin->getCountTable("likes",array("type" => '2'));
		$this->DATA['fartists'] 	= $this->Admin->getCountTable("likes",array("type" => '1'));
		$this->DATA['fstations'] 	= $this->Admin->getCountTable("likes",array("type" => '5'));
		$this->DATA['fplaylists'] 	= $this->Admin->getCountTable("likes",array("type" => '4'));
		$this->DATA['followers'] 	= $this->Admin->getCountTable("likes",array("type" => '6'));
		$this->DATA['registered'] 	= $this->Admin->getRegisteredUsersByMonth();
		
		$this->show("dashboard");
	}	

	public function externalservices()
	{
		if(!is_sadmin())
			show_404();
		if($this->input->post())
		{
			$this->save_settings();
			redirect(base_url()."admin/externalservices");
		}

		$this->DATA['menu'] 	= 'externalservices';	
		$this->show("externalservices");
	}	

	public function stations()
	{

		// GENRE
		if($this->input->post('name'))
		{

			// NEW
			if(!$this->input->post('id'))
			{
				createFolder("uploads");
				createFolder("uploads/stations");

				$upload = uploadImage('./uploads/stations',sha1($this->input->post('name')),'image');
				
				if($upload['image'])
				{
					
					$save['name'] = $this->input->post("name");
					$save['image'] = "uploads/stations/".$upload['image'];
					$this->Admin->setTableIgnore("stations_genres",$save);					
					redirect(base_url()."admin/stations");
				}
			}
			else
			{
				// UPDATE
				$upload = uploadImage('./uploads/stations',sha1($this->input->post('name')),'image');
				$save['name'] = $this->input->post("name");
				if($upload['image'])				
					$save['image'] = "uploads/stations/".$upload['image'];
				$this->Admin->updateTable("stations_genres",$save,array("id" => intval($this->input->post('id'))));					
				redirect(base_url()."admin/stations");
			}

		
			
		}

		// STATION
		if($this->input->post('type'))
		{

			// NEW
			if(!$this->input->post('idstation'))
			{
				createFolder("uploads");
				createFolder("uploads/stations");

				$upload = uploadImage('./uploads/stations',sha1($this->input->post('url')),'cover');
				
				if($upload['image'])
				{
					
					$save = $this->input->post();
					unset($save['genres']);
					$save['genre'] = implode(",", $this->input->post('genres'));
					$save['cover'] = "uploads/stations/".$upload['image'];
					$this->Admin->setTableIgnore("stations",$save);					
					//redirect(base_url()."admin/stations");
				}
			}
			else
			{
				// UPDATE
				$upload = uploadImage('./uploads/stations',sha1($this->input->post('url')),'cover');
				$save = $this->input->post();
				unset($save['genres']);
				$save['genre'] = implode(",", $this->input->post('genres'));

				if($upload['image'])				
					$save['cover'] = "uploads/stations/".$upload['image'];
				$this->Admin->updateTable("stations",$save,array("idstation" => intval($this->input->post('idstation'))));					
					redirect(base_url()."admin/stations");
			}

		
			
		}


		/* REMOVE */
		if($this->input->get("remove") && $this->input->get("type"))
		{
			if($this->input->get("type") == 'genre')
				$this->Admin->deleteTable("stations_genres",array("id" => intval($this->input->get("remove"))));	
			if($this->input->get("type") == 'station')
				$this->Admin->deleteTable("stations",array("idstation" => intval($this->input->get("remove"))));	

			redirect(base_url()."admin/stations");
		}

		/* EDIT */
		if($this->input->get("edit") && $this->input->get("type"))
		{
			if($this->input->get("type") == 'genre')
			{	
				$temp 	= $this->Admin->getTable("stations_genres",array("id" =>  intval($this->input->get("edit"))));
				$this->DATA['genre']	= $temp->row_array();
			}
			if($this->input->get("type") == 'station')
			{	
				$temp 	= $this->Admin->getTable("stations",array("idstation" =>  intval($this->input->get("edit"))));
				$this->DATA['station']	= $temp->row_array();
			}
		
		}


		$temp 					= $this->Admin->getTable("stations_genres",false,"name");	
		$this->DATA['genres']	= $temp->result_array();
		$temp 					= $this->Admin->getTable("stations");	
		$this->DATA['stations']	= $temp->result_array();
		$this->DATA['menu'] 	= 'stations';	
		$this->show("stations");
	}
	public function translation()
	{	
		$lang = "en";
		if($this->input->get("lang"))
			$lang = $this->input->get("lang");
		if($this->input->post("r") && $lang != 'en')
		{
			$this->Admin->deleteTable("translation",array("code_lang" =>$lang));
			redirect(base_url()."admin/translation/");
			exit;
		}
		if($this->input->post() && !$this->input->post("r"))
		{
			foreach ($this->input->post() as $key => $value) {
				$save['code'] 			= $key;
				$save['translation'] 	= $value;
				$save['code_lang'] 		= $lang;
				$data[] = $save;
			}
			$this->Admin->setTable("translation",$data,true);
			foreach ($data as $key => $value) {
				$this->Admin->updateTable("translation",$value,array("code" => $value['code'],"code_lang" => $value['code_lang']));
			}
		}
		$temp 							= $this->Admin->getTable("translation",array("code_lang" => $lang));		
		if($temp->num_rows() == 0)
		{
			$temp 							= $this->Admin->getTable("translation",array("code_lang" => "en"));		
			foreach ($temp->result_array() as $key => $value) 
			{
				$t[]	 = array("code" => $value['code'],"translation" => '',"helper" => $value['translation']);
			}
			$this->DATA['translation'] 		= $t;
		}
		else
			$this->DATA['translation'] 		= $temp->result_array();

		$complteted = 0;
		foreach ($this->DATA['translation']  as $key => $value) {
			if($value['translation'] != '')
				$complteted++;
		}
		$this->DATA['porc'] = ceil(($complteted*100)/$temp->num_rows());
		$temp 							= $this->Admin->getTable("languages");	
		$this->DATA['languages'] 		= $temp->result_array();
		$this->DATA['menu'] 			= 'translation';	
		$this->DATA['lang'] 			= $lang;	
		$this->show("translation");
	}
	
	public function users()
	{	
		if(is_ajax())
		{
			$this->table_users();
			return false;
		}
		
		$this->DATA['menu'] 	= 'users';	
		$this->show("users");
	}	

	public function pages()
	{	
		if(intval($this->input->get("delete")))
		{
			$this->Admin->deleteTable("pages",array("idpage"=> intval($this->input->get("delete"))));
			redirect(base_url()."admin/pages/");
			exit;
		}
		if($this->input->post())
		{
			// Update
			if($this->input->post("idpage"))
			{
				$update = $this->input->post();
				unset($update['_wysihtml5_mode']);
				$id = intval($update['idpage']);
				unset($update['idpage']);
				$this->Admin->updateTable("pages",$update,array("idpage" => $id));
				
			}
			else
			{
				$save = $this->input->post();
				
				unset($save['idpage']);
				unset($save['_wysihtml5_mode']);
				$this->Admin->setTable("pages",$save);
				redirect(base_url()."admin/pages");
			}
		}
		$this->DATA['page'] 	= $this->Admin->getTable("pages",array("idpage" =>  intval($this->input->get("idpage"))))->row_array();	
		$this->DATA['pages'] 	= $this->Admin->getTable("pages",false,"updated DESC")->result_array();
		$this->DATA['menu'] 	= 'pages';	
		$this->show("pages");
	}

	public function music($module)
	{
		if($this->input->post())
		{
			$save = $this->input->post();
			$this->Admin->updateTable($this->input->get("t"),$save,array($this->input->get("f") => $this->input->get("id")));

		}	
		if($this->input->get("c") && $this->input->get("n"))
		{
			_all_artist_by_id($this->input->get("c"),urldecode($this->input->get("n")));
		}

		if($this->input->get("id"))
		{
			$data = $this->Admin->getTable($this->input->get("t"),array($this->input->get("f") => $this->input->get("id")));
			$this->DATA['edit'] = $data->row_array();
		}
		if($module == 'lyrics' && is_ajax())	
		{			
			$this->table_lyrics();
			return false;			
		}	
		if($module == 'artist' && is_ajax())	
		{			
			$this->table_artist();
			return false;			
		}	
		if($module == 'track' && is_ajax())	
		{			
			$this->table_track();
			return false;			
		}
		if($module == 'album' && is_ajax())	
		{			
			$this->table_album();
			return false;			
		}		

		$this->DATA['menu'] 	= 'music';	
		$this->DATA['submenu'] 	= $module;	
		$this->show($module);
	}


	public function settings($module = 'website')
	{		
		if(!is_sadmin())
			show_404();
		if($module == 'apperance')
		{
			$this->apperance();
			return false;
		}
		if(!$module)
			$module = 'website';
		if($this->input->post())
		{
			$this->save_settings();
			redirect(base_url()."admin/settings/".$module);
		}
		$this->DATA['menu'] 	= 'settings';		
		$this->DATA['submenu'] 	= $module;		
		$this->DATA['fields']	 = $this->Admin->getTable("settings",array("module" => $module),"order");		
		$this->show("settings");
	}

	protected function apperance()
	{
		if($this->input->post("color_theme"))
		{
			
			createFolder("uploads");
			createFolder("uploads/stations");
			$upload = uploadImage('./uploads/',sha1($this->input->post('name')),'image');				
			if($upload['image'])
			{	
				$this->Admin->updateTable("settings",array("value" => "uploads/".$upload['image']),array("var" => 'logo'));
			}
			
			$this->save_settings();

			// Save theme.css
			$this->load->model("settings");
			$this->load->helper('file');
		    $themes  				= $this->settings->themes(config_item('color_theme'));
			$theme          		= $themes->row_array();
		    foreach ($theme as $key => $row) {
		      $this->config->set_item($key, $row);  
		    }			
			$theme 					= $this->load->view("admin/style.php",false,TRUE);
			if (!write_file('./assets/css/theme.css', $theme))
		    {	
		    	echo "Unable to write the file /assets/css/theme.css";
		        die();
		    }
			redirect(base_url()."admin/settings/apperance");
		}
		if($this->input->post("name_theme"))
		{
			$theme = $this->input->post();
			unset($theme['submit']);
			
			$this->Admin->deleteTable("themes",array("name_theme"=> $this->input->post("name_theme")));
			$this->Admin->setTable("themes", $theme);

			// Save theme.css
			$this->load->model("settings");
			$this->load->helper('file');
		    $themes  				= $this->settings->themes(config_item('color_theme'));
			$theme          		= $themes->row_array();
		    foreach ($theme as $key => $row) {
		      $this->config->set_item($key, $row);  
		    }			
			$theme 					= $this->load->view("admin/style.php",false,TRUE);
			if (!write_file('./assets/css/theme.css', $theme))
		    {	
		    	echo "Unable to write the file /assets/css/theme.css";
		        die();
		    }



		}
		if($this->input->get("theme"))
		{
			$this->DATA['cur_theme'] 	=  $this->settings->themes($this->input->get("theme"))->row_array();
		}
		else
		{
			$this->DATA['cur_theme'] 	=  $this->settings->themes(config_item('color_theme'))->row_array();
			
		}
		$this->DATA['themes'] 	=$this->settings->themes();
		$this->DATA['menu'] 	= 'settings';	
		$this->DATA['submenu'] 	= 'apperance';	
		$this->show("apperance");

		

	}
	protected function save_settings()
	{
		if($this->input->post())
		{
			foreach ($this->input->post() as $key => $value) {
				if(is_array($value))
				{
					//print_p($value);					
					$value = implode(",",$value);
				}
				$this->Admin->setTableIgnore("settings",array("value" => $value,"var" => $key));
				$this->Admin->updateTable("settings",array("value" => $value),array("var" => $key));
				$this->config->set_item($key, $value);  
			}
		}
	}
	
	protected function table_users()
	{
		
	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'id';
			$columns[1] = 'avatar';
			$columns[2] = 'username';
			$columns[3] = 'email';						
			$columns[4] = 'names';						
			$columns[5] = 'registered';						
			$columns[6] = 'likes';						
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$users 				= $this->Admin->getTable("users",false,$sOrder,'id,avatar,username,email,names,registered,likes',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		
		$total 					= $this->Admin->getTable("users",false,$sOrder,'id,avatar,username,email,names,registered,likes',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($users->result_array() as $key => $value) {
			$row = array();		
			
			$row[] = $value['id'];
			$row[] = "<img src='".avatar($value['avatar'])."' style='height:30px'>";			
			$row[] = $value['username'];			
			$row[] = $value['email'];			
			$row[] = $value['names'];			
			$row[] = "<span title='".$value['registered']."'>".ago(strtotime($value['registered']))."</span>";			
			$row[] = $value['likes'];			
			
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	protected function table_lyrics()
	{
		
	$status['B']['style'] 	= 'default';
		$status['B']['text'] 	= 'BORRADOR';

		$status['P']['style'] 	= 'success';
		$status['P']['text'] 	= 'PUBLICO';


	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'idlyric';
			$columns[1] = 'artist';
			$columns[2] = 'track';						
			$columns[3] = 'lyric';														
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$lyrics 				= $this->Admin->getTable("tracks_lyrics",false,$sOrder,'idlyric,artist,track,lyric',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		//echo $this->db->last_query();
		$total 					= $this->Admin->getTable("tracks_lyrics",false,$sOrder,'idlyric,artist,track,lyric',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($lyrics->result_array() as $key => $value) {
			$row = array();		
			
			$row[] = $value['idlyric'];
			$row[] = $value['artist'];
			$row[] = $value['track'];
			$row[] = more(strip_tags($value['lyric']),100);			
			$row[]	= '<a class="btn btn-xs btn-primary btn-block btn-edit-lyric" href="?id='.$value['idlyric'].'&f=idlyric&t=tracks_lyrics"><i class="fa fa-pencil"></i></a>';
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	protected function table_artist()
	{
		



	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'idartist';
			$columns[1] = 'artist';			
			$columns[2] = 'likes';			
			$columns[3] = 'crawled';			
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$artists 				= $this->Admin->getTable("artist",false,$sOrder,'idmusixmatch,updated,crawled,idartist,artist,picture_small,likes',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		//echo $this->db->last_query();
		$total 					= $this->Admin->getTable("artist",false,$sOrder,'idmusixmatch,updated,crawled,idartist,artist,picture_small,likes',false,false,$like);	

		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($artists->result_array() as $key => $value) {
			$row = array();		
			if($value['picture_small'] == '')
				$value['picture_small'] = base_url().'assets/images/no-picture.png';
			if($value['crawled'] == '1')
				$value['crawled'] = $value['updated'];
			else
				$value['crawled'] = 'NOT YET';
			$row[] = "<img src='".$value['picture_small']."' style='width:64px'>";
			$row[] = $value['artist'];
			$row[] = $value['likes'];
			$row[] = $value['crawled']. ' <a title="Crawl now" class="btn btn-xs btn-success pull-right" href="?c='.$value['idmusixmatch'].'&n='.urlencode($value['artist']).'"><i class="fa fa-play"></i></a>';
			$row[]	= '<a class="btn btn-xs btn-primary btn-block btn-edit-lyric" href="?id='.$value['idartist'].'&f=idartist&t=artist"><i class="fa fa-pencil"></i></a>';
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	protected function table_track()
	{
		



	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'idtracks';
			$columns[1] = 'artist';			
			$columns[2] = 'album';			
			$columns[3] = 'track';			
			$columns[4] = 'likes';			
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$artists 				= $this->Admin->getTable("tracks",false,$sOrder,'idtracks,artist,album,track,picture_small,likes',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		//echo $this->db->last_query();
		$total 					= $this->Admin->getTable("tracks",false,$sOrder,'idtracks,artist,album,track,picture_small,likes',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($artists->result_array() as $key => $value) {
			$row = array();		
			if($value['picture_small'] == '')
				$value['picture_small'] = base_url().'assets/images/no-picture.png';
			$row[] = "<img src='".$value['picture_small']."' style='width:64px'>";
			$row[] = $value['artist'];
			$row[] = $value['album'];
			$row[] = $value['track'];
			$row[] = $value['likes'];
			$row[]	= '<a class="btn btn-xs btn-primary btn-block btn-edit-lyric" href="?id='.$value['idtracks'].'&f=idtracks&t=tracks"><i class="fa fa-pencil"></i></a>';
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	protected function table_album ()
	{
		



	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'idalbum';
			$columns[1] = 'artist';			
			$columns[2] = 'album';			
			$columns[3] = 'release_date';			
			$columns[4] = 'album_type';			
			$columns[5] = 'likes';			
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$artists 				= $this->Admin->getTable("albums",false,$sOrder,'idalbum,artist,album,release_date,picture_small,likes,album_type',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		//echo $this->db->last_query();
		$total 					= $this->Admin->getTable("albums",false,$sOrder,'idalbum,artist,album,release_date,picture_small,likes,album_type',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($artists->result_array() as $key => $value) {
			$row = array();		
			if($value['picture_small'] == '')
				$value['picture_small'] = base_url().'assets/images/no-picture.png';
			$row[] = "<img src='".$value['picture_small']."' style='width:64px'>";
			$row[] = $value['artist'];
			$row[] = $value['album'];
			$row[] = $value['release_date'];
			$row[] = $value['album_type'];
			$row[] = $value['likes'];
			$row[]	= '<a class="btn btn-xs btn-primary btn-block btn-edit-lyric" href="?id='.$value['idalbum'].'&f=idalbum&t=albums"><i class="fa fa-pencil"></i></a>';
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function update()
	{		
		$DATA 				= array();
		if($this->input->post("r") == 'CONFIRM')
		{
			$this->db->query("TRUNCATE TABLE {PRE}albums;");                                           
            $this->db->query("TRUNCATE TABLE {PRE}artist;");                                           
            $this->db->query("TRUNCATE TABLE {PRE}tracks;");                                           
            //$this->db->query("TRUNCATE TABLE {PRE}users_history;");                                                       
            $this->db->query("DELETE FROM {PRE}likes where type IN (1,2,3);");                                
            //$this->db->query("TRUNCATE TABLE {PRE}sessions;");
            redirect(base_url()."admin/dashboard");
		}

		if($this->input->post("uploading"))
		{			
			if(!file_exists('./uploads/'))
			{
				mkdir('./uploads/');
			}
			$config['upload_path'] 		= './uploads/';
			$config['allowed_types'] 	= 'zip';
			$config['overwrite'] 		=  true;
			$cupload onfig['remove_spaces']	=  true;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('upload'))
			{
				$DATA['upload'] = array('error' => $this->upload->display_errors());				
			}
			else
			{
				$DATA['upload'] = array('upload_data' => $this->upload->data());
				$this->load->library('unzip');
				$file = './uploads/'.$DATA['upload']['upload_data']['file_name'];
				if(file_exists($file))
				{					
					$this->unzip->extract($file, './');	
					$errorZip = strip_tags($this->unzip->error_string());
					if($errorZip != '')
						$DATA['upload'] = $errorZip;
					@unlink($file);
				}
				else
				{
					$DATA['upload'] = array('error' =>'File '.$file." not exist");	
				}
				
				
			}
		}
			
		
		$this->DATA['menu'] 	= 'update';	
		$this->DATA['upload']  = $DATA['upload'];
		$this->show("update");
	}


}