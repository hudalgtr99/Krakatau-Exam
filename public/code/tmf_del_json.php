<?php
require_once('../config/tce_config.php');
$pagelevel = K_AUTH_PUBLIC_INDEX;
require_once('../../shared/code/tce_authorization.php');

if(isset($_GET['jsonid'])){
	$jsonid = intval($_GET['jsonid']);
	if(file_exists(K_PATH_QBLOCK.$jsonid.'.json')){
		if(unlink(K_PATH_QBLOCK.$jsonid.'.json')){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		echo '404';
	}
}