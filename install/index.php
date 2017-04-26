<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_GET['force'])
{
    $_SESSION['installed'] = false;
    header('location:../install');
}
$error_c = false;
require_once("app.php");
require_once("core.php");

if($_POST['inputDBhost'] == '')
    $_POST['inputDBhost'] = 'localhost';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $config['app_name']; ?> - Install</title>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    

</head>
<body>
 
<div class="container">
    <div class="head">
          
        <?php echo $config['app_name']; ?>
        <small> <?php echo $config['app_subtitle']; ?></small>       
    </div>
    <div class="row" style="padding:10px">

   <?php if ($installed){ ?>
     <div class="col-xs-12 text-center" style="font-size:20px">
            <br>
            <h1><strong class="text-success"><i class="fa fa-check-circle"></i> <br>Congratulations!</strong><br><br></h1>
            The installation has been completed<br>
            Please <strong>rename</strong> or <strong>remove</strong> <i class="text-danger">"install"</i> folder and after you can go to <a href="../">Your Site</a> and customize.
            <br>
            <br>
        
    </div>
    <?php } ?>  

    <?php if ($error_installed ){ ?>
     <div class="col-xs-12" style="font-size:20px">
            <br>
            <div class="alert alert-warning" style="font-size:14px;">  
            
                <?php echo $error_installed ; ?>
            </div>
        
    </div>
    <?php } ?>

    <form  action="" method="post" role="form" style="margin-top:30px;" class="<?php if ($installed || $error_installed ){ echo 'hide'; } ?>">

        <?php if ($error){ ?>
        <div class="col-xs-12">
            <div class="alert alert-danger" style="font-size:14px;">                                                   
                <i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        </div>
        <?php } ?>



        <div class="col-md-6">
        <legend>Welcome</legend>
            Welcome to installation process. If you have any question or need help, please go to <a href="http://support.jodacame.com">Support Center</a>, a team of professionals are waiting to help you!
            <br>
            <br>
            <br>

       <legend>Setup Requirements</legend>
          <div class="row" style="color:#757575">
                <div class="col-xs-12">
                    <i class="text-<?php if (extension_loaded('mysqli')) { echo "success fa fa-check-circle-o";  } else { echo "danger fa fa-exclamation-circle"; $error_c = true;} ?>"></i>
                    MYSQL 5.0 +
                    
                    
                </div>
                <div class="col-xs-12">
                    <i class="text-<?php if (extension_loaded('curl')) { echo "success fa fa-check-circle-o";  } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i> CURL
                    
                </div>
                <div class="col-xs-12">
                    <i class="text-<?php if (extension_loaded('mysqli')) { echo "success fa fa-check-circle-o";  } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    MYSQLi Extension                    
                </div> 
                <div class="col-xs-12">
                   <i class="text-<?php if (ini_get('allow_url_fopen')) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                   Allow Url Fopen
                    
                </div>   
                <?php if(function_exists('apache_get_modules')){ ?>
                 <div class="col-xs-12">
                   <i class="text-<?php if (in_array('mod_rewrite', apache_get_modules())) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                   Mod Rewrite Module                    
                </div>                     
                <?php } ?>
                <div class="col-xs-12">
                   <i class="text-<?php if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')  { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                   Linux Server                    
                </div>   

          </div>
          <br>
            <legend>Files & Writable Permission</legend>
            <div class="row" style="color:#757575">
               <div class="col-xs-12">
                    <i class="text-<?php if(is_writable("../application/config/database.php")) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    Database File (application/config/database.php)                    
                </div>
                <div class="col-xs-12">
                    <i class="text-<?php if(is_writable("../install")) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    Install Folder (install/)                    
                </div>                             
                
                <div class="col-xs-12">
                    <i class="text-<?php if(is_writable("../uploads/")) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    Uploads Folder (Uploads/)                    
                </div>

                <div class="col-xs-12">
                    <i class="text-<?php if(is_writable("../uploads/avatars/")) { echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    Avatar Folder (uploads/avatars/)                    
                </div> 
                <div class="col-xs-12">
                    <i class="text-<?php  if(file_exists("../.htaccess")){ echo "success fa fa-check-circle-o";   } else { echo "danger fa fa-exclamation-circle";  $error_c = true;} ?>"></i>
                    .htaccess File
                </div> 
                
                <div class="col-xs-12">
                <br>
                
                   <div class="text-center">
                    
                </div>

                  
                </div>
            </div>

        </div>
        <div class="col-md-6">
        <legend>Database Settings</legend>
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                    <input required type="text" class="form-control" placeholder="DB Host" value="<?php echo $_POST['inputDBhost']; ?>" name="inputDBhost">
                </div>
            </div>
           
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>              
                    <input required type="text" placeholder="Username Database" value="<?php echo $_POST['inputDBusername']; ?>" class="form-control" name="inputDBusername">
                </div>
            </div>
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>              
                    <input required type="password" placeholder="Password Database" class="form-control" value="<?php echo $_POST['inputDBpassword']; ?>" name="inputDBpassword">
                </div>
            </div>
             <div class="form-group">                
                <div class="input-group">      
                    <span class="input-group-addon"><i class="fa fa-th-list"></i></span>              
                    <input required type="text" placeholder="DB Name" class="form-control" value="<?php echo $_POST['inputDBname']; ?>" name="inputDBname">
                </div>
            </div> 
            <div class="form-group">                
                <div class="input-group">      
                    <span class="input-group-addon"><i class="fa fa-table"></i></span>              
                    <input maxlength="10" type="text" placeholder="Table Prefix" class="form-control" value="<?php echo $_POST['inputDBprefix']; ?>" name="inputDBprefix">
                </div>
            </div>

            <legend>Administrator Settings</legend>
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>              
                    <input required type="text" pattern="[A-Za-z0-9]{1,25}" class="form-control" placeholder="Username" value="<?php echo $_POST['username']; ?>" name="username">
                </div>
            </div>  
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>              
                    <input required type="email" class="form-control" placeholder="Email Administrator" value="<?php echo $_POST['email']; ?>" name="email">
                </div>
            </div>
            <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>              
                    <input required type="password" placeholder="Password Administrator" class="form-control" name="password">
                </div>
            </div>

             <div class="form-group">                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>              
                    <input required type="password" placeholder="Repeat Password" class="form-control" name="password2">
                </div>
            </div>

            <legend>Settings</legend>
            <?php foreach ($config['settings'] as $key => $value) {
                ?>
                 <div class="form-group">                
                    <div class="input-group">                        
                        <span class="input-group-addon"><a class="inline-help pull-right" href="<?php echo $value['help']; ?>"><i class="<?php echo $value['icon']; ?>"></i></a></span>              
                        <input required type="<?php echo $value['type']; ?>" value="<?php echo $_POST['settings'][$value['name']]; ?>"   placeholder="<?php echo $value['label']; ?>" class="form-control" name="settings[<?php echo $value['name']; ?>]">
                        
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
            <div class="col-xs-12">
            <div class="form-group">
                <div class="controls">                    
                    <?php if($error_c == false){ ?>
                        <button type="submit" class="btn btn-primary btn-block" name="btn-install" /><i class="fa fa-check-circle"></i> Install</button>
                    <?php }else{ ?>
                        <button type="button" disabled class="btn btn-danger btn-disabled btn-block"  /><i class="fa fa-exclamation-circle"></i> Check all requirements</button>
                    <?php } ?>
                </div>
            </div>
            </div>
            <div class="col-xs-12">
            <br>
                <div class="text-center">
                    Copyright &copy; <?php echo date('Y'); ?> <a href="http://jodacame.com">Jodacame.com</a><br>
                    Powered By <a href="http://twitter.com/jodacame">@jodacame</a><br>
                    <a href="http://codecanyon.net/item/youtube-music-engine/<?php echo $config['id_app']; ?>?ref=jodacame">http://codecanyon.net</a><br><br>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
</body>
</html>