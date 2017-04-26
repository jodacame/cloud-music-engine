<?php 
function social_get_user($type,$value)
{
	$CI  	=& get_instance(); 
	$data 	= $CI->Admin->getTable("users",array($type => $value));
	if($data->num_rows() == 0)
		return false;
	return $data->row_array();
}
function validate_username($username)
{
	$username = _clean_string($username);
	if($username == '')
		$username = 'JhonDoe'.rand(100,99999999);
	$CI  	=& get_instance(); 
	$CI->db->like('username', $username, 'before'); 
	$data 	= $CI->db->get("users");
	if($data->num_rows() > 0)
		return $username.$data->num_rows();
	return $username;
}
function get_social_login()
{
	$CI  	=& get_instance(); 
	?>
	<?php if($CI->config->item('spotify_client_id') && $CI->config->item('spotify_client_secret')){ ?>
	<a href="<?php echo base_url(); ?>auth/spotify/login" class="exclude btn azm-social azm-size-32  azm-spotify"><i class="fa fa-spotify"></i></a>
	<?php } ?>
	<?php if($CI->config->item('facebook_app_id') && $CI->config->item('facebook_app_secret')){ ?>
    <a href="<?php echo base_url(); ?>auth/facebook/login" class="exclude btn azm-social azm-size-32  azm-facebook"><i class="fa fa-facebook"></i></a>
    <?php } ?>
    <?php if($CI->config->item('google_client_id') && $CI->config->item('google_client_secret')){ ?>
    <a href="<?php echo base_url(); ?>auth/google/login" class="exclude btn azm-social azm-size-32  azm-google-plus"><i class="fa fa-google"></i></a>
    <?php } ?>
    <?php if($CI->config->item('vk_client_id') && $CI->config->item('vk_client_secret')){ ?>
    <a href="<?php echo base_url(); ?>auth/vk/login" class="exclude btn azm-social azm-size-32  azm-vk"><i class="fa fa-vk"></i></a>
    <?php } ?>
    <?php
}