<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends MY_Controller {

	
	public function radio()
	{
		if(!is_ajax())
			show_404();
		switch ($this->input->post("a")) {
			case 'get_track':
				$artist 		= stripslashes(urldecode($this->input->post("artist")));
				$artist_ok 		= stripslashes(urldecode($this->input->post("artist")));
				// Search Artist ID				
				$artist_data 	= $this->Admin->getTable("artist",array("artist" => $artist),false,false,0,1);


				if($artist_data->num_rows() > 0)
				{

					$data 	= $artist_data->row_array();
					
					$id 	= $data['idartist'];
					$genre_1 	= $data['genre_1'];
				}
				else
				{				
					
					_search_artist($artist);
					$artist_data 	= $this->Admin->getTable("artist",array("artist" => $artist),false,false,0,1);
					$data = $artist_data->row_array();
					
				}


				if($id)
				{
					// Search Related Artist
					if($this->input->post("start") == '1')
					{
						search_all($artist);
						$artist_data 	= $this->Admin->getTable("tracks",array("artist" => $artist),"likes,popularity desc",false,0,10);
						$top = $artist_data->result_array();
					}
					else
					{

						
    					    						
    							$related = get_related_artist($artist);
    							$related_t = $related;
    							foreach ($related as $key => $value) {
    								if($value['tags'] == '')
    									unset($related[$key]);
    							}
    							if(count($related) == 0)
    								$related = $related_t;
    							

    							$artist  = $related[rand(1,(count($related)-1))];
    							_all_artist_by_id($artist['idx'],$artist['artist']);
    							$artist_data 	= $this->Admin->getTable("tracks",array("artist" => $artist['artist']),"RAND()",false,0,10);

								$top = $artist_data->result_array();


    					
								if(count($top)==0)
								{
									
									$artist_data 	= $this->Admin->getTable("tracks",array("artist" => $artist_ok),"RAND()",false,0,10);
									$top = $artist_data->result_array();
								}
						
						

					}
					
					// Search Top Tracks Artist	
					$track = $top[rand(1,count($top)-1)];
					$json['artist'] = ($track['artist']);
					$json['track'] 	= ($track['track']);
					$json['image'] 	= $track['picture_medium'];
					$json['album'] 	= ($track['album']);				
					$json['id'] 	= $track['idtracks'];				
					
				}
				else
				{

					$json['error'] = true;
				}
				$this->output->set_content_type('application/json')->set_output(json_encode($json));						
				break;			
			default:
				# code...
				break;
		}
	}	
	public function get_like_button()
	{
		if(!is_ajax())
			show_404();
		$id = $this->input->post("id");
	  	$exist = $this->Admin->getTable("tracks",array("idtracks" => $id));
	  	if($exist->num_rows() == 0)
	  	{
	  		track_by_id($id);	
	  		$exist = $this->Admin->getTable("tracks",array("idtracks" => $id));
	  	}
	  	$data = $exist->row_array();

		echo getLikeButton(3,getUserID(),$id,$data['likes']);
	}

	public function trending_tracks()
	{
		$data = get_trending('tracks');
		
		echo gui_tracks_thumb($data);
	}
	public function trending_stations()
	{
		$data = get_trending('stations');
		
		echo render_stations($data);
	}
	public function trending_artists()
	{
		$data = get_trending('artists');	
		echo render_artist($data);
	}
	public function trending_albums()
	{
		$data = get_trending('albums');
		echo render_albums($data);
	}
	public function favorites_tracks()
	{
		if(!is_logged())
			show_404();
		$data 		= $this->db->query("SELECT {PRE}tracks.* FROM {PRE}tracks,{PRE}likes WHERE type = 3 AND iduser = ".getUserID()." AND idtarget=idtracks order by created desc");		
		$tracks 	= $data->result_array();		
		echo gui_tracks($tracks);
	}

	public function favorites_artists()
	{
		if(!is_logged())
			show_404();
		$data 		= $this->db->query("SELECT {PRE}artist.* FROM {PRE}artist,{PRE}likes WHERE type = 1 AND iduser = ".getUserID()." AND idtarget=idartist order by created desc");		
		$artists 	= $data->result_array();
		echo render_artist($artists);
	}
	public function favorites_albums()
	{
		if(!is_logged())
			show_404();
		$data 		= $this->db->query("SELECT {PRE}albums.* FROM {PRE}albums,{PRE}likes WHERE type = 2 AND iduser = ".getUserID()." AND idtarget=idalbum order by created desc");		
		$albums 	= $data->result_array();
		echo render_albums($albums);
	}
	public function favorites_playlists()
	{
		if(!is_logged())
			show_404();
		$data 		= $this->db->query("SELECT {PRE}playlists.* FROM {PRE}playlists,{PRE}likes WHERE type = 4 AND {PRE}likes.iduser = ".getUserID()." AND idtarget=idplaylist order by created desc");		
		$playlists 	= $data->result_array();
		echo render_playlists($playlists);
	}
	public function favorites_stations()
	{
		if(!is_logged())
			show_404();
		$data 		= $this->db->query("SELECT {PRE}stations.* FROM {PRE}stations,{PRE}likes WHERE {PRE}likes.type = 5 AND {PRE}likes.iduser = ".getUserID()." AND idtarget=idstation order by created desc");		
		$stations 	= $data->result_array();
		echo render_stations($stations);
	}


	public function like2()
	{
		
		if(!is_logged())
			return false;
		$targets['artist']['table'] = 'artist';
		$targets['artist']['field'] = 'idartist';
		$targets['artist']['type'] 	= '1';
		$targets['artist']['title'] = 'artist';

		$targets['album']['table'] = 'albums';
		$targets['album']['field'] = 'idalbum';
		$targets['album']['type'] 	= '2';
		$targets['album']['title'] 	= 'album';

		$targets['track']['table'] = 'tracks';
		$targets['track']['field'] = 'idtracks';
		$targets['track']['type'] 	= '3';
		$targets['track']['title'] 	= 'track';




	
		$id 				= $this->input->post("id");
		$type 				= $this->input->post("type");
		$field 				= $targets[$type]['field'];
		$table 				= $targets[$type]['table'];

		
		
		$data = $this->Admin->getTable($table,array($field => $id));

		
		if($data->num_rows() ==0 && $type=='artist')		
			artist_by_id($id);			
		

		if($data->num_rows() ==0 && $type=='track')
			track_by_id($id);			
		

		if($data->num_rows() ==0 && $type=='album')
			album_by_id($id);

		if($data->num_rows() ==0 )
			$data = $this->Admin->getTable($table,array($field => $id));

		
		
		
		$data = $data->row_array();


		$save['idtarget'] 	= $data[$field];
		$save['iduser'] 	= getUserID();
		$save['type'] 		= $targets[$type]['type'];

		$title 				= $data[$targets[$type]['title']];
		

		$continue = $this->Admin->setTableIgnore("likes",$save);
		

		if($continue)
		{			
			$this->db->query("UPDATE {PRE}$table SET likes = likes +1 WHERE $field ='".$save['idtarget']."'");			
		}

		$json['title'] 		= __("error404");
		if($save['idtarget'] != '')
			$json['title'] 		= $title;
		$json['subtitle'] 	= __("label_added_favorite");
		$json['image'] 		= $data['picture_small'];
		$json['id'] 		= $save['idtarget'];
		$this->output->set_content_type('application/json')->set_output(json_encode($json));						

		


	}


	public function like()
	{
		if(!is_logged())
			return false;
		$unlike = $this->input->post("unlike");
		$save 	= $this->input->post();
		unset($save['unlike']);
		$save['iduser'] = getUserID();
		
		$exist 				= $this->Admin->getTable("likes",array("type" => $save['type'],"iduser" =>  getUserID(),"idtarget" => $save['idtarget']));
		
		if($exist->num_rows() == 0)
			$unlike = false;
		else
			$unlike = true;
		if($unlike)
			$continue = $this->Admin->deleteTable("likes",$save);
		else
			$continue = $this->Admin->setTableIgnore("likes",$save);
		

		$targets[1]['table'] = 'artist';
		$targets[1]['field'] = 'idartist';

		$targets[2]['table'] = 'albums';
		$targets[2]['field'] = 'idalbum';

		$targets[3]['table'] = 'tracks';
		$targets[3]['field'] = 'idtracks';

		$targets[4]['table'] = 'playlists';
		$targets[4]['field'] = 'idplaylist';		

		$targets[5]['table'] = 'stations';
		$targets[5]['field'] = 'idstation';	

		$targets[6]['table'] = 'users';
		$targets[6]['field'] = 'id';

		
		$table = $targets[$save['type']]['table'];
		$field = $targets[$save['type']]['field'];
		
	

	


		if($continue)
		{
			if($unlike)
				$this->db->query("UPDATE {PRE}$table SET likes = likes -1 WHERE $field ='".$save['idtarget']."'");			
			else
				$this->db->query("UPDATE {PRE}$table SET likes = likes +1 WHERE $field ='".$save['idtarget']."'");			
		}


		if($unlike)
			$unlike = false;
		else
			$unlike = true;
		$exist 				= $this->Admin->getTable($table,array($field => $save['idtarget']));
		$data 				= $exist->row();
		$json['button'] 	= getLikeButton($save['type'],$save['iduser'],$save['idtarget'],intval($data->likes),$unlike);
		$json['unlike'] 	= $unlike;
		$this->output->set_content_type('application/json')->set_output(json_encode($json));						

		


	}
	public function update_playlist()
	{
		if(!is_logged())
			return false;

		createFolder("uploads");
		createFolder("uploads/playlist");
		
		$idplaylist 				= $this->input->post("idplaylist");
		$name 						= _clean_special(rtrim(ltrim($this->input->post("name"))));
		if(intval($idplaylist) == 0 || $name == '')
			show_error("",403);
		
		$config['upload_path'] 		= './uploads/playlist/';
		$config['allowed_types'] 	= 'jpg|jpeg|png';
		$config['max_size'] 		= return_bytes(ini_get('post_max_size'));        		
		$config['overwrite'] 		= TRUE;        		
		$config['file_name'] 		= sha1($this->session->userdata['user']['id'].$idplaylist);
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('image'))
		{				
			
			if($_FILES['image']['size'])
			{
				$r =  strip_tags($this->upload->display_errors());		
				$this->output->set_content_type('application/json')->set_output(json_encode(array('error' =>  $r)));						
			}
			else
			{
				$this->Admin->updateTable("playlists",array("name" => $name),array("idplaylist" => $idplaylist,"iduser" => getUserID()));			
				$this->output->set_content_type('application/json')->set_output(json_encode(array('url' =>  base_url().$this->config->item("slug_playlist")."/".urlencode($name)."-".$idplaylist)));						

			}
		}
		else
		{
			$r = $this->upload->data();		
			$this->Admin->updateTable("playlists",array("image" => base_url()."uploads/playlist/".$r['file_name']."?cache=".strtotime(date("Y-m-d H:i:s")),"name" => $name),array("idplaylist" => $idplaylist,"iduser" => getUserID()));			

			$config['image_library'] 	= 'gd2';
			$config['source_image']		= $config['upload_path'].$r['file_name'];
			$config['create_thumb'] 	= FALSE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']			= 600;
			$config['height']			= 600;

			$this->load->library('image_lib', $config); 
			$this->image_lib->resize();

			$this->output->set_content_type('application/json')->set_output(json_encode(array('url' =>  base_url().$this->config->item("slug_playlist")."/".urlencode($name)."-".$idplaylist,'picture' =>  avatar($r['file_name'],date("YmdHis")))));					
			
		}
	}
	public function set_playlist()
	{
		if(is_logged())
		{
			if($this->input->post("name"))
			{
				$name = _clean_special(rtrim(ltrim($this->input->post("name"))));
				$json['id'] = $this->Admin->setTableIgnore("playlists",array("name" => $name,"public" => 'S','iduser' => getUserID()));
			}
			if($this->input->post("idplaylist"))
			{	
				// Check if is owner playlist
				$exist 	= $this->Admin->getTable("playlists",array("idplaylist" => intval($this->input->post("idplaylist")),"iduser" => getUserID()));

				if($exist->num_rows() > 0)
				{
					// Add track to playlist
					if($this->input->post("acc") != 'r')
					{
						$save = $this->input->post();
						$json['id'] = $this->Admin->setTableIgnore("playlists_tracks",$save);					
						
						$json['id'] = $this->Admin->updateTable("playlists",array("image" => $save['image']),array("idplaylist" => $save['idplaylist'],'image' => ''));
					}
					else
					{
						// Remove Track from playlist
						if($this->input->post("track"))
						{
							$remove = $this->input->post();
							unset($remove['acc']);
							$this->Admin->deleteTable("playlists_tracks",$remove);
						}
						else
						{
							// Remove all playlist
							$remove = $this->input->post();
							unset($remove['acc']);
							$this->Admin->deleteTable("playlists",$remove);
							$this->Admin->deleteTable("playlists_tracks",$remove);
						}

					}
				}
				else
				{
					show_error("403",403);
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($json));						
		}
	}
	public function get_playlists()
	{
		if(is_logged())
		{			
			$data = $this->Admin->getTable("playlists",array('iduser' => getUserID()),"name");
			$json = $data->result_array();
			$this->output->set_content_type('application/json')->set_output(json_encode($json));						
		}
	}

	public function set_history()
	{
		// Last Playing Track
		
		if($this->session->lpt == date("Hi"))
		{
			echo $this->session->lpt;
			return false;		
		}
		$save 				= $this->input->post();
		$save['iduser'] 	= getUserID();
		$save['created'] 	= date("Y-m-d H:i:s");
		$this->Admin->setTableIgnore("users_history",$save);
		$this->session->set_userdata('lpt',date("Hi"));
	}

	public function user_history()
	{
		
		$userid = intval($this->input->get("id"));
		$data 	= $this->Admin->getTable("users_history",array("iduser" => $userid),"created desc",false,0,50);
		$tracks = $data->result_array();
		echo gui_tracks_thumb($tracks);
	}
	public function user_playlists()
	{
		$userid = intval($this->input->get("id"));
		$data 			= $this->Admin->getTable("playlists",array('iduser' => $userid),"name");
		$playlists 	= $data->result_array();
		echo render_playlists($playlists);
	}
	public function user_settings()
	{		
		if(!is_logged())
			show_404();

		$langs 	= $this->db->query("
			SELECT {PRE}languages.* FROM 
			{PRE}languages,
			{PRE}translation
			WHERE
			{PRE}languages.code = {PRE}translation.code_lang
			GROUP BY {PRE}languages.name
			ORDER BY {PRE}languages.name
			");
		
		$this->DATA['langs']  = $langs->result_array();

		$this->show("user_settings");
	}

	public function user_followers()
	{		
		if(!is_logged())
			show_404();
		$iduser = intval($this->input->get("id"));
		$data 		= $this->db->query("
			SELECT {PRE}users.* 
			FROM 
			{PRE}users,
			{PRE}likes 
			WHERE 
			type = 6 AND 
			idtarget = ".$iduser." AND 
			iduser=id 
			order by created desc");	
			
		$users = $data->result_array();
		render_users($users,100);

	}

	public function user_following()
	{		
		if(!is_logged())
			show_404();
		$iduser = intval($this->input->get("id"));
		$data 		= $this->db->query("
			SELECT {PRE}users.* 
			FROM 
			{PRE}users,
			{PRE}likes 
			WHERE 
			type = 6 AND 
			iduser = ".$iduser." AND 
			idtarget=id 
			order by created desc");	
			
		$users = $data->result_array();
		render_users($users,100);

	}


	public function updateUser()
	{
		if(!is_logged())
			show_404();
		$m = $this->input->get("m");
		switch ($m) {			

			case 'profile':
				$save['email']	 	= $this->input->post('email');
				$save['username'] 	= $this->input->post('username');
				$save['names']	 	= $this->input->post('names');
				$save['lang'] 		= $this->input->post('lang');
				if($save['email'] == '' || $save['username'] == '')	
				{
					$json['error'] = __("error_fields_required");
				}	
				else
				{
					// Validate Email / Username
					$exist = $this->db->query("SELECT * FROM {PRE}users WHERE email = '".$save['email']."' and id != ".getUserID());
					if($exist->num_rows() == 0)
					{
						$exist = $this->db->query("SELECT * FROM {PRE}users WHERE username = '".$save['username']."' and id != ".getUserID());
						if($exist->num_rows() == 0)
						{
							$this->Admin->updateTable("users",$save,array("id" => getUserID()));
							$current_spotify 				= $this->session->user['spotify'];
							$user = $this->Admin->getTable("users",array("id" => getUserID()));
							$data = $user->row_array();
							$data['spotify'] = $current_spotify;
							$this->session->set_userdata(array("user" => $data));
							$json['ok'] = '1';					
							$json['profile'] = base_url().$this->config->item("slug_user")."/".$save['username'];
						}
						else
						{
							$json['error'] = __("error_username_already_registered");
						}
					}
					else
					{
						$json['error'] = __("error_email_already_registered");
						
					}
				}	
				break;	

				case 'social':

				$save['website_url']	 		= $this->input->post('website_url');
				$save['facebook_url'] 			= $this->input->post('facebook_url');
				$save['twitter_url']	 		= $this->input->post('twitter_url');
				$save['google_plus_url'] 		= $this->input->post('google_plus_url');
				$save['spotify_url'] 			= $this->input->post('spotify_url');

				$this->Admin->updateTable("users",$save,array("id" => getUserID()));
				$current_spotify 				= $this->session->user['spotify'];
				$user = $this->Admin->getTable("users",array("id" => getUserID()));
				$data = $user->row_array();
				$data['spotify'] = $current_spotify;
				$this->session->set_userdata(array("user" => $data));
				$json['ok'] = '1';					
				$json['success'] =  __("label_profile_updated");
			
				break;	

				case 'password':

				$save['password']	 		= $this->input->post('password');
				$save['password2'] 			= $this->input->post('password2');
				if($save['password'] == $save['password2'])
				{
					if(strlen($save['password'])>=5)
					{
						$this->Admin->updateTable("users",array("password" => sha1($save['password'])),array("id" => getUserID()));
						$json['ok'] = '1';
						$json['success'] =  __("label_password_updated");
					}
					else
					{
						$json['error'] = __("error_password_min_lengh");						
					}
				}
				else
				{
					$json['error'] = __("error_password_not_match");
				}

			
				break;	


			default:
				show_404();
				break;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));						

	}

	public function dashboard()
	{
		echo "Mostrar opciones que puede hacer un usuario con el dashboard (Ejemplo: Agregar una estacion para su aprobacion)";
	}
	
}