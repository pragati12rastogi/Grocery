<?php 
session_start();
require 'dbconfig.php';
if(isset($_GET['success']))
{
	if (is_dir($dirname))
           $dir_handle = opendir($dirname);
     if (!$dir_handle)
          return false;
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                else
                     delete_directory($dirname.'/'.$file);
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
}
?>
<!DOCTYPE html>
<html lang="en" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $fset['title'];?></title>
    
    <link rel="shortcut icon"  href="<?php echo $fset['favicon'];?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="app-assets/css/tag.css"/>
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/chartist.min.css">
	<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
     
    
    <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
    
    <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
        
        <!-- ONE Signal Api -->
        <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script> -->
        <!-- <script>
            window.OneSignal = window.OneSignal || [];
            OneSignal.push(function() {
                OneSignal.init({
                  appId: "e4faaba5-cefd-4653-b8c4-ddd82992fc4b",
                });
            });
          
            OneSignal.push(function() {
            /* These examples are all valid */
            var isPushSupported = OneSignal.isPushNotificationsSupported();
            if (isPushSupported) {
                console.log("Supported");
                // Push notifications are supported
                OneSignal.push(function() {
                  OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                    if (isEnabled)
                      console.log("Push notifications are enabled!");
                      
                    else
                      console.log("Push notifications are not enabled yet."); 
                        OneSignal.push(function() {
                          OneSignal.showHttpPrompt();
                        });
                  });
                });
            } else {
                console.log("Not Supported");
                // Push notifications are not supported
            }
            });
            
            
            
            
        </script> -->  
     
  </head>
  
  