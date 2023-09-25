<?php
require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_USERS;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/config/tce_user_registration.php');

if(isset($_GET['path'])){
	$file=$_GET['path'];
	// echo $file;
	unlink($file);
	if(!file_exists($file)){
		echo 'File successfully deleted.';
	}else{
		echo 'Not allowed to delete the file.';
	}
}