<div class="col-md-6">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-google"></i> Login with Google</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="google_client_id">Client ID</label>
          <input type="text" class="form-control" id="google_client_id" value="<?php echo config_item('google_client_id'); ?>" name="google_client_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="google_client_secret">Client Secret</label>
          <input type="text" class="form-control" id="google_client_secret" value="<?php echo config_item('google_client_secret'); ?>" name="google_client_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-facebook"></i>  Login with Facebook</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="facebook_app_id">APP ID</label>
          <input type="text" class="form-control" id="facebook_app_id"  value="<?php echo config_item('facebook_app_id'); ?>" name="facebook_app_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="facebook_app_secret">APP Secret</label>
          <input type="text" class="form-control" id="facebook_app_secret" value="<?php echo config_item('facebook_app_secret'); ?>" name="facebook_app_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-6">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-spotify"></i>  Login with Spotify</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="spotify_client_id">Client ID</label>
          <input type="text" class="form-control" id="spotify_client_id" value="<?php echo config_item('spotify_client_id'); ?>" name="spotify_client_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="spotify_client_secret">Client Secret</label>
          <input type="text" class="form-control" id="spotify_client_secret" value="<?php echo config_item('spotify_client_secret'); ?>" name="spotify_client_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-6">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-vk"></i>  Login with Vk.com</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="vk_client_id">Client ID</label>
          <input type="text" class="form-control" id="vk_client_id"  value="<?php echo config_item('vk_client_id'); ?>" name="vk_client_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="vk_client_secret">Client Secret</label>
          <input type="text" class="form-control" id="vk_client_secret" value="<?php echo config_item('vk_client_secret'); ?>" name="vk_client_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>






<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-puzzle-piece"></i> KEYS</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
    
        <div class="form-group">
          <label for="youtube_apikey">Youtube</label>
          <input type="text" required  class="form-control" id="youtube_apikey" value="<?php echo config_item('youtube_apikey'); ?>" name="youtube_apikey" placeholder="">
        </div>
        <div class="form-group">
          <label for="radionomy_apikey">Radionomy</label>
          <input type="text" class="form-control" id="radionomy_apikey" value="<?php echo config_item('radionomy_apikey'); ?>" name="radionomy_apikey" placeholder="">
        </div>
        <div class="form-group">
          <label for="musixmatch_apikey">Musixmatch</label>
          <input type="text" class="form-control" id="musixmatch_apikey" value="<?php echo config_item('musixmatch_apikey'); ?>" name="musixmatch_apikey" placeholder="">
        </div> 
        <div class="form-group">
          <label for="lastfm_apikey">Lastfm</label>
          <input type="text" class="form-control" id="lastfm_apikey" value="<?php echo config_item('lastfm_apikey'); ?>" name="lastfm_apikey" placeholder="">
        </div>    
         <div class="form-group">
          <label for="yandex_key">Yamdex (For auto translation) <a href="https://tech.yandex.com/translate/">GET API KEY</a></label>
          <input type="text" class="form-control" id="yandex_key" value="<?php echo config_item('yandex_key'); ?>" name="yandex_key" placeholder="">
        </div>        
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>



<div class="col-md-6">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-external-link"></i> Afiliate</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
    
        <div class="form-group">
          <label for="itunes_afiliate">iTunes Affiliate</label>
          <input type="text" class="form-control" id="itunes_afiliate" value="<?php echo config_item('itunes_afiliate'); ?>" name="itunes_afiliate" placeholder="">
        </div>
        <div class="form-group">
          <label for="amazon_afiliate">Amazon Affiliate</label>
          <input type="text" class="form-control" id="amazon_afiliate" value="<?php echo config_item('amazon_afiliate'); ?>" name="amazon_afiliate" placeholder="">
        </div> 
        <div class="form-group">
          <label for="amazon_site">Amazon Site</label>
          <input type="text" class="form-control" id="amazon_site" value="<?php echo config_item('amazon_site'); ?>" name="amazon_site" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-soundcloud"></i> Soundcloud</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="soundcloud_client_id">Client ID</label>
          <input type="text" class="form-control" id="soundcloud_client_id"  value="<?php echo config_item('soundcloud_client_id'); ?>" name="soundcloud_client_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="soundcloud_client_secret">Client Secret</label>
          <input type="text" class="form-control" id="soundcloud_client_secret" value="<?php echo config_item('soundcloud_client_secret'); ?>" name="soundcloud_client_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>