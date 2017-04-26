<?php
$error = false;
$file_db = "../application/config/database.php";
$content_db = file_get_contents($file_db);
$pos = strpos($content_db, "#hostname#");

if ($pos === false) 
{
    $error = true;
    $error_installed = "<strong>Already Installed</strong><br>You appear to have already installed. To reinstall please upload original application/config/database.php file again or if you not want reinstall this then remove or rename <strong>install</strong> folder.";
}


if (isset($_POST['btn-install'])) {    
    // validation
    if($_POST['password'] != $_POST['password2'])
    {
        $error = "Administrator Password Don't Match";
    }
    if ($_POST['inputDBhost'] == '' || $_POST['inputDBusername'] == '' ||  $_POST['inputDBname'] == '') {
        $error = 'Imput Empty' ;
    } 
    if(!$error)
    {
        $con            = new mysqli($_POST['inputDBhost'], $_POST['inputDBusername'], $_POST['inputDBpassword']);                    
        $db_selected    = mysqli_select_db($con, $_POST['inputDBname']);
        if($con && !$db_selected)
        {
            // Create Database
            mysqli_set_charset($con,"utf8");
            $_QUERY = "CREATE DATABASE ".$_POST['inputDBname'];
            $con->query($_QUERY);   
            $db_selected    = mysqli_select_db($con, $_POST['inputDBname']);
            
        }
        if (!$con) {
            $error = "<strong>Mysqli Connect Error:</strong> " .mysqli_connect_error();
        } 
        else if (!$db_selected) 
        {                          
            
                $error = "<strong>Mysqli Error:</strong> ".mysqli_error($con)." ".$con->connect_error;
        } else {                   
            $prefix     = $_POST['inputDBprefix'];
            if($prefix)
                $prefix = $prefix."_";
            else
                $prefix = "cme_";
            $querys     = file_get_contents("sql/install.sql");
            $querys     = str_ireplace("{prefix}", $prefix, $querys)    ;
            $querys     = explode(";\n",$querys);

            $settings     = file_get_contents("sql/settings.sql");
            $settings     = str_ireplace("{prefix}", $prefix, $settings)    ;
            $settings     = explode(";\n",$settings);

            $translations     = file_get_contents("sql/translations.sql");
            $translations     = str_ireplace("{prefix}", $prefix, $translations)    ;
            $translations     = explode(";\n",$translations);  

            $stations     = file_get_contents("sql/stations.sql");
            $stations     = str_ireplace("{prefix}", $prefix, $stations)    ;
            $stations     = explode(";\n",$stations);

            if(count( $querys ) == 0)
            {
               $error = "<strong><i>Install.sql</i> no found</strong>";

            }
            else
            {   

                // setting database
                $file_db = "../application/config/database.php";
                $content_db = file_get_contents($file_db);
                $content_db = str_ireplace("#hostname#", $_POST['inputDBhost'],  $content_db);
                $content_db = str_ireplace("#username#", $_POST['inputDBusername'],  $content_db);
                $content_db = str_ireplace("#password#", $_POST['inputDBpassword'],  $content_db);
                $content_db = str_ireplace("#database#", $_POST['inputDBname'],  $content_db);     
                $content_db = str_ireplace("#dbprefix#", $prefix,  $content_db);     
                file_put_contents($file_db, $content_db);      

                foreach ($querys as $key => $value) {
                    $con->query($value);                      
                }               
                foreach ($settings as $key => $value) {
                    $con->query($value);   
                } 
                foreach ($translations as $key => $value) {
                    $con->query($value);   
                }  
                foreach ($stations as $key => $value) {
                    $con->query($value);   
                }
               

                $_QUERY = "INSERT IGNORE INTO {$prefix}users (username,email,names,password,is_admin) VALUES ('".$_POST['username']."','".$_POST['email']."','Administrator','".sha1($_POST['password'])."','1'); ";

                $con->query($_QUERY);   

                $_QUERY = "UPDATE {$prefix}users SET password = '".sha1($_POST['password'])."' WHERE username = '".$_POST['username']."';";

                $con->query($_QUERY);     

                foreach ($_POST['settings'] as $key => $value) {
                    $_QUERY = "INSERT IGNORE INTO {$prefix}settings (var,value) VALUES ('$key','$value'); ";
                    $con->query($_QUERY);
                    $_QUERY = "UPDATE {$prefix}settings SET value = '$value' WHERE var = '$key'";
                    
                    $con->query($_QUERY);
                }
                $installed = true;
                $_SESSION['installed'] = true;            
            
            }
        }
    }
}
?>