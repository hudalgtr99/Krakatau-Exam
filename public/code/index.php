<?php
//============================================================+
// File name   : index.php
// Begin       : 2004-04-20
// Last Update : 2012-12-04
//
// Description : main user page - allows test selection
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//
// License:
//    Copyright (C) 2004-2012  Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Main page of TCExam Public Area.
 * @package com.tecnick.tcexam.public
 * @brief TCExam Public Area
 * @author Nicola Asuni
 * @since 2004-04-20
 */

/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_PUBLIC_INDEX;
$thispage_title = $l['t_test_list'];
$thispage_title_icon = '<span class="icon-clipboard"></span>';
$thispage_description = $l['hp_public_index'];

require_once('../../shared/code/tce_authorization.php');
require_once('tce_page_header.php');




$jmlSession = F_count_rows(K_TABLE_SESSIONS, 'where cpsession_user_id=\''.$_SESSION['session_user_id'].'\'');
if(!K_ENABLE_MULTI_LOGIN){
	$sqlx = 'SELECT user_level FROM '.K_TABLE_USERS.' WHERE user_id=\''.$_SESSION['session_user_id'].'\' LIMIT 1';
        if ($rx = F_db_query($sqlx, $db)) {
           if ($mx = F_db_fetch_array($rx)){
				// echo $mx['user_level'];		
				if($mx['user_level']<1){
					echo '<div class="error"><span>Akun ini terdeteksi login di beberapa perangkat / browser. Untuk sementara akun dinon-aktifkan. Silakan hubungi pengawas / petugas ujian untuk memulihkan akun Anda.</span><span onclick="this.parentNode.style.display = &quot;none&quot;" id="close_btn">×</span></div>';
					// echo json_encode($login_status);
					// sleep(3);
					// echo $PHPSESSIDSQL;
					// F_session_destroy($PHPSESSIDSQL);
					// $sqlv = 'DELETE FROM '.K_TABLE_SESSIONS.' WHERE cpsession_id=\''.$PHPSESSIDSQL.'\'';
					// if (!$rv = F_db_query($sqlv, $db)) {
					   // F_display_db_error();
					// }
					echo '<script>setTimeout(function(){window.location.replace("tce_logout.php")},3000)</script>';
					die();
				}
			}
		}
					
	
	if($jmlSession>1){	
		$sqlw = 'UPDATE '.K_TABLE_USERS.' SET user_level=\'0\' WHERE user_id=\''.$_SESSION['session_user_id'].'\'';
		if (!$rw = F_db_query($sqlw, $db)) {
		   F_display_db_error();
		}
		
		// F_session_destroy($PHPSESSIDSQL);
		$sqlv = 'DELETE FROM '.K_TABLE_SESSIONS.' WHERE cpsession_user_id=\''.$_SESSION['session_user_id'].'\'';
		if (!$rv = F_db_query($sqlv, $db)) {
		   F_display_db_error();
		}
		
		echo '<div class="error"><span>Akun ini terdeteksi login di beberapa perangkat / browser. Untuk sementara akun dinon-aktifkan. Silakan hubungi pengawas / petugas ujian untuk memulihkan akun Anda.</span><span onclick="this.parentNode.style.display = &quot;none&quot;" id="close_btn">×</span></div>';
		
		// echo '<script>document.getElementById("containerWrapper").style.display = "none"</script>';
		// echo json_encode($login_status);
		die();
	}
}




echo '<div class="container">'.K_NEWLINE;

echo '<div class="tcecontentbox">'.K_NEWLINE;
require_once('../../shared/code/tce_functions_test.php');

echo F_getUserTests();

echo '</div>'.K_NEWLINE;

echo '<div class="pagehelp">'.$thispage_description.'</div>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

require_once('tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
