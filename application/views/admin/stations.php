<div class="col-lg-8">

  <div class="box box-warning">
    <div class="box-header">
      <h3 class="box-title">Stations</h3>   
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table datatable">
      <thead>        
        <tr>
            <th></th>
            <th>Title</th>
            <th>Generes</th>
            <th style="width:200px">Type</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($stations as $key => $value) {
          ?>
          <tr>
            <td><img style="width:24px" src="<?php echo base_url(); ?><?php echo $value['cover']; ?>"></td>
            <td><?php echo $value['title']; ?></td>
            <td><?php echo $value['genre']; ?></td>
            <td><?php echo $value['type']; ?></td>
            <td style="width:200px"><a target="_preview" href="<?php echo $value['url']; ?><?php echo $value['mount']; ?>"><i class="fa fa-link"></i> Preview</a></td>
            <td><a href="<?php echo base_url(); ?>admin/stations?edit=<?php echo $value['idstation']; ?>&type=station">Edit</a></td>
            <td><a class="text-danger" href="<?php echo base_url(); ?>admin/stations?remove=<?php echo $value['idstation']; ?>&type=station">Remove</a></td>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
<div class="col-lg-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Add Stations</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="POST" id="frm-station" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label>Type</label>            
            <select class="form-control select2"  name="type" id="select-station-type" required>
                <option value="" selected disabled>Select Type</option>
                <option <?php if($station['type'] == 'icecast2') { echo 'selected';} ?> value="icecast2">Icecast2</option>
                <option  <?php if($station['type'] == 'radionomy') { echo 'selected';} ?> value="radionomy">Radionomy</option>
                <option  <?php if($station['type'] == 'shoutcast_v1') { echo 'selected';} ?> value="shoutcast_v1">ShoutCast v1</option>
                <option  <?php if($station['type'] == 'shoutcast_v2') { echo 'selected';} ?> value="shoutcast_v2">ShoutCast v2</option>                              
            </select>
            
          </div>
          <div class="form-group">
            <label>Streaming URL </label>
            
            <input type="url" value="<?php echo $station['url'];?>" required class="form-control"  id="station-url" name="url">
          </div>
         
           <div class="form-group">
            <label>Title</label>
            <input type="text" value="<?php echo $station['title'];?>" required class="form-control"  name="title">
            <input type="hidden" value="<?php echo $station['idstation'];?>"  class="form-control hide"  name="idstation">
          </div>

          <div class="form-group">
            <label>Cover</label>
            <input type="file"  <?php if(!$station['idstation']) { echo 'required'; } ?>  class="form-control"  name="cover">
            <span class="inline-help">Max file size: <?php echo (ini_get('post_max_size')); ?></span>

          </div>
           <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" required  name="description"><?php echo $station['description'];?></textarea>
          </div>
            <div class="form-group station-input  tunein icecast2 radionomy shoutcast_v1 shoutcast_v2">
            <label>Genres</label>
            <select class="select2 form-control" name="genres[]" multiple="multiple">
            <?php foreach ($genres as $key => $value) {
              $g  = explode(",", $station['genre']);              
               $selected = '';
               foreach ($g as $key2 => $value2) {
                 if($value2 == $value['name'])
                 {
                  
                    $selected = 'selected';
                 }
               }
              ?><option <?php echo $selected; ?> value="<?php echo $value["name"]; ?>"><?php echo $value["name"]; ?></option>
              <?php
            }
            ?>
            </select>
          </div>
          <div class="form-group hide station-input  icecast2">
            <label>Mount Point</label>
            <input type="text" value="<?php echo $station['mount'];?>" class="form-control"  id="station-mount" name="mount">
          </div>

          <div class="form-group hide station-input  radionomy">
            <label>GUID</label>
            <input type="text" value="<?php echo $station['guid'];?>" class="form-control"  name="guid">
          </div>

        
           <div class="form-group" id="preview-station">
            
          </div>  
          <span class="inline-helper station-input hide shoutcast shoutcast_v2">If not working try  append to end the url  the string <strong>;stream</strong></span>
          <span class="inline-helper station-input hide shoutcast_v1 shoutcast_v2"><br><i><strong>Example:</strong> http://ip:port/;stream</i></span>
          
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="button" class="btn btn-success " id="btn-preview-station">Preview</button>
          <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </form>
    </div>
  </div>
<div class="col-md-8">
    <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Genres</h3>   
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table datatable">
        <thead>        
        <tr>
            <th></th>
            <th>Name</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($genres as $key => $value) {
          ?>
          <tr>
            <td><img style="width:24px" src="<?php echo base_url(); ?><?php echo $value['image']; ?>"></td>
            <td><?php echo $value['name']; ?></td>
            <td><a href="<?php echo base_url(); ?>admin/stations?edit=<?php echo $value['id']; ?>&type=genre">Edit</a></td>
            <td><a class="text-danger" href="<?php echo base_url(); ?>admin/stations?remove=<?php echo $value['id']; ?>&type=genre">Remove</a></td>
          </tr>
          <?php
        }
        ?>
      </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->


</div>
<div class="col-lg-4">  


    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Add Genere</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">            
           <div class="form-group">
            <label>Name</label>
            <input type="text"  value="<?php echo $genre['name']; ?>" required class="form-control"  name="name">
            <input type="hidden"  value="<?php echo $genre['id']; ?>" class="form-control hide"  name="id">
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" <?php if(!$genre['id']) { echo 'required'; } ?> class="form-control"  name="image">
            <span class="inline-help">Max file size: <?php echo (ini_get('post_max_size')); ?></span>
          </div>   
        </div><!-- /.box-body -->
        <div class="box-footer">
          
             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </form>
    </div>
 

</div>

