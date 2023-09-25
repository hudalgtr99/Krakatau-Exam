<?php
// var_dump($_FILES);
// ambil data file
require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_QUESTIONS;
require_once('../../shared/code/tce_authorization.php');

// tentukan lokasi file akan dipindahkan
$dirUpload = "../../cache/upload/";

if(is_uploaded_file($_FILES['upload']['tmp_name'])){
	$temp = explode(".", $_FILES['upload']['name']);
	$date = date('dmYHis');
	$newfilename = round(microtime(true)) . '_'.$date.'.' . end($temp);
	$tipe = $_FILES['upload']['type'];
	
	$exts =array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
	
	$xxx = array();
	if(!in_array(($tipe),$exts)){
		$xxx['uploaded'] = 0;
		$xxx['error']['message'] = 'This file format is not allowed';
		echo json_encode($xxx); 
		exit;
	}

	$namaSementara = $_FILES['upload']['tmp_name'];

	// pindahkan file
	$terupload = move_uploaded_file($namaSementara, $dirUpload.$newfilename);
	// $arr = new stdClass();
	if ($terupload) {
		$arr = new \stdClass();
		$arr->uploaded = 1;
		$arr->fileName = $newfilename;
		$arr->url = $dirUpload.$newfilename;
		
		// $arr = array('uploaded'=>1,);
		// echo "<h1>Upload berhasil!</h1>";
		// echo "Link: <a href='".$dirUpload.$namaFile."'>".$namaFile."</a>";
		echo json_encode($arr); 
	} else {
		echo "<h1>Upload Gagal!</h1>";
	}
}
?>