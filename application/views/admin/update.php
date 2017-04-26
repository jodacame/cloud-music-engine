
  <div class="col-xs-12">
  <?php if(!is_writable("./uploads/")){ ?>
    <div class="alert alert-danger">
      <strong>Error: </strong> uploads folder is not writable
    </div>
    <?php } ?>
    <?php     
    if(!is_writable("./application/controllers/Home.php")){ ?>
    <div class="alert alert-danger">
      <strong>Error: </strong> Set permissions writable to all files and folders
    </div>
    <?php } ?>

    <?php if(!extension_loaded('zlib')){ ?>
    <div class="alert alert-danger">
      <strong>Error: </strong> ZLib extension is Required
    </div>
    <?php } ?>
    <?php if($upload['error']){ ?>
    <div class="alert alert-danger">
      <strong>Error: </strong> <?php echo $upload['error']; ?>
    </div>

    <?php } ?>

     <?php if(is_array($upload['upload_data'])){ ?>
    <div class="alert alert-success">
      <strong><?php echo str_ireplace("_", " ",$upload['upload_data']['raw_name']); ?> </strong> Installed!, Please Logout and Login Again in Admin Panel      
    </div>

    <?php }else{
      if(!is_array($upload)){
        if($upload != '') {
     ?>

  <div class="alert alert-danger">
        <strong>Error: </strong> <?php echo $upload; ?>
    </div>

    <?php } } } ?>


    <div class="box box-primary">      
      <form method="post"  enctype="multipart/form-data" />          

          <div style="padding:50px;padding-top:50px;padding-bottom:100px" class="text-center">                    
            <i class="fa fa-cloud-upload" style="color:#676767;font-size:10em"></i>
            <h2>Install Updates</h2>
                    <div class="form-group text-center">
                        <input required id="input-1a" type="file" class="file" data-show-preview="false" name="upload" value="" >
                        <input type="hidden" name="uploading" value="1">
                    </div> 
                    <span class="inline-help">
                    Search your <strong>zip</strong> file and upload it!
                    </span>      
                    <div class="clearfix"></div>
                    <span class="inline-help text-danger">
                    Please make <strong>backup</strong> of all files before to upgrade your script.
                    </span>         
                    <div class="clearfix"></div>
                    <br>                 
                    <button type="submit" class="btn btn-success" style="width:200px">Update</button>
        </div>
                
               
            </form>

          
    </div>   



    <div class="box box-danger alert alert-danger">      

      <strong>Restore Factory DataMusic (You lose: Artist, Tracks, Albums and Favorites)</strong><br>
      <small>Use this option if is request by a developer person</small>
      <form method="post">
      <br>
        <input type="text" name="r" required value="" placeholder="Please write here the word 'CONFIRM'  for continue the restore process" class="form-control">
      <br>
        <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-warning"></i> Restore Now</button>
        <div class="clearfix"></div>
        <br>
      </form>
    </div>  

  
  </div>
  

