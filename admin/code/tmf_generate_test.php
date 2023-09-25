<?php
//============================================================+
// File name   : tmf_generate_test.php
// Begin       : 2020-05-20
// Last Update : 2020-06-22
//
// Description : Generate Test Data
//
// Author: Maman Sulaeman
//

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_TESTS;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/config/tce_user_registration.php');

$enable_calendar = true;
require_once('../../shared/code/tce_authorization.php');
require_once('../../admin/code/tmf_functions_test_admin.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('tce_functions_tcecode_editor.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('tce_functions_user_select.php');
require_once('tce_functions_test_select.php');

///////////////////////////////////
if(isset($_REQUEST['check_total_user'])){
	$array = array();
	$test_id=$_REQUEST['test_id'];
	$sql = 'SELECT tstgrp_group_id FROM '.K_TABLE_TEST_GROUPS.' WHERE tstgrp_test_id='.$test_id.'';
	if ($r = F_db_query($sql, $db)) {
	    while ($m = F_db_fetch_array($r)) {
		$sqlug = 'SELECT usrgrp_user_id FROM '.K_TABLE_USERGROUP.' WHERE usrgrp_group_id='.$m['tstgrp_group_id'].'';
		if ($rug = F_db_query($sqlug, $db)) {
			while ($mug = F_db_fetch_array($rug)) {
				//echo $mug['usrgrp_user_id']."<br/>";
				$array[] = $mug['usrgrp_user_id'];
			}
		}else{
		    F_display_db_error();
		}
	    }
	} else {
	    F_display_db_error();
	}
	$uniq_array = array_unique($array);
	echo count($uniq_array);
	die();
}
///////////////////////////////////

if(isset($_REQUEST['check_generated_test'])){
	$test_id=$_REQUEST['test_id'];
	$sql = 'SELECT testuser_id FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_status=9';
	$ro = F_db_query($sql, $db);
	$num_rows = $ro->num_rows;
	echo $num_rows;
	die();
}

if(isset($_REQUEST['del_generated_test'])){
	$test_id=$_REQUEST['test_id'];
	$sql = 'DELETE FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_status=9';
	$ro = F_db_query($sql, $db);
	//$num_rows = $ro->num_rows;
	//echo $num_rows;
	die();
}


///////////////////////////////////////////////

$test_id=$_REQUEST['test_id'];
// $sql = 'SELECT usrgrp_user_id FROM '.K_TABLE_USERGROUP.' INNER JOIN '.K_TABLE_TEST_GROUPS.' ON '.K_TABLE_USERGROUP.'.usrgrp_group_id = '.K_TABLE_TEST_GROUPS.'.tstgrp_group_id WHERE '.K_TABLE_TEST_GROUPS.'.tstgrp_test_id='.$test_id;
$sql = 'SELECT usrgrp_user_id FROM '.K_TABLE_USERGROUP.' INNER JOIN '.K_TABLE_TEST_GROUPS.' ON '.K_TABLE_USERGROUP.'.usrgrp_group_id = '.K_TABLE_TEST_GROUPS.'.tstgrp_group_id WHERE '.K_TABLE_TEST_GROUPS.'.tstgrp_test_id='.$test_id.' GROUP BY usrgrp_user_id';
$testdata = F_getTestData($test_id);

$userTestEntry=array();	
$usrgrp_uid=array();

//SELECT last id, without INSERT
$sqltuid='SELECT AUTO_INCREMENT - 1 as CurrentId FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = \''.K_DATABASE_NAME.'\' AND TABLE_NAME = \''.K_TABLE_TEST_USER.'\' LIMIT 1';
// $sqltuid='SELECT MAX(testuser_id) FROM '.K_TABLE_TEST_USER.' LIMIT 1';
if ($rtuid = F_db_query($sqltuid, $db)) {
	if ($mtuid = F_db_fetch_array($rtuid)) {
		$testuser_id = $mtuid[0];
	}
}

if ($r = F_db_query($sql, $db)) {
	while ($m = F_db_fetch_array($r)){
		$testuser_id++;
		$userTestEntry[] = '('.$testuser_id.', '.$test_id.', '.$m['usrgrp_user_id'].', 9, \'0001-01-01 00:00:00\')';
		$usrgrptest_uid[]=array('user_id' => $m['usrgrp_user_id'], 'testuser_id' => $testuser_id);
		// $testdata_arr[]=array('testuser_id' => $testuser_id, 'test_id' => $test_id, 'user_id' => $m['usrgrp_user_id']);
		$testdata_arr[]=array($testuser_id);
	}
} else {
	F_display_db_error();
}

// 1. create user's test entry
// ------------------------------
$values = implode(", ", $userTestEntry);
$sql = 'INSERT IGNORE INTO '.K_TABLE_TEST_USER.' (
	testuser_id,
	testuser_test_id,
	testuser_user_id,
	testuser_status,
	testuser_creation_time
	) VALUES '.$values;
if (!$r = F_db_query($sql, $db)) {
	F_display_db_error(false);
	return false;
}

F_createTestAdmin($test_id, $testdata, $usrgrptest_uid);

// foreach($usrgrptest_uid as $x => $x_value) {
    // echo "Key=" . $x . ", Value=" . $x_value;
    // echo "<br>";
// }
// array_push($usrgrptest_uid, $test_id);
// print_r($testdata_arr);
$fp = fopen(K_PATH_QBLOCK.'testlogid_arr_'.$test_id.'.json', 'w');
fwrite($fp, json_encode($testdata_arr));
fclose($fp);

/**foreach ($usrgrptest_uid as $key => $data) {
	$user_id=$data['user_id'];
	$testuser_id=$data['testuser_id'];	
}**/
//var_dump($arrForAnswer);
//FROM UPDATE
die();
