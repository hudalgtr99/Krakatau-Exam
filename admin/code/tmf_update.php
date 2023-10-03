<?php

require_once('../config/tce_config.php');

$pagelevel = 10;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = 'Update';
$thispage_title_icon = '<i class="pe-7s-graph1 icon-gradient bg-strong-bliss"></i> ';
$thispage_help = 'Pada halaman ini, seorang admin atau user level 10 memiliki hak untuk melakukan update terdapat instalasi TMF yang telah terpasang sebelumnya. Anda membutuhkan file dengan ekstensi zip yang disediakan oleh pengembang.';

require_once('../../shared/code/tce_functions_form_admin.php');

if (isset($_POST['update'])) {
    $menu_mode = 'update';
} 

switch ($menu_mode) { // process submitted data
    case 'update':{
		$zip = new ZipArchive;
		$update_file = $_FILES['updatefile']['tmp_name'];
		$update_file_size = $_FILES['updatefile']['size'];
		$update_file_name = $_FILES['updatefile']['name'];
		$extension = pathinfo($update_file_name, PATHINFO_EXTENSION);
		// $destination = K_PATH_CACHE.'update/';
		$destination = K_PATH_MAIN;
				
			
		/* if(!file_exists($destination)){
			mkdir($destination, 0777);
		}
		
		if(!file_exists($destination.'extract/')){
			mkdir($destination.'extract/', 0777);
		} */
		
		if(!file_exists(K_PATH_CACHE.'update/')){
			mkdir(K_PATH_CACHE.'update/', 0777);
		}
		
		if (isset($update_file) and strlen($update_file)>0 and $update_file_size>0) {
			if ($extension !== 'zip') {
				F_print_error('WARNING','File yang diupload bukan file ZIP');
				break;
			}
						
			move_uploaded_file($update_file, K_PATH_CACHE.'update/'.$update_file_name);		

			if ($zip->open(K_PATH_CACHE.'update/'.$update_file_name) === TRUE) {
				$zip->extractTo($destination);
				$zip->close();
				F_print_error('SUCCESS','File berhasil diekstrak ke folder tujuan');
				
			} else {
				F_print_error('ERROR','Gagal mengekstrak file');
			}
		} else {
			F_print_error('ERROR','Tidak ada file yang diupload');
		}
        break;
    }

    default :{
        break;
    }
} //end of switch

require_once('../code/tce_page_header.php');

switch ($menu_mode) { // process submitted data
	case 'update':{
		echo '<div class="card card-body mb-3 p-1">';
		echo '<div class="alert alert-info m-0">';
		echo file_get_contents($destination.'info_update.txt');
		echo '</div>';
		echo '</div>';
	}
}

echo '<div class="card">'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_uploadupdate">'.K_NEWLINE;
echo '<div class="form-group border p-2 rounded">'.K_NEWLINE;
echo '<label for="userfile" class="font-weight-bold"><i class="fa fa-upload"></i>&nbsp;'.$l['w_upload_file'].'</label>'.K_NEWLINE;
echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.K_MAX_UPLOAD_SIZE.'" />'.K_NEWLINE;
echo '<input class="form-control" type="file" name="updatefile" id="updatefile" size="20" title="'.$l['h_upload_file'].'" />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div class="d-flex justify-content-center">'.K_NEWLINE;
// show upload button
F_submit_button_alt('update', 'Update', 'Update', 'btn btn-success btn-block');
echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
