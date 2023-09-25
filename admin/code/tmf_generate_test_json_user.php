<?php
//============================================================+
// File name   : tmf_generate_test_json_user.php
// Begin       : 2021-02-25
// Last Update : -
//
// Description : Generate JSON of test results for specified user.
//
// Author: Maman Sulaeman
//
//============================================================+

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_result_user'];
// require_once('tce_page_header.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../../shared/code/tmf_qjson_data.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
// require_once('tce_functions_user_select.php');

// comma separated list of required fields

if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }

} else {
    $test_id = 0;
}
if (isset($_REQUEST['testuser_id'])) {
    $testuser_id = intval($_REQUEST['testuser_id']);
} else {
    $testuser_id = 0;
}
if (isset($_REQUEST['user_id'])) {
    $user_id = intval($_REQUEST['user_id']);
} else {
    $user_id = 0;
}
$tid_arr = json_decode(file_get_contents(K_PATH_QBLOCK.'testlogid_arr_'.$test_id.'.json'),false);
foreach($tid_arr as $x => $value_x){
	// echo $value_x[0].'<br/>';
	F_printUserTestStat($value_x[0],$test_id);
}
// print_r($tid_arr);

// echo F_printUserTestStat($testuser_id,$test_id);

//============================================================+
// END OF FILE
//============================================================+
