
<?php if($edit){ ?>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Track</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="artist">Artist</label>
          <input required type="text" class="form-control" id="artist" value="<?php echo $edit['artist']; ?>" name="artist" >
        </div>
         <div class="form-group">
          <label for="album">Album</label>
          <input required type="text" class="form-control" id="album" value="<?php echo $edit['album']; ?>" name="album" >
        </div>
         <div class="form-group">
          <label for="track">Track</label>
          <input required type="text" class="form-control" id="track" value="<?php echo $edit['track']; ?>" name="track" >
        </div>
        <div class="form-group">
          <label for="picture_small">Picture Small</label>
          <input required type="text" class="form-control" id="picture_small" value="<?php echo $edit['picture_small']; ?>" name="picture_small" >
        </div>
      <div class="form-group">
          <label for="picture_medium">Picture Medium</label>
          <input required type="text" class="form-control" id="picture_medium" value="<?php echo $edit['picture_medium']; ?>" name="picture_medium" >
        </div>
         <div class="form-group">
          <label for="picture_extra">Picture Extra</label>
          <input required type="text" class="form-control" id="picture_extra" value="<?php echo $edit['picture_extra']; ?>" name="picture_extra" >
        </div>
       <div class="form-group">
          <label for="youtube_id">Youtube ID</label>
          <input  type="text" class="form-control" id="youtube_id" value="<?php echo $edit['youtube_id']; ?>" name="youtube_id" >
        </div>
       <div class="form-group">
          <label for="soundcloud_id">Soundcloud ID</label>
          <input  type="text" class="form-control" id="soundcloud_id" value="<?php echo $edit['soundcloud_id']; ?>" name="soundcloud_id" >
        </div>
         <div class="form-group">
          <label for="streaming_url">Streaming URL (Mp3)</label>
          <input  type="text" class="form-control" id="streaming_url" value="<?php echo $edit['streaming_url']; ?>" name="streaming_url" >
        </div>

     
    
     
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
<?php } ?>

<div class="col-md-<?php if($edit){ echo '8'; }else{ echo '12'; } ?>">
  <div class="box">
        <div class="box-header">
          <h3 class="box-title">Tracks</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
       <table data-source="<?php echo base_url(); ?>admin/music/track" class="table-ajax table table-hover table-striped table-bordered" id="lyricsTable">
        <thead>
          <tr>              
            <th class="text-center"></th>                               
            <th>Artist</th>               
            <th>Track</th>               
            <th>Album</th>               
            <th>Likes</th>               
            <th style="width:24px"></th>                    
          </tr>
        </thead>
      <tbody>           
      </tbody>
      </table>
    </div>
  </div>
</div>

