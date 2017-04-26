
<?php if($edit){ ?>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Lyric</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="artist">Artist</label>
          <input required type="text" class="form-control" id="artist" value="<?php echo $edit['artist']; ?>" name="artist" >
        </div>
        <div class="form-group">
          <label for="track">Track</label>
          <input required type="text" class="form-control" id="track" value="<?php echo $edit['track']; ?>" name="track" >
        </div>
        <div class="form-group">
          <label for="lyric">Lyric</label>
          <textarea rows="15" class="form-control" id="lyric" name="lyric"><?php echo $edit['lyric']; ?></textarea>
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
          <h3 class="box-title">Lyrics</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
			 <table data-source="<?php echo base_url(); ?>admin/music/lyrics" class="table-ajax table table-hover table-striped table-bordered" id="lyricsTable">
				<thead>
				  <tr> 					    
				    <th>id</th>                						    
				    <th>Artist</th>    
				    <th>Track</th>    
				    <th>lyric</th>    						    				    
				    <th></th>    						    
				  </tr>
				</thead>
			<tbody>           
			</tbody>
			</table>
		</div>
	</div>
</div>

