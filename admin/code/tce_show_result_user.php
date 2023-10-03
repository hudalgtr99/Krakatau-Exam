<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_result_user'];
$thispage_title_icon = '<i class="pe-7s-study icon-gradient bg-love-kiss"></i> ';
$thispage_help = $l['hp_result_user'];

require_once('tce_page_header.php');
?>
<style>
@media print {
	.app-main__inner,.card,.card-body {padding:0; margin:0 !important; border-radius:0; box-shadow:none}
	.app-theme-white.app-container{background:#ffffff}
}
</style>
<?php
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../../shared/code/tce_functions_test_stats.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('tce_functions_user_select.php');

// comma separated list of required fields
$_REQUEST['ff_required'] = '';
$_REQUEST['ff_required_labels'] = '';

$filter = '';

if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }
    $filter .= '&amp;test_id='.$test_id.'';
} else {
    $test_id = 0;
}
if (isset($_REQUEST['testuser_id'])) {
    $testuser_id = intval($_REQUEST['testuser_id']);
    $filter .= '&amp;testuser_id='.$testuser_id;
} else {
    $testuser_id = 0;
}
if (isset($_REQUEST['user_id'])) {
    $user_id = intval($_REQUEST['user_id']);
    //if (!F_isAuthorizedEditorForUser($user_id)) {
    //	F_print_error('ERROR', $l['m_authorization_denied'], true);
    //}
    $filter .= '&amp;user_id='.$user_id;
} else {
    $user_id = 0;
}
if (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
}

if (isset($_POST['lock'])) {
    $menu_mode = 'lock';
} elseif (isset($_POST['unlock'])) {
    $menu_mode = 'unlock';
} elseif (isset($_POST['extendtime'])) {
    $menu_mode = 'extendtime';
}

switch ($menu_mode) {
    case 'delete':{
        F_stripslashes_formfields();
        // ask confirmation
        F_print_error('WARNING', $l['m_delete_confirm']);
        echo '<div class="confirmbox">'.K_NEWLINE;
        echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_delete">'.K_NEWLINE;
        echo '<div>'.K_NEWLINE;
        echo '<input type="hidden" name="testuser_id" id="testuser_id" value="'.$testuser_id.'" />'.K_NEWLINE;
        F_submit_button('forcedelete', $l['w_delete'], $l['h_delete']);
        F_submit_button('cancel', $l['w_cancel'], $l['h_cancel']);
        echo '</div>'.K_NEWLINE;
        echo F_getCSRFTokenField().K_NEWLINE;
        echo '</form>'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields(); // Delete
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
                $sql = 'DELETE FROM '.K_TABLE_TEST_USER.'
					WHERE testuser_id='.$testuser_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error();
            } else {
                $testuser_id = false;
                F_print_error('MESSAGE', $l['m_deleted']);
            }
        }
        break;
    }

    case 'extendtime':{
        // extend the test time by 5 minutes
        // this time extension is obtained moving forward the test starting time
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_creation_time=\''.date(K_TIMESTAMP_FORMAT, F_getTestStartTime($testuser_id) + (K_EXTEND_TIME_MINUTES * K_SECONDS_IN_MINUTE)).'\'
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'lock':{
        // update test mode to 4 = test locked
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_status=4
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'unlock':{
        // update test mode to 1 = test unlocked
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_status=1
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    default: {
        break;
    }
} //end of switch

// --- Initialize variables

if (($test_id == 0) and ($testuser_id == 0)) {
    // select default test ID
    $sql = F_select_executed_tests_sql().' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $test_id = $m['test_id'];
        }
    } else {
        F_display_db_error();
    }
}

if ($formstatus) {
    if ((isset($changecategory) and ($changecategory > 0)) or empty($testuser_id)) {
            $sql = 'SELECT testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status, SUM(testlog_score) AS test_score, MAX(testlog_change_time) AS test_end_time
				FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
				WHERE testlog_testuser_id=testuser_id
					AND testuser_test_id='.$test_id.'
					AND testuser_status>0
				GROUP BY testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status
				ORDER BY testuser_test_id
				LIMIT 1';
    } else {
        $sql = 'SELECT testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status, MAX(testlog_change_time) AS test_end_time
			FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
			WHERE testlog_testuser_id=testuser_id
				AND testuser_id='.$testuser_id.'
				AND testuser_status>0
			GROUP BY testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status
			LIMIT 1';
    }
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $testuser_id = $m['testuser_id'];
            $test_id = $m['testuser_test_id'];
            $user_id = $m['testuser_user_id'];
            $test_start_time = $m['testuser_creation_time'];
            $testuser_status = $m['testuser_status'];
            $teststat = F_getTestStat($test_id, 0, $user_id, 0, 0, $testuser_id);
            $test_end_time = $m['test_end_time'];
        } else {
            $testuser_id = '';
            $test_id = '';
            $user_id = '';
            $test_start_time = '';
            $test_end_time = '';
            $testuser_status = 0;
        }
    } else {
        F_display_db_error();
    }
}

// get test basic score
$test_basic_score = 1;
$sql = 'SELECT test_score_right, test_duration_time	FROM '.K_TABLE_TESTS.' WHERE test_id='.intval($test_id).'';
if ($r = F_db_query($sql, $db)) {
    if ($m = F_db_fetch_array($r)) {
        $test_basic_score = $m['test_score_right'];
        $test_duration_time = $m['test_duration_time'];
    }
} else {
    F_display_db_error();
}
?>
<style>
	
	#print-header, #hr-print-header{
		display: none;
	}
	@media print{
		#print-header, #hr-print-header{display:unset !important}
	}
</style>
<?php
echo '<div class="card mb-3">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;

require_once('../../shared/code/tmf_print_header.php');

echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_resultuser">'.K_NEWLINE;
echo '<div id="headerSum">'.K_NEWLINE;
echo '<div class="input-group rowlll print-hidden d-print-none">'.K_NEWLINE;
echo '<div class="label input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="test_id">Pilih '.$l['w_test'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="testuser_id" id="testuser_id" value="'.$testuser_id.'" />'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
echo '<select class="form-control custom-select select2-single" name="test_id" id="test_id" size="0" onchange="document.getElementById(\'form_resultuser\').changecategory.value=1;document.getElementById(\'form_resultuser\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
$sql = F_select_executed_tests_sql();
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['test_id'].'"';
        if ($m['test_id'] == $test_id) {
            echo ' selected="selected"';
        }
        echo '>'.substr($m['test_begin_time'], 0, 10).' '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
		$testname = $m['test_name'];
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_tests_popup.php?cid=test_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');


echo '<div class="rowlll print-hidden d-print-none mt-3">'.K_NEWLINE;
echo '<div class="">'.K_NEWLINE;
echo '<label class="text-capitalize mb-0" for="testuser_id">Pilih '.$l['w_user'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<select class="form-control custom-select select2-single" name="testuser_id" id="testuser_id" size="0" onchange="document.getElementById(\'form_resultuser\').submit()" title="'.$l['h_select_user'].'">'.K_NEWLINE;
$sql = 'SELECT testuser_id, user_lastname, user_firstname, user_name, testuser_creation_time FROM '.K_TABLE_TEST_USER.', '.K_TABLE_USERS.' WHERE testuser_user_id=user_id AND testuser_test_id='.intval($test_id).'';
$sql .= ' ORDER BY user_lastname, user_firstname, user_name, testuser_creation_time DESC';
if ($r = F_db_query($sql, $db)) {
    $usrcount = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['testuser_id'].'"';
        if ($m['testuser_id'] == $testuser_id) {
            echo ' selected="selected"';
        }
        echo '>';
        echo ''.$usrcount.'. ';
        echo ''.htmlspecialchars($m['user_lastname'].' '.$m['user_firstname'].' - '.$m['user_name'].' ['.$m['testuser_creation_time'].']', ENT_NOQUOTES, $l['a_meta_charset']).'';
		$username = $m['user_name'];
		$user_firstname = $m['user_firstname'];
        echo '</option>'.K_NEWLINE;
        $usrcount++;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


if(isset($testname)){
	echo '<hr/><div id="testname_print" class="my-2">'.K_NEWLINE;
	echo '<div class="rowlll">'.K_NEWLINE;
	echo '<div>Nama '.$l['w_test'].K_NEWLINE;
	echo '<span class="formw testname badge badge-primary d-print-none">'.$testname.K_NEWLINE;
	echo '</span>'.K_NEWLINE;
	echo '<span class="formw testname d-none d-print-inline"> : '.$testname.K_NEWLINE;
	echo '</span>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
}

if(isset($username)){
	echo '<div id="username_print">'.K_NEWLINE;
	echo '<div class="rowlll">'.K_NEWLINE;
	// echo '<span class="label">'.K_NEWLINE;
	echo '<span>'.$l['w_user'].' <span class="d-none d-print-inline">:</span></span>'.K_NEWLINE;
	// echo '</span>'.K_NEWLINE;
	echo '<span class="formw username badge badge-alternate d-print-none">'.$username.' ('.$user_firstname.')'.K_NEWLINE;
	echo '</span>'.K_NEWLINE;
	echo '<span class="formw username d-none d-print-inline">'.$username.' ('.$user_firstname.')'.K_NEWLINE;
	echo '</span>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
}

echo getFormNoscriptSelect('selectrecord');

echo '<div class="rowlll"><hr /></div>'.K_NEWLINE;

if (isset($teststat) and !empty($teststat)) {
    $teststat['testinfo'] = F_getUserTestStat($test_id, $user_id, $testuser_id);
    
    echo '<div class="rowlll">'.K_NEWLINE;
    echo '<span class="label">'.K_NEWLINE;
    echo '<span title="'.$l['h_time_begin'].'">'.$l['w_time_begin'].' <span class="d-none d-print-inline">:</span> </span>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '<span class="formw">'.K_NEWLINE;
    echo '<span class="d-print-none badge badge-success">'.$test_start_time.'</span> ';
    echo '<span class="d-none d-print-inline">'.$test_start_time.'</span> ';
    if (isset($test_id) and ($test_id > 0) and isset($user_id) and ($user_id > 0)) {
        F_submit_button_alt('extendtime', '+'.K_EXTEND_TIME_MINUTES.' min', $l['h_add_five_minutes'], 'btn btn-primary btn-sm d-print-none');
    }
    // echo '&nbsp;'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;

    echo getFormDescriptionLine_alt($l['w_time_end'].' :', $l['h_time_end'], $test_end_time, 'd-none d-print-inline');
	
	echo getFormDescriptionLine_alt2($l['w_time_end'].' ', $l['h_time_end'], $test_end_time, 'd-print-none', 'badge badge-danger');

    if (!isset($test_end_time) or ($test_end_time <= 0) or (strtotime($test_end_time) < strtotime($test_start_time))) {
        $time_diff = $test_duration_time * 60;
    } else {
        $time_diff = strtotime($test_end_time) - strtotime($test_start_time); //sec
    }
    $time_diff = gmdate('H:i:s', $time_diff);
	
    echo getFormDescriptionLine_alt($l['w_test_time'].' :', $l['w_test_time'], $time_diff, 'd-none d-print-inline');
	
	echo getFormDescriptionLine_alt2($l['w_test_time'].' ', $l['w_test_time'], $time_diff, 'd-print-none', 'badge badge-primary');
	
    $passmsg = '';
    if ($teststat['testinfo']['test_score_threshold'] > 0) {
        if (isset($teststat['testinfo']['user_score']) and ($teststat['testinfo']['user_score'] >= $teststat['testinfo']['test_score_threshold'])) {
            $passmsg = ' - '.$l['w_passed'];
        } else {
            $passmsg = ' - '.$l['w_not_passed'];
        }
    }
    if ($teststat['testinfo']['test_max_score'] > 0) {
        $score_all = $teststat['testinfo']['user_score'].' / '.$teststat['testinfo']['test_max_score'].' ('.round(100 * $teststat['testinfo']['user_score'] / $teststat['testinfo']['test_max_score']).'%)';
    } else {
        $score_all = $teststat['testinfo']['user_score'];
    }
    echo getFormDescriptionLine_alt($l['w_score'].' :', $l['h_score_total'], $score_all.$passmsg, 'd-none d-print-inline');
	
    echo getFormDescriptionLine_alt2($l['w_score'].' ', $l['h_score_total'], $score_all.$passmsg, 'd-print-none', 'badge badge-dark');

    $score_right_all = $teststat['qstats']['right'].' / '.$teststat['qstats']['recurrence'].' ('.$teststat['qstats']['right_perc'].'%)';
    echo getFormDescriptionLine_alt($l['w_answers_right'].' :', $l['h_answers_right'], $score_right_all, 'd-none d-print-inline');
	
    echo getFormDescriptionLine_alt2($l['w_answers_right'].' ', $l['h_answers_right'], $score_right_all, 'd-print-none', 'badge badge-success');
	
	 $score_wrong_all = $teststat['qstats']['wrong'].' / '.$teststat['qstats']['recurrence'].' ('.$teststat['qstats']['wrong_perc'].'%)';
    echo getFormDescriptionLine_alt($l['w_answers_wrong'].' :', $l['h_answers_wrong'], $score_wrong_all, 'd-none d-print-inline');
    
	echo getFormDescriptionLine_alt2($l['w_answers_wrong'].' ', $l['h_answers_wrong'], $score_wrong_all, 'd-print-none', 'badge badge-danger');

    $score_unanswered_all = $teststat['qstats']['unanswered'].' / '.$teststat['qstats']['recurrence'].' ('.$teststat['qstats']['unanswered_perc'].'%)';
    echo getFormDescriptionLine_alt($l['w_questions_unanswered'].' :', $l['h_questions_unanswered'], $score_unanswered_all, 'd-none d-print-inline');
    echo getFormDescriptionLine_alt2($l['w_questions_unanswered'].' ', $l['h_questions_unanswered'], $score_unanswered_all, 'd-print-none', 'badge badge-secondary');

    $score_undisplayed_all = $teststat['qstats']['undisplayed'].' / '.$teststat['qstats']['recurrence'].' ('.$teststat['qstats']['undisplayed_perc'].'%)';
    echo getFormDescriptionLine_alt($l['w_questions_undisplayed'].' :', $l['h_questions_undisplayed'], $score_undisplayed_all, 'd-none d-print-inline');
    echo getFormDescriptionLine_alt2($l['w_questions_undisplayed'].' ', $l['h_questions_undisplayed'], $score_undisplayed_all, 'd-print-none', 'badge badge-secondary');

    $score_unrated_all = $teststat['qstats']['unrated'].' / '.$teststat['qstats']['recurrence'].' ('.$teststat['qstats']['unrated_perc'].'%)';
    echo getFormDescriptionLine_alt($l['w_questions_unrated'].' :', $l['h_questions_unrated'], $score_unrated_all, 'd-none d-print-inline');
    echo getFormDescriptionLine_alt2($l['w_questions_unrated'].' ', $l['h_questions_unrated'], $score_unrated_all, 'd-print-none', 'badge badge-secondary');
	
    echo getFormDescriptionLine_alt($l['w_comment'].' :', $l['h_testcomment'], F_decode_tcecode($teststat['testinfo']['user_comment']), 'd-none d-print-inline');
	
	if(strlen(F_decode_tcecode($teststat['testinfo']['user_comment']))>0){
		echo getFormDescriptionLine_alt2($l['w_comment'].' ', $l['h_testcomment'], F_decode_tcecode($teststat['testinfo']['user_comment']), 'd-print-none', 'badge badge-secondary');
	}else{
		echo getFormDescriptionLine_alt2($l['w_comment'].' ', $l['h_testcomment'], ' - ', 'd-print-none', 'badge badge-secondary');
	}
	
	echo '</div>'.K_NEWLINE;
    if (isset($testuser_id) and !empty($testuser_id) and !empty($teststat)) {
        echo '<div class="rowllll">'.K_NEWLINE;
        echo F_printUserTestStat($testuser_id);
        echo '</div>'.K_NEWLINE;

        // print statistics for modules and subjects
        echo '<div class="rowllll" id="row-stat">'.K_NEWLINE;
        // echo '<hr />'.K_NEWLINE;
        echo '<h5 class="text-capitalize mt-3">'.$l['w_stats'].'</h5>';
        echo F_printTestStat($test_id, 0, $user_id, 0, 0, $testuser_id, $teststat, 2);
        // echo '<hr />'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
    }
	echo '</div>';
    echo '<div class="rowlll d-print-none card-footer flex-wrap justify-content-center" id="btn-action">'.K_NEWLINE;

    // show buttons by case
    if (($test_id > 0) and ($user_id > 0) and ($testuser_id > 0)) {
        F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], 'btn btn-danger m-1');

        if ($testuser_status < 4) {
            // lock test button
            F_submit_button_alt('lock', $l['w_lock'], $l['w_lock'], 'btn btn-dark m-1');
        } else {
            // unlock test button
            F_submit_button_alt('unlock', $l['w_unlock'], $l['w_unlock'], 'btn btn-outline-light m-1');
			// echo '<br /><br />';
			// echo '<div class="d-block">'.K_NEWLINE;
            echo '<a href="tce_pdf_results.php?mode=3'.$filter.'" class="xmlbutton btn btn-danger m-1" title="'.$l['h_pdf'].'"><i class="fa fa-file-pdf"></i>&nbsp;'.$l['w_pdf'].'</a> ';
            echo '<a href="tce_email_results.php?mode=1&amp;menu_mode=startlongprocess'.$filter.'" class="xmlbutton btn btn-primary m-1" title="'.$l['h_email_result'].'"><i class="fa fa-mail-bulk"></i>&nbsp;'.$l['w_email_result'].'</a> ';
            echo '<a href="tce_email_results.php?mode=0&amp;menu_mode=startlongprocess'.$filter.'" class="xmlbutton btn btn-info m-1" title="'.$l['h_email_result'].' + PDF"><i class="fa fa-mail-bulk"></i><i class="fa fa-file-pdf"></i>&nbsp;'.$l['w_email_result'].' + PDF</a> ';
			// echo '</div>'.K_NEWLINE;
        }

/*         echo '<br /><br />';
		echo '<div class="d-block">'.K_NEWLINE;
		echo '<a name="print" href="#print" class="xmlbutton" title="'.$l['b_print'].'" onclick="window.print()">'.$l['b_print'].'</a> ';
        echo '<a href="tce_pdf_results.php?mode=3'.$filter.'" class="xmlbutton" title="'.$l['h_pdf'].'">'.$l['w_pdf'].'</a> ';
        echo '<a href="tce_email_results.php?mode=1&amp;menu_mode=startlongprocess'.$filter.'" class="xmlbutton" title="'.$l['h_email_result'].'">'.$l['w_email_result'].'</a> ';
        echo '<a href="tce_email_results.php?mode=0&amp;menu_mode=startlongprocess'.$filter.'" class="xmlbutton" title="'.$l['h_email_result'].' + PDF">'.$l['w_email_result'].' + PDF</a> ';
		echo '</div>'.K_NEWLINE; */
    }

    echo '</div>'.K_NEWLINE;
}
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

// echo '<div class="pagehelp">'.$l['hp_result_user'].'</div><br/>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');
?>
<script>
$str2 = $("ol.question").html();


// The array of regex patterns to look for
$format_search =  [
    /\[img\](.*?)\[\/img\]/ig,
	/\[b\](.*?)\[\/b\]/ig,
    /\[i\](.*?)\[\/i\]/ig,
    /\[u\](.*?)\[\/u\]/ig
]; // note: NO comma after the last entry

// The matching array of strings to replace matches with
$format_replace = [
    '<img src="$1" />',
	'<strong>$1</strong>',
    '<em>$1</em>',
    '<span style="text-decoration: underline;">$1</span>'
];

// Perform the actual conversion
for (var i =0;i<$format_search.length;i++) {
  $str2 = $str2.replace($format_search[i], $format_replace[i]);
}
$("ol.question").html($str2);
</script>

<?php
//============================================================+
// END OF FILE
//============================================================+
