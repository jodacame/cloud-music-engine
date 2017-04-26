<div class="col-md-8">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Aparence</h3>
       <form role="form" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">            
        
          <div class="form-group">
              <label>Logo</label>   
             <span class="inline-help">Recommendation image size: 406 x 70 pixels</span>
          	<div class="thumbnail text-center"  style="width:406px;background-color:rgba(0,0,0,.5)">
            	<img style="width:406px" src="<?php echo base_url(); ?><?php echo config_item("logo"); ?>">
            	</div>
            </div>
            <input type="file" class="form-control"  name="image">
            <span class="inline-help">Max file size: <?php echo (ini_get('post_max_size')); ?></span>
          </div>  

        <div class="form-group">
            <label>Theme</label>            
            <select class="form-control select2"  name="color_theme" id="select-station-type" required>                
            <?php foreach ($themes->result_array() as $key => $value) { ?>              
                <option <?php if($value['name_theme'] == config_item("color_theme")) { echo 'selected';} ?> value="<?php echo $value['name_theme']; ?>">
                <?php echo $value['name_theme']; ?>
                </option>
            <?php } ?>
                
            </select>
            
          </div>

        </div><!-- /.box-body -->
        <div class="box-footer">          
             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </form>
    </div><!-- /.box-header -->
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.css">
<script>
$(function () {
  
    $(".my-color").colorpicker();

});
</script>

<div class="col-md-4">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">New/Edit Theme</h3>
       <form role="form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <br>          
          <input type="text"  required class="form-control" value="<?php echo $cur_theme["name_theme"]; ?>"  name="name_theme" placeholder="Theme Name">
          <span class="inline-helper">
              The template with the same name is replaced
          </span>
        </div>

        <div class="box-body">
       
            <div class="form-group col-md-6">
              <label>Main Color</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="main_color" value="<?php echo $cur_theme["main_color"]; ?>">
                
                </div>
              </div>  

              <div class="form-group col-md-6">
              <label>Secondary Color</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="secondary_color" value="<?php echo $cur_theme["secondary_color"]; ?>">
                
                </div>
              </div>

               <div class="form-group col-md-6">
              <label>Default Color</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="default_color" value="<?php echo $cur_theme["default_color"]; ?>">
                
                </div>
              </div>

               <div class="form-group col-md-6">
              <label>Text Color</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="text_color" value="<?php echo $cur_theme["text_color"]; ?>">
                
                </div>
              </div>

            <div class="form-group col-md-6">
              <label>Text Color Hover</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="text_color_hover" value="<?php echo $cur_theme["text_color_hover"]; ?>">
                
                </div>
              </div>

            <div class="form-group col-md-6">
              <label>Main text/buttons</label>   
              <div class="input-group my-color">
                <div class="input-group-addon">
                    <i></i>
                  </div>
                  <input type="text" class="form-control" name="color_success" value="<?php echo $cur_theme["color_success"]; ?>">
                
                </div>
              </div>



                 

        </div><!-- /.box-body -->
        <div class="box-footer">
          
             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </div><!-- /.box-header -->
   </div>
    <div class="box box-info">
    <div class="box-header with-border">
      
         <h3 class="box-title">Themes</h3>
        <table class="table table-hover">
          <?php foreach ($themes->result_array() as $key => $value) {
            
            ?>
            <tr>
              <td><?php echo $value['name_theme']; ?></td>
              <td>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['main_color']; ?> " title="Main Color"></div>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['secondary_color']; ?> " title="Secondary Color" ></div>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['color_success']; ?> " title="Color Success"></div>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['default_color']; ?> " title="Default Color"></div>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['text_color']; ?> " title="Text Color"></div>
                <div style="border:1px solid #F0F0F0;display:inline-block; margin-top:2px;height:15px;width:15px;background-color:<?php echo $value['text_color_hover']; ?> " title="Text Color Hover"></div>
                
              </td>
              <td><a href="?theme=<?php echo $value['name_theme']; ?>"><i class="fa fa-pencil"></i></a></td>
            </tr>
            <?php
          }
          ?>
        </table>
      </form>
    </div><!-- /.box-header -->
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.css">
<script>
$(function () {
  
    $(".my-color").colorpicker();

});
</script>
