<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {


	public function index($action = '',$artist = '',$album='',$track = '')
	{		
		
		

		if($action =='')
		{
			$this->_is_home =true;
			$action = $this->config->item($this->config->item("homepage"));		

		}

		if($this->input->get("s"))
		{
			$query 		= strip_tags(urldecode($this->input->get("s")));
			$page 		= 'search';
			$action 	= 'search';
		}

		if(config_item("force_login") && !is_logged())
			$action =  $this->config->item('slug_login');

		$this->DATA['autoplay'] = intval($this->input->get("play"));
		$pages_obj = $this->Admin->getTable("pages");
		if($pages_obj)
			$this->DATA['pages'] 	= $pages_obj->num_rows();

		

		switch ($action) {
			case $this->config->item('slug_main'):
				// Directory
				$page = 'artist_directory';

				// Artist 
				if($artist != '' && $album == ''  && $track == '')
				{

					$page = 'artist';
					$this->DATA['data'] 		= artist($artist);	
					$artist = $this->DATA['data']['artist'];
					
					$this->DATA['toptracks'] 	= top_tracks($artist);
					$this->DATA['similar'] 		= $this->DATA['data']['similar'];
					$this->DATA['playlists'] 	= playlist_artist($artist);
					$this->DATA['stations'] 	= searchStation($artist,5);		

					
					if($this->DATA['data'] == '')
					{
						$this->DATA['data']['error'] = true;
						$this->DATA['error'] = __("error404");
						$this->DATA['error2'] = urldecode($artist);
						
					}
					$this->DATA['SEO']['type'] 					= 'artist';
					$this->DATA['SEO']['title']					= $artist;
					$this->DATA['SEO']['description']			= addslashes(more($this->DATA['data']['info']['bio'],150));

						$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>$this->DATA['data']['picture_extra']	
																		)
															);

				}		
				// Album	
				if($artist != '' && $album != '' && $track == '')
				{
					$page = 'album';
					$temp_album = album($artist,$album);												
						
					$this->DATA['album'] 		= $temp_album['album'];
					$this->DATA['tracks'] 		= $temp_album['tracks'];
					$this->DATA['error'] 		= $temp_album['error'];
					foreach ($this->DATA['tracks'] as $key => $value) {
						$desc .= $value['track'].", ";
					}
					$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>$this->DATA['album']['picture_extra']	
																		)
															);

					/*if($this->DATA['error'])
					{
							artist($artist);
							$temp_album = album($artist,$album);												
							

							$this->DATA['album'] 		= $temp_album['album'];
							$this->DATA['tracks'] 		= $temp_album['tracks'];
							$this->DATA['error'] 		= $temp_album['error'];
					}*/
					$this->DATA['SEO']['title']					= $artist." - ".$album;
					$this->DATA['SEO']['type'] 					= 'album';					
					$this->DATA['SEO']['description']			= $desc;
					$this->DATA['error']  	= "Album no found";


				}
				// Track
				if($artist != '' && $album != '' && $track != '')
				{
					$page = 'track';
					$this->DATA['track'] 	= track($artist,$album,$track);		
					if(count($this->DATA['track']) == 0)
					{
						$this->DATA['track']['track'] = urldecode($track);
						$this->DATA['track']['album'] = urldecode($album);
						$this->DATA['track']['artist'] = urldecode($artist);
						$this->DATA['track']['nofound'] = true;
					}

					$this->DATA['stations'] = searchStation($artist.' '.$track,5);		
					
					//$temp =  $this->Admin->getTable("tracks",array("artist" => dslug($artist)),"likes DESC",false,0,5);							

					//$this->DATA['tracks'] = $temp->result_array();								
					$this->DATA['lyric'] = get_lyric($artist,$track);
					$this->DATA['video'] = getYoutube($artist,$track."");
					//$this->DATA['similar'] = similar_name_track($track);


					$this->DATA['error']  = "Track no found";
					$this->DATA['SEO']['title']					= _clean_string($artist)." - "._clean_string($track)." - "._clean_string($album);
					$this->DATA['SEO']['type'] 					= 'track';					
					$this->DATA['SEO']['description']			= more(br2nl($this->DATA['lyric']),150);
					$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>$this->DATA['tracks'][0]['picture_extra']	
																		)
															);

					if(!is_ajax())
					{
						//$preview = 'spotify:track:'.$this->DATA['track']['id'];
						$trackid = $this->DATA['track']['id'];
						//$song = _track_by_id($this->DATA['track']['id'],true);
						


						/*$this->DATA['SEO']['meta_raw']		= 	'
						<meta property="og:title" content="'.$song->external_urls->spotify.'">
						<meta property="og:url" content="'.$song->external_urls->spotify.'">
						<meta property="og:type" content="music.song">														
						
						<meta property="music:duration" content="278">				
						<meta property="music:album" content="'.$song->album->external_urls->spotify.'">
						<meta property="music:album:track" content="'.$song->track_number.'">																				
						<meta property="music:musician" content="'.$song->artists[0]->external_urls->spotify.'">								
						<meta property="music:preview_url:type" content="audio/mpeg">
						<meta property="music:preview_url:url" content="'.$song->preview_url.'">
						<meta property="music:preview_url:secure_url" content="'.$song->preview_url.'">';*/

															
					}
					


				}	
				break;
			case $this->config->item('slug_station'):							
					$page = 'station_page';
					$temp 								= $this->Admin->getTable("stations_genres",array("status" => '1'),"name");
					$this->DATA['stations_genres']		= $temp->result_array();					

					if(!$album)
					{
						$page = 'stations';
						// All stations
						if(!$artist)					
						{
							$this->DATA['SEO']['title']			= _clean_string(__("label_stations"));
							//$this->DATA['stations_genre']		= __("title_station");						
							//$this->DATA['stations'] 			= $this->Admin->getTable("stations");
							$this->DATA['stations'] 			= get_trending('stations',true);
							$temp  = $this->DATA['stations']->result_array();
							foreach ($temp as $key => $value) {								
								$desc .= $value['title'].", ";
							}
							$cover = $temp[0]['cover'];
							$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>base_url().$cover	
																		)
															);
							$this->DATA['SEO']['description']	= more($desc,150);


						}
						else
						{
							// Genres
							
							$this->DATA['stations_genre']		= urldecode($artist);
							$this->DATA['stations'] 			= $this->db->query("SELECT * FROM {PRE}stations WHERE genre like '%".dslug($artist)."%'");														
							$temp 								= $this->DATA['stations']->result_array();							
							foreach ($temp as $key => $value) {								
								$desc .= $value['title'].", ";
							}
							foreach ($this->DATA['stations_genres']	 as $key => $value) {
								if(mb_strtolower($value['name'],"UTF-8") == mb_strtolower(dslug($artist),"UTF-8"))
									$cover = $value['image'];
							}
							$this->DATA['SEO']['title']			= _clean_string(dslug($artist));
							$this->DATA['SEO']['type'] 			= 'station';									
							$this->DATA['SEO']['description']	= more($desc,150);
							$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>base_url().$cover
																		)
															);


						}
					}
					else
					{	
		
						// Station

						$temp = urldecode($album);
						$temp = explode("-",$temp);
						$obj 					= $this->Admin->getTable("stations",array("idstation" => intval(end($temp))));
						$this->DATA['station'] 	= $obj->row_array();
						$temp 		= explode(",", $this->DATA['station']['genre']);
						$this->DATA['station']['genre'] = $temp[0];

						$this->load->helper($this->DATA['station']['type']);
						$order = 'ASC';
						if(function_exists('get_tracklist'))
						{


							$tracklist				= get_tracklist($this->DATA['station']);						
							if(count($tracklist)>0)
							{
								
								if($this->DATA['station']['type'] != 'icecast2' && count($tracklist)>1)
									$this->Admin->deleteTable("stations_tracks",array("idstation" => $this->DATA['station']['idstation']));	
								else
									$order = 'DESC';
								$this->Admin->setTable("stations_tracks",$tracklist,true);	
							}
						}
						$tracklist = null;
						$tracklist =$this->Admin->getTable("stations_tracks",array("idstation" => $this->DATA['station']['idstation']),"id ".$order,false,false,0,50);	
						$this->DATA['tracklist'] = $tracklist->result_array();
						$this->DATA['lyric'] = get_lyric($this->DATA['tracklist'][0]['artist'],$this->DATA['tracklist'][0]['track']);
						if(strpos($this->DATA['lyric']->lyric, "alert-warning") !==false)
							$this->DATA['lyric'] = false;
						$this->DATA['SEO']['description']	= more($this->DATA['station']['description'],150);
						$this->DATA['SEO']['title']			= _clean_string($this->DATA['station']['title']);
						$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
	        																"attr" => 
	        																	array("property" => 'og:image',			        										
	        																			"content" => base_url().$this->DATA['station']['cover']		
	        																		)
	        															);

					}
					
					
					$this->DATA['SEO']['type'] 			= 'station';									
					

					

					
				break;
				case 'search':			
					$this->DATA['all'] 			= search_all($query);
					$this->DATA['artist'] 		= $this->DATA['all']['artists'];
					$this->DATA['albums'] 		= $this->DATA['all']['albums'];
					$this->DATA['tracks'] 		= $this->DATA['all']['tracks'];
					$this->DATA['playlists'] 	= $this->DATA['all']['playlists'];
					$this->DATA['stations'] 	= $this->DATA['all']['stations'];
					$this->DATA['users'] 	= $this->DATA['all']['users'];
					$this->DATA['lyrics'] 	= $this->DATA['all']['lyrics'];
					//$this->DATA['playlists']	= search_playlist($query);
					$this->DATA['query']  		= $query;
					if(count($this->DATA['all']) == 0)
						$this->DATA['data']['error'] = true;
					$this->DATA['error']  		= "Sorry, nothing found on your search <i>".'"'.$query.'"</i>';
					$this->DATA['error2']  		= "Try searching another track, album or artist text";
					$this->DATA['SEO']['title']			= __("label_result_for")." "._clean_string($query);
				break;
				case $this->config->item('slug_trending'):			
					$page = 'trending';
					$this->DATA['trending']		= get_trending();
					$this->DATA['SEO']['title']			= __("label_trending");
					$this->DATA['SEO']['type'] 			= 'trending';								
					
				break;
				case $this->config->item('slug_chat_room'):			
					$page = 'chat_room';					
					$this->DATA['SEO']['title']			= $this->config->item('slug_trending');
				break;	
				case $this->config->item('slug_new_releases'):						
					$page = 'new_releases';					
					$this->DATA['releases']				= get_new_releases();					
					$this->DATA['SEO']['title']			= __("label_new_releases");
					$this->DATA['SEO']['type'] 			= 'new_release';	
				break;
				case $this->config->item('slug_register'):
					if(is_logged())
					{
						redirect(base_url().$this->config->item('slug_user')."/".$this->session->userdata['user']['username']);
					}							
					$page = 'register';
					if($this->input->post())
					{						 
						$this->register();
						
					}
					$this->DATA['SEO']['title'] = __("label_register");
				break;
				case 'recovery':
					if(is_logged())
					{
						redirect(base_url().$this->config->item('slug_user')."/".$this->session->userdata['user']['username']);
					}		
					if($this->input->post('email'))
					{
						$objuser = $this->Admin->getTable("users",array("email" => $this->input->post('email')));
						if($objuser->num_rows() == 1)
						{
							$user 						= $objuser->row_array();
							$data['name'] 				= __("label_recovery_password");
							$this->load->helper('string');
							$code 						= random_string("alnum",50);
							$data['url'] = base_url()."recovery/?k=".$code;
							$template = $this->load->view("emails/recovery",$data,true);
							if($this->Admin->updateTable("users",array("recovery" => $code),array("id" => $user['id'])))
							{
								email($this->input->post('email'),__("label_recovery_password"),$template);	
								$this->session->set_flashdata('success', __("label_check_your_inbox"));
							}
						}
						else
						{
							$this->session->set_flashdata('error', __("error_email_no_found"));
							
						}
						
					}	
					$page = 'recovery';
					if(strlen($this->input->get("k")) == 50)
					{
						$code = _clean_special($this->input->get("k"));
						$objuser = $this->Admin->getTable("users",array("recovery" => $code));
						if($objuser->num_rows() == 1)
						{
							$page = 'recovery_password';														
						}
						if($this->input->post("password-r"))
						{
							$password 	= $this->input->post("password");
							$password2 	= $this->input->post("password-r");
							if($password == $password2)
							{
								if(strlen($password)>=5)
								{
									$user 						= $objuser->row_array();
									$this->Admin->updateTable("users",array("recovery" => '',"password" => sha1($password)),array("id" => $user['id']));
									redirect(base_url().$this->config->item('slug_login'));
									$this->session->set_flashdata('success', __("label_password_updated"));


								}
								else
								{
									$this->session->set_flashdata('error', __("error_password_min_lengh"));
								}
							}
							else
							{
								$this->session->set_flashdata('error', __("error_password_not_match"));
							}
						}
					}	
							
					
					
					$this->DATA['SEO']['title'] = __("label_recovery");
				break;
				case $this->config->item('slug_login'):							
					if(is_logged())
					{
						redirect(base_url().$this->config->item('slug_user')."/".$this->session->userdata['user']['username']);
					}
					$page = 'login';
					$this->DATA['SEO']['title'] = __("label_login");
					if($this->input->post())
					{		
						$username 	= trim($this->input->post("username"));
						$password 	= $this->input->post("password");
						if($username != '' && $password  != '' )
						{
							$login = $this->validate_login($username,sha1($password));
							if($login)
							{
								redirect(base_url());
							}
							else
							{
								$this->session->set_flashdata('error', __("error_login"));
							}
						}
						else
						{
							$this->session->set_flashdata('error', __("error_fields_required"));
						}
						
					}
				break;
				case $this->config->item('slug_logout'):							
					$this->session->sess_destroy();
					redirect(base_url());
					exit;
				break;
				case $this->config->item('slug_my_playlist'):							
					$page = 'my_playlists';		
					if(is_logged())
					{			
						$data 						= $this->Admin->getTable("playlists",array('iduser' => getUserID()),"name");
						$this->DATA['playlists'] 	= $data->result_array();
						
					}
					else
					{
						redirect(base_url().$this->config->item('slug_login'));
					}
					$this->DATA['SEO']['title'] = $this->config->item('slug_my_playlist');			
				break;
				case $this->config->item('slug_top_playlist'):							
					$page = 'top_playlists';								
					$data 						= $this->Admin->getTable("playlists",'image != ""',"likes desc",false,0,50);
					$this->DATA['playlists'] 	= $data->result_array();	
					$this->DATA['SEO']['title'] = __("label_top_playlist");	
				break;
				case $this->config->item('slug_my_favorites'):							
					$page = 'my_favorites';		
					if(!is_logged())
							redirect(base_url().$this->config->item('slug_login'));
						$data 		= $this->db->query("SELECT {PRE}tracks.* FROM {PRE}tracks,{PRE}likes WHERE type = 3 AND iduser = ".getUserID()." AND idtarget=idtracks order by created desc");		
						$tracks 	= $data->result_array();								
					$this->DATA['tracks'] = $tracks;
					$this->DATA['SEO']['title'] = __("label_my_favorites")		;
				break;
				case $this->config->item('slug_genres'):							
					$page = 'genres';							
					$this->DATA['genres'] 	= get_popular_genres();
					$genre = $this->DATA['genres'][0]['name'];
					if($artist != '')
					{
						$page = 'genres_tracks';	
						$this->DATA['genre'] 	= urldecode(ucwords(mb_strtolower($artist,'UTF-8')));
						$genre = dslug($artist);
						$this->DATA['tracks'] 	= get_tracks_genres($genre);
					}
					
					
					
					$this->DATA['SEO']['title'] =$this->DATA['genre'];			
				break;
				
				case $this->config->item('slug_pages'):							
					$page = 'pages';												
					$this->DATA['SEO']['title'] = __("label_pages");			
					$this->DATA['title'] = __("label_pages");			

					if($artist != '')
					{
						$page = 'page';	
						$temp = explode("-",urldecode($artist));
						$this->DATA['SEO']['title'] = urldecode($temp[0]);									
						$this->DATA['page'] 		= $this->Admin->getTable("pages",array("idpage" => intval($temp[1])),"updated desc")->row_array();
						$this->DATA['SEO']['description'] = more($this->DATA['page']['text'],250);
					}						
					else
					{
						$this->DATA['pages'] 		= $this->Admin->getTable("pages",false,"updated desc")->result_array();
					}
					
					
				break;

				case $this->config->item('slug_playlist'):							
					$page = 'playlist';		
					if(!$artist)
						redirect(base_url());
					$temp = explode("-",$artist);
					$data 						= $this->db->query("SELECT  {PRE}playlists.*, {PRE}users.username from {PRE}playlists,{PRE}users WHERE {PRE}playlists.iduser = {PRE}users.id and  {PRE}playlists.idplaylist = ".intval(end($temp)));
					$this->DATA['playlist'] 	= $data->row_array();
					if(!$this->DATA['playlist'])
						show_404();

					$data 						= $this->Admin->getTable("playlists_tracks",array('idplaylist' => intval(end($temp))));
					$this->DATA['tracks'] 		= $data->result_array();
					$this->DATA['SEO']['title'] = _clean_string(__("label_playlist")." - ".$this->DATA['playlist']['name']);				
						foreach ($this->DATA['tracks'] as $key => $value) {								
								$desc .= $value['artist']." - ".$value['track'].", ";
							}
							
					$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'og:image',			        										
																			"content" =>strtok($this->DATA['playlist']['image'],'?')
																		)
															);
						$this->DATA['SEO']['description']			= addslashes(more($desc,150));

					
					
				break;
				case $this->config->item('slug_user'):							
					$page = 'user';		
					$this->DATA['me'] = false;
					$artist = urldecode($artist);
					$search = $this->Admin->getTable("users",array("username" => $artist));
					if($search->num_rows() == 0)
					{
						$this->DATA['data']['error'] = 'asdasd';
						$this->DATA['error'] = __("error_user_nofound");
						$this->DATA['error2'] = $artist;
					}
					else
					{
						
						

						$user = $search->row_array();
						$data 	= $this->Admin->getTable("users_history",array("iduser" => $user['id']),"created desc",false,0,50);
						$this->DATA['history']	 = $data->result_array();

						if($this->session->userdata['user']['id'] == $user['id'])
							$this->DATA['me'] = true;
						$this->DATA['user']	= $user;	
						$this->DATA['SEO']['title'] = $user['username'];								
					}
					
				break;
			case 'upload_avatar':
				if(!file_exists("avatars"))
				{
					mkdir("avatars");
				}
					
				$config['upload_path'] 		= './avatars/';
				$config['allowed_types'] 	= 'jpg|jpeg|png';
				$config['max_size'] 		= 500;        		
				$config['overwrite'] 		= TRUE;        		
        		$config['file_name'] 		= sha1($this->session->userdata['user']['username']);
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('image'))
				{				
					$r =  strip_tags($this->upload->display_errors());		
					$this->output->set_content_type('application/json')->set_output(json_encode(array('error' =>  $r)));						
				}
				else
				{
					$r = $this->upload->data();		
					$user = $this->session->userdata['user'];
					$user['avatar'] =  $r['file_name'];
					$this->session->set_userdata('user', $user);																
					$this->Admin->updateTable("users",array("avatar" => $r['file_name']),array("username" => $this->session->userdata['user']['username']));			

					$config['image_library'] 	= 'gd2';
					$config['source_image']		= $config['upload_path'].$r['file_name'];
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= TRUE;
					$config['width']			= 300;
					$config['height']			= 300;

					$this->load->library('image_lib', $config); 
					$this->image_lib->resize();
					$this->output->set_content_type('application/json')->set_output(json_encode(array('avatar' =>  avatar($r['file_name'],date("YmdHis")))));					
					
				}
				$page = false;
				break;
				case 'd':
					$source = $this->input->get("s1");
					$artist = dslug($this->input->get("artist"));
					$track = dslug($this->input->get("track"));
					if($source == 'itunes' || $source == 'apple')
						$this->download_itunes($artist,$track);
					if($source == 'amazon')
						$this->download_amazon($artist,$track);
					if($source == 'soundcloud')
						$this->download_soundcloud($artist,$track);
					if($source == 'youtube')
						$this->download_youtube($artist,$track);	
					if($source == 'spotify')
						$this->download_spotify($artist,$track);
					return false;
				break;
			default:
				$page = $action;
				break;
		}
				
			$this->DATA['SEO']['meta'][]		= 	array("type" => 'meta',
																"attr" => 
																	array("property" => 'fb:app_id',			        										
																			"content" =>config_item('facebook_app_id')	
																		)
															);
			
			if($page)
				$this->show($page);
		
	}

	protected function register()
	{
		$this->load->helper('email');
		$email 		= trim($this->input->post("email"));
		$username 	= trim($this->input->post("username"));
		$password 	= $this->input->post("password");
		$password2 	= $this->input->post("password-r");
		if($email != '' && $username != '' && $password != '' && $password2 != '')
		{
			if (valid_email($email))
			{
				if($password == $password2)
				{
					if(strlen($password)>=5)
					{
						$is_free = $this->Admin->getTable("users",array("email" => $email));
						if($is_free->num_rows() == 0)
						{
							$is_free = $this->Admin->getTable("users",array("username" => $username));							
							if($is_free->num_rows() == 0)
							{
								$save['username'] 	= $username;
								$save['email'] 		= $email;
								$save['names'] 		= $username;
								$save['is_admin'] 	= '0';
								$save['password'] 	= sha1($password);
								$save['avatar'] 	= base_url()."assets/images/default_avatar.png";
								if($this->Admin->setTable("users",$save))
								{
									$login = $this->validate_login($email,sha1($password));
									if($login)
									{
										redirect(base_url());
									}
								}	
								else
								{
									$this->session->set_flashdata('error', __("error_internal_server"));
								}
							}
							else
							{
								$this->session->set_flashdata('error', __("error_username_already_registered"));
							}

						}
						else
						{
							$this->session->set_flashdata('error', __("error_email_already_registered"));

						}
					}
					else
					{
						$this->session->set_flashdata('error', __("error_password_min_lengh"));
					}
				}
				else
				{
					$this->session->set_flashdata('error', __("error_password_not_match"));
				}


			}
			else
			{
				$this->session->set_flashdata('error', __("error_email_not_valid"));
			}
		}
		else
		{
			$this->session->set_flashdata('error', __("error_fields_required"));
		}
		
	}

	protected function validate_login($username,$password)
	{
		$return = false;
		// Login with username
		$is_valid = $this->Admin->getTable("users",array("username" => $username,"password" => $password));
		if($is_valid->num_rows() == 1)
			$return = true;
		else
		{
			// Login with Email	
			$is_valid = $this->Admin->getTable("users",array("email" => $username,"password" => $password));
			if($is_valid->num_rows() == 1)
				$return = true;
		}	
		if($return)
		{
			$data['user'] = $is_valid->row_array();
			$this->session->set_userdata($data);
		}
		return $return;
	}

	protected function download_itunes($artist,$track)
	{
		
		$query = $artist." ".$track;
		$json 	= search_itunes($query);
		$json 	= json_decode($json);		
		if($json->resultCount>0)
		{
			$url_redirect = $json->results[0]->trackViewUrl;			
		}
		else
		{			
			$url_redirect = "http://www.apple.com/search/?section=itunes&geo=".getCountryCode()."&q=$query";
		}
	
		redirect($url_redirect,'location');


	}

	function download_amazon($artist,$track)
	{
		$query = $artist." ".$track;
		$url_redirect = $this->config->item("amazon_site")."/gp/search?ie=UTF8&camp=1789&creative=9325&index=music&keywords=$query&linkCode=ur2&tag=".$this->config->item("amazon_afiliate");		
		redirect($url_redirect,'location');		

	}
	function download_soundcloud($artist,$track)
	{
		$query = $artist." ".$track;
		$url_redirect = "https://soundcloud.com/search?q=$query";
		redirect($url_redirect,'location');		

	}
	function download_spotify($artist,$track)
	{
		$data = $this->Admin->getTable("tracks",array("artist" => dslug($artist),"track" => dslug($track)));
		
		if($data->num_rows ()== 0)
		{
			$url_redirect = "https://play.spotify.com/search/".$artist." ".$track;
		}
		else
		{
			$temp = $data->row();		
			$url_redirect = "https://play.spotify.com/track/".$temp->id;
		}
		
		redirect($url_redirect,'location');		

	}
	function download_youtube($artist,$track)
	{
		
		$code = getYoutube($artist,$track);
		$video = "https://www.youtube.com/watch?v=$code";
		$url_redirect = "http://youtubeinmp3.com/fetch/?video=".urlencode($video);
		redirect($url_redirect,'location');		

	}
	/*
	function download_mp3()
	{
		$query 				= decode(urlencode($this->input->get("q",TRUE)));	
		
		$artist 			= urldecode($this->input->get("a",TRUE));		
		$track 				= urldecode($this->input->get("t",TRUE));	
		$data 				= json_decode(searchYoutube($artist,$track));		
		setDownload($artist,$track,'','mp3');			

		$videoID 			= get_video_id($data);
	
		$video 				= "https://www.youtube.com/watch?v=".$videoID;
		$download_service 	= $this->config->item("download_service");				
		$download_service 	= str_ireplace("%youtube_url%", $video, $download_service);
		$download_service 	= str_ireplace("%youtube_video%", $videoID, $download_service);				
		if($videoID == '')
		{
			redirect("http://www.youtube.com/results?search_query=$query",'location');
		}
		else
		{
			if($this->config->item("adfly_downloads") == '1' && $this->config->item("adfly_key") != '' && $this->config->item("adfly_uid"))
			{			
				$download_service = adfly($download_service,$artist." - ".$track, $this->config->item("adfly_key"), $this->config->item("adfly_uid"));

			}
			redirect($download_service,'location');
		}
	}
*/


	
}
