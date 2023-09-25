<?php
require_once('../config/tce_config.php');
$pagelevel = K_AUTH_PUBLIC_INDEX;
require_once('../../shared/code/tce_authorization.php');
// echo $_POST['tuid'];
$data = str_replace('[','',stripslashes($_POST['data']));
$data = str_replace(']','',$data);
$data = str_replace('"','',$data);
$dataArr = explode(',',$data);
foreach($dataArr as $key => $value){
	if(file_exists(K_PATH_QBLOCK.$value.'.json')){
		if(unlink(K_PATH_QBLOCK.$value.'.json')){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		echo '404';
	}
}
if(file_exists(K_PATH_ANSWDATA.$_POST['tuid'].'_answdata.txt')){
	if(unlink(K_PATH_ANSWDATA.$_POST['tuid'].'_answdata.txt')){
		echo '1';
	}else{
		echo '0';
	}
}else{
	echo '404';
}
if(file_exists(K_PATH_ANSWDATA.$_POST['tuid'].'_unsure.txt')){
	if(unlink(K_PATH_ANSWDATA.$_POST['tuid'].'_unsure.txt')){
		echo '1';
	}else{
		echo '0';
	}
}else{
	echo '404';
}
?>