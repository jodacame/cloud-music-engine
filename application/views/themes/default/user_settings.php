<div id="error-div">
</div>
<div class="col-lg-6">
	<fieldset class="scheduler-border">
	<legend class="scheduler-border"><?php echo __("label_profile"); ?></legend>
		<form class="form-horizontal" method="POST" autocomplete="off" onsubmit="return updateUser(this,'profile');">
		  <div class="form-group">
		    <label for="user-email" class="col-sm-3 control-label"><?php echo __("label_email"); ?></label>
		    <div class="col-sm-9">
		      <input type="email" required autocomplete="off"  name="email" class="form-control" id="user-email" value="<?php echo $this->session->user['email']; ?>">
		    </div>
		  </div>

		   <div class="form-group">
		    <label for="user-username" class="col-sm-3 control-label"><?php echo __("label_username"); ?></label>
		    <div class="col-sm-9">
		      <input type="text" required autocomplete="off" name="username" class="form-control" id="user-username" value="<?php echo $this->session->user['username']; ?>">
		    </div>
		  </div>

		   <div class="form-group">
		    <label for="user-names" class="col-sm-3 control-label"><?php echo __("label_names"); ?></label>
		    <div class="col-sm-9">
		      <input type="text" required autocomplete="off" name="names" class="form-control" id="user-names" value="<?php echo $this->session->user['names']; ?>">
		    </div>
		  </div>

		 <!--<div class="form-group">
		    <label for="user-language" class="col-sm-3 control-label"><?php echo __("label_language"); ?>*</label>
		    <div class="col-sm-9">
		      <select  required autocomplete="off" name="lang" class="form-control" id="user-language">
		      <?php 
		      foreach ($langs as $key => $value) {
		      	?>
		      	<option <?php if($this->session->user['lang'] == $value['code']) { echo 'selected';} ?> value="<?php echo $value['code']; ?>"><?php echo $value['name']; ?></option>
		      	<?php		      	
		      }
		      ?>
		     </select> 
		     <i class="inline-help">*<?php echo __("label_login_again"); ?></i>
		    </div>
		  </div>	-->	
		
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-9">
		      <button type="submit" class="btn btn-default"><?php echo __("label_update"); ?></button>
		    </div>
		  </div>


		</form>
	</fieldset>
</div>

<div class="col-lg-6"></div>
<div class="clearfix"></div>
<div class="col-lg-6">
	<fieldset class="scheduler-border">
	<legend class="scheduler-border"><?php echo __("label_password"); ?></legend>
		<form class="form-horizontal" method="POST" autocomplete="off" onsubmit="return updateUser(this,'password');">
		 
		
		  <div class="form-group">
		    <label for="user-new-password" class="col-sm-3 control-label"><?php echo __("label_new_password"); ?></label>
		    <div class="col-sm-9">
		      <input type="password" name="password" required autocomplete="off" class="form-control" id="user-new-password" value="">
		    </div>
		  </div>

		   <div class="form-group">
		    <label for="user-repeat-password" class="col-sm-3 control-label"><?php echo __("label_repeat_password"); ?></label>
		    <div class="col-sm-9">
		      <input type="password" name="password2"  required autocomplete="off" class="form-control" id="user-repeat-password" value="">
		    

		    </div>
		  </div>
 		

 		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-9">
		      <button type="submit" class="btn btn-default"><?php echo __("label_update"); ?></button>
		    </div>
		  </div>
		</form>
	</fieldset>
</div>
<div class="col-lg-6"></div>
<div class="clearfix"></div>
<div class="col-lg-6">
	<fieldset class="scheduler-border">
	<legend class="scheduler-border"><?php echo __("label_social_networks"); ?></legend>
		<form class="form-horizontal" method="POST" autocomplete="off" onsubmit="return updateUser(this,'social');">
		 
		 <div class="form-group">
		    <label  class="col-sm-3 control-label"><?php echo __("label_website"); ?></label>
		    <div class="col-sm-9">
		      <input type="url" autocomplete="off" class="form-control" name="website_url" value="<?php echo $this->session->user['website_url']; ?>">
		    </div>
		  </div>

		  <div class="form-group">
		    <label  class="col-sm-3 control-label"><?php echo __("label_facebook"); ?></label>
		    <div class="col-sm-9">
		      <input type="url" autocomplete="off" class="form-control" name="facebook_url" value="<?php echo $this->session->user['facebook_url']; ?>">
		    </div>
		  </div>

		   <div class="form-group">
		    <label  class="col-sm-3 control-label"><?php echo __("label_twitter"); ?></label>
		    <div class="col-sm-9">
		      <input type="url" autocomplete="off" class="form-control" name="twitter_url" value="<?php echo $this->session->user['twitter_url']; ?>">
		    </div>
		  </div>

		  <div class="form-group">
		    <label  class="col-sm-3 control-label"><?php echo __("label_google_plus"); ?></label>
		    <div class="col-sm-9">
		      <input type="url" autocomplete="off" class="form-control" name="google_plus_url" value="<?php echo $this->session->user['google_plus_url']; ?>">
		    </div>
		  </div>

		   <div class="form-group">
		    <label  class="col-sm-3 control-label"><?php echo __("label_spotify"); ?></label>
		    <div class="col-sm-9">
		      <input type="url" autocomplete="off" class="form-control" name="spotify_url" value="<?php echo $this->session->user['spotify_url']; ?>">
		    </div>
		  </div>




		 

 		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-9">
		      <button type="submit" class="btn btn-default"><?php echo __("label_update"); ?></button>
		    </div>
		  </div>
		</form>
	</fieldset>
</div>