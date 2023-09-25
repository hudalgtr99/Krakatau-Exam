<?php
//============================================================+
// File name	: tmf_upload_mediafile.php
// Author		: Maman Sulaeman
//============================================================+

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_FILEMANAGER;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('tce_functions_filemanager.php');

if(isset($_GET['path'])){
	$path = $_GET['path'];
}

$root_dir = K_PATH_CACHE.$path.'/';
$usr_dir = $root_dir;

// upload file
if (!empty($_FILES)) {
    require_once('../code/tce_functions_upload.php');
    if (!F_isAuthorizedDir($usr_dir, $root_dir, $authdirs)) {
        $dir = $usr_dir;
    }
    $file = F_upload_mediafile('file', $usr_dir);
    if (!empty($file)) {
        $file = $usr_dir.$file;
    }
}