<?php
//============================================================+
// File name   : tce_show_result_allusers.php
// Begin       : 2004-06-10
// Last Update : 2020-05-06
//
// Description : Display test results summary for all users.
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
//    Copyright (C) 2004-2020 Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display test results summary for all users.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2004-06-10
 */

/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_result_all_users'];
$thispage_title_icon = '<i class="pe-7s-cup icon-gradient bg-love-kiss"></i>';

$enable_calendar = true;
require_once('tce_page_header.php');
echo '<link href="../../shared/jscripts/vendor/dropzonejs/dropzone.css" rel="stylesheet">'.K_NEWLINE;
echo '<script src="../../shared/jscripts/vendor/dropzonejs/dropzone.js"></script>'.K_NEWLINE;
// echo '<style>'.K_NEWLINE;
// echo '.dropzone{border: 2px dashed rgba(0, 0, 0, 0.3);border-radius:10px}';
// echo '</style>'.K_NEWLINE;
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../../shared/code/tce_functions_test_stats.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('../../shared/code/tce_functions_statistics.php');
require_once('tce_functions_user_select.php');

// comma separated list of required fields
$_REQUEST['ff_required'] = '';
$_REQUEST['ff_required_labels'] = '';

$filter = 'sel=1';

if (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
}
if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }
    $filter .= '&amp;test_id='.$test_id.'';
    $test_group_ids = F_getTestGroups($test_id);
	// $hiddenclass='';
} else {
    $test_id = 0;
	// $hiddenclass = 'style="display:none!important"';
}
if (isset($_REQUEST['user_id'])) {
    $user_id = intval($_REQUEST['user_id']);
    $filter .= '&amp;user_id='.$user_id;
} else {
    $user_id = 0;
}
if (isset($_REQUEST['group_id']) and !empty($_REQUEST['group_id'])) {
    $group_id = intval($_REQUEST['group_id']);
    $filter .= '&amp;group_id='.$group_id.'';
} else {
    $group_id = 0;
}
// filtering options
if (isset($_REQUEST['startdate'])) {
    $startdate = $_REQUEST['startdate'];
    $startdate_time = strtotime($startdate);
    $startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
} else {
    $startdate = date('Y').'-01-01 00:00:00';
}
$filter .= '&amp;startdate='.urlencode($startdate);
if (isset($_REQUEST['enddate'])) {
    $enddate = $_REQUEST['enddate'];
    $enddate_time = strtotime($enddate);
    $enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
} else {
    $enddate = date('Y').'-12-31 23:59:59';
}
$filter .= '&amp;enddate='.urlencode($enddate).'';

$detail_modes = array($l['w_disabled'], $l['w_minimum'], $l['w_module'], $l['w_subject'], $l['w_question'], $l['w_answer']);
if (isset($_REQUEST['display_mode'])) {
    $display_mode = max(0, min(5, intval($_REQUEST['display_mode'])));
    $filter .= '&amp;display_mode='.$display_mode;
} else {
    $display_mode = 0;
}
$filter .= '&amp;display_mode='.$display_mode;

if (isset($_REQUEST['show_graph'])) {
    $show_graph = intval($_REQUEST['show_graph']);
    $filter .= '&amp;show_graph='.$show_graph;
    if ($show_graph and ($display_mode == 0)) {
        $display_mode = 1;
    }
} else {
    $show_graph = 0;
}

if (isset($_POST['lock'])) {
    $menu_mode = 'lock';
} elseif (isset($_POST['unlock'])) {
    $menu_mode = 'unlock';
} elseif (isset($_POST['extendtime'])) {
    $menu_mode = 'extendtime';
} elseif (isset($_POST['regrade'])) { //tmfajax mod
    $menu_mode = 'regrade';
} 
/* elseif (isset($_POST['download'])) {
    $menu_mode = 'download';
} */

if (isset($_REQUEST['order_field']) and !empty($_REQUEST['order_field']) and (in_array($_REQUEST['order_field'], array('testuser_creation_time', 'testuser_end_time', 'user_name', 'user_lastname', 'user_firstname', 'total_score', 'testuser_test_id')))) {
    $order_field = $_REQUEST['order_field'];
} else {
    $order_field = 'total_score, user_lastname, user_firstname';
}
$filter .= '&amp;order_field='.urlencode($order_field).'';
if (!isset($_REQUEST['orderdir']) or empty($_REQUEST['orderdir'])) {
    $orderdir = 0;
    $nextorderdir = 1;
    $full_order_field = $order_field;
} else {
    $orderdir = 1;
    $nextorderdir = 0;
    $full_order_field = $order_field.' DESC';
}
$filter .= '&amp;orderdir='.$orderdir.'';

if (isset($menu_mode) and (!empty($menu_mode))) {
    for ($i = 1; $i <= $itemcount; $i++) {
        // for each selected item
        $keyname = 'testuserid'.$i;
        if (isset($$keyname)) {
            $testuser_id = $$keyname;
            switch ($menu_mode) {
				/* case 'download':{
					// echo $testuser_id;
					$sqldl = 'SELECT testuser_test_id, testuser_user_id FROM '.K_TABLE_TEST_USER.'
						WHERE testuser_id='.$testuser_id.' LIMIT 1';
					// echo $sqldl;	
                    if ($rdl = F_db_query($sqldl, $db)) {
						if ($mdl = F_db_fetch_array($rdl)) {
							// echo $testuser_id.' - '.$mdl['testuser_test_id'].' - '.$mdl['testuser_user_id'];
							
							echo '<script>';
							echo '	location.replace("tmf_show_offline_sheet.php?testuser_id='.$testuser_id.'&test_id='.$mdl['testuser_test_id'].'&user_id='.$mdl['testuser_user_id'].'");';
							echo '</script>';
							// sleep(1);
							
						}
					}
					
                    // echo $testuser_id.' - '.$test_id.' - '.$user_id;
					// header('Location:index.php');
					
                    break;
                } */
                case 'delete':{
                    $sql = 'DELETE FROM '.K_TABLE_TEST_USER.'
						WHERE testuser_id='.$testuser_id.'';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error();
                    }
                    break;
                }
                case 'extendtime':{
                    // extend the test time by 5 minutes
                    // this time extension is obtained moving forward the test starting time
                    $extseconds = K_EXTEND_TIME_MINUTES * K_SECONDS_IN_MINUTE;
                    $sqlus = 'SELECT testuser_creation_time
						FROM '.K_TABLE_TEST_USER.'
						WHERE testuser_id='.$testuser_id.'
						LIMIT 1';
                    if ($rus = F_db_query($sqlus, $db)) {
                        if ($mus = F_db_fetch_array($rus)) {
                            $newstarttime = date(K_TIMESTAMP_FORMAT, strtotime($mus['testuser_creation_time']) + $extseconds);
                            $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
								SET testuser_creation_time=\''.$newstarttime.'\'
								WHERE testuser_id='.$testuser_id.'';
                            if (!$ru = F_db_query($sqlu, $db)) {
                                F_display_db_error();
                            }
                        }
                    } else {
                        F_display_db_error();
                    }
                    break;
                }
				case 'regrade':{
			// regrade user score if answer key changed
			$sqltl = 'SELECT testlog_id,testlog_question_id,testlog_answer_text FROM '.K_TABLE_TESTS_LOGS.' WHERE testlog_testuser_id='.$testuser_id;
			if($rtl = F_db_query($sqltl, $db)){
				while($mtl = F_db_fetch_array($rtl)){
					$sqlsa = 'SELECT logansw_order FROM '.K_TABLE_LOG_ANSWER.' WHERE logansw_testlog_id='.$mtl[0].' AND logansw_selected=1 LIMIT 1';
					$sqlqt = 'SELECT question_type FROM '.K_TABLE_QUESTIONS.' WHERE question_id='.$mtl[1].' LIMIT 1';
					if($rqt = F_db_query($sqlqt, $db)){
						if($mqt = F_db_fetch_array($rqt)){
							if($mqt[0]==1){
								$sqlsa = 'SELECT logansw_order FROM '.K_TABLE_LOG_ANSWER.' WHERE logansw_testlog_id='.$mtl[0].' AND logansw_selected=1 LIMIT 1';
								if($rsa = F_db_query($sqlsa, $db)){
									if($msa = F_db_fetch_array($rsa)){
										F_updateQuestionLogRegrade($test_id, $mtl[0], array($msa[0]=>1), '', 0);
									}
								}
							}elseif($mqt[0]==2){
								$sqlsa = 'SELECT logansw_selected, logansw_order FROM '.K_TABLE_LOG_ANSWER.' WHERE logansw_testlog_id='.$mtl[0].' ORDER BY logansw_answer_id ASC';
								if($rsa = F_db_query($sqlsa, $db)){
									$arraysa2=array();
									while($msa = F_db_fetch_array($rsa)){
										$arraysa2 += array($msa[1]=>$msa[0]);
									}
									F_updateQuestionLogRegrade($test_id, $mtl[0], $arraysa2, '', 0);
								}
							}elseif($mqt[0]==3){
								F_updateQuestionLogRegrade($test_id, $mtl[0], array(), $mtl[2], 0);
							}elseif($mqt[0]==4){
								$sqlsa = 'SELECT logansw_order, logansw_position FROM '.K_TABLE_LOG_ANSWER.' WHERE logansw_testlog_id='.$mtl[0].' ORDER BY logansw_answer_id ASC';
								if($rsa = F_db_query($sqlsa, $db)){
									$arraysa4=array();
									while($msa = F_db_fetch_array($rsa)){
										$arraysa4 += array($msa[0]=>$msa[1]);
									}
									//print_r($arraysa4);
									F_updateQuestionLogRegrade($test_id, $mtl[0], $arraysa4, '', 0);
									//echo "F_updateQuestionLogRegrade(".$test_id.", ".$mtl[0].", ".$arraysa4.", '', 0, '');";
								}
							}
						}
					}
				}
			}
			break;
                }
                case 'lock':{
                    // update test mode to 4 = test locked
                    $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
						SET testuser_status=4
						WHERE testuser_id='.$testuser_id.'
						AND testuser_status<4';
                    if (!$ru = F_db_query($sqlu, $db)) {
                        F_display_db_error();
                    }
                    break;
                }
                case 'unlock':{
                    // update test mode to 1 = test unlocked
                    $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
						SET testuser_status=1
						WHERE testuser_id='.$testuser_id.'
						AND testuser_status<5';
                    if (!$ru = F_db_query($sqlu, $db)) {
                        F_display_db_error();
                    }
                    break;
                }
            } //end of switch
        }
    }
    F_print_error('MESSAGE', $l['m_updated']);
}

echo '<div class="card">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;

echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_resultallusers">'.K_NEWLINE;
echo '<div class="rowlll mb-2">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_id">Pilih '.$l['w_test'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
//echo '<select name="test_id" id="test_id" size="0" onchange="document.getElementById(\'form_resultallusers\').changecategory.value=1; document.getElementById(\'form_resultallusers\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="test_id" id="test_id" size="0" title="Pilih '.$l['h_test'].'">'.K_NEWLINE;
$sql = F_select_executed_tests_sql();
if ($r = F_db_query($sql, $db)) {
    echo '<option value="0"';
    if ($test_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['test_id'].'"';
        if ($m['test_id'] == $test_id) {
            echo ' selected="selected"';
        }
        echo '>'.substr($m['test_begin_time'], 0, 10).' '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_tests_popup.php?cid=test_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo '<div class="form-row">'.K_NEWLINE;
echo '<div class="col-md-5">'.K_NEWLINE;
echo getFormRowTextInput('startdate', $l['w_time_begin'], $l['w_time_begin'].' '.$l['w_datetime_format'], '', $startdate, '', 19, false, false, 'datetime-local', '', false);
echo '</div>'.K_NEWLINE;

echo '<div class="col-md-1">'.K_NEWLINE;
// echo getFormRowTextInput('dummy1', '&nbsp;', '', '', $startdate, '', 19, false, false, 'datetime-local', '', false);
echo '<div class="position-relative form-group">
<label>&nbsp;</label>
<button type="button" class="form-control" title="Ke awal waktu" data-toggle="tooltip" onclick="document.getElementById(\'startdate\').value = &quot;0001-01-01T00:00&quot;;document.getElementById(\'form_resultallusers\').submit()"><i class="pe-7s-refresh-2"></i></button>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('enddate', $l['w_time_end'], $l['w_time_end'].' '.$l['w_datetime_format'], '', $enddate, '', 19, false, false, 'datetime-local', '', false);
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="form-row">'.K_NEWLINE;
echo '<div class="col-md-6">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="group_id">Pilih '.$l['w_group'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
//echo '<select name="group_id" id="group_id" size="0" onchange="document.getElementById(\'form_resultallusers\').submit()">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="group_id" id="group_id" size="0">'.K_NEWLINE;
$sql = 'SELECT * FROM '.K_TABLE_GROUPS.'';
if ($test_id > 0) {
    $sql .= ' WHERE group_id IN ('.$test_group_ids.')';
}
$sql .= ' ORDER BY group_name';
if ($r = F_db_query($sql, $db)) {
    echo '<option value="0"';
    if ($group_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['group_id'].'"';
        if ($m['group_id'] == $group_id) {
            echo ' selected="selected"';
        }
        echo '>'.htmlspecialchars($m['group_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    echo '</select></span></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectgroup');

echo '<div class="col-md-6">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="user_id">Pilih '.$l['w_user'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
//echo '<select name="user_id" id="user_id" size="0" onchange="document.getElementById(\'form_resultallusers\').submit()">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="user_id" id="user_id" size="0">'.K_NEWLINE;
$sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.'';
if ($test_id > 0) {
    $sql .= ', '.K_TABLE_TEST_USER.' WHERE testuser_user_id=user_id AND testuser_test_id='.$test_id.'';
} elseif ($group_id > 0) {
    $sql .= ', '.K_TABLE_USERGROUP.' WHERE usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.' AND user_id>1';
} else {
    $sql .= ' WHERE user_id>1';
}
$sql .= ' GROUP BY user_id, user_lastname, user_firstname, user_name ORDER BY user_lastname, user_firstname, user_name';
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    echo '<option value="0"';
    if ($user_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['user_id'].'"';
        if ($m['user_id'] == $user_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. '.htmlspecialchars($m['user_lastname'].' '.$m['user_firstname'].' - '.$m['user_name'].'', ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
} else {
    echo '</select></span></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_users_popup.php?cid=user_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="rowlll my-2">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="display_mode">'.$l['w_stats'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<select class="form-control" name="display_mode" id="display_mode" size="0" title="'.$l['w_mode'].'">'.K_NEWLINE;
foreach ($detail_modes as $key => $dmode) {
    echo '<option value="'.$key.'"';
    if ($key == $display_mode) {
        echo ' selected="selected"';
    }
    echo '>'.htmlspecialchars($dmode, ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('display_mode');

echo getFormRowCheckBox('show_graph', $l['w_graph'], $l['w_result_graph'], '', 1, $show_graph, false, '');

echo '</div>'.K_NEWLINE;
echo '<div class="card-footer">'.K_NEWLINE;
echo '<div class="formw">'.K_NEWLINE;
echo '<input class="btn btn-primary btn-block" type="submit" name="selectcategory" id="selectcategory" value="'.$l['w_select'].'" />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// ---------------------------------------------------------------------
$itemcount = 0;
if (isset($_REQUEST['sel'])) {
    $data = F_getAllUsersTestStat($test_id, $group_id, $user_id, $startdate, $enddate, $full_order_field, false, $display_mode);
	
    if (isset($data['num_records'])) {
        $itemcount = $data['num_records'];
    }

    echo '<div class="card mt-3">'.K_NEWLINE;

    echo F_printTestResultStat($data, $nextorderdir, $order_field, $filter, false, $display_mode);

    if (!empty($data['testuser'])) {
        // check/uncheck all options
		echo '<div class="border-top form-row p-3" style="border-top-width:0.25em !important">';
        echo '<div class="position-relative custom-radio custom-control mr-3"><input type="radio" class="custom-control-input" name="checkall" id="checkall1" value="1" onclick="checkAll(\'table#test_result_users tbody tr td input[type=checkbox]\')" />';
        echo '<label class="custom-control-label" for="checkall1">'.$l['w_check_all'].'</label> ';
		echo '</div>';
		echo '<div class="position-relative custom-radio custom-control mr-3">';
        echo '<input class="custom-control-input" type="radio" name="checkall" id="checkall0" value="0" onclick="unCheckAll(\'table#test_result_users tbody tr td input[type=checkbox]\')" />';
        echo '<label for="checkall0" class="custom-control-label">'.$l['w_uncheck_all'].'</label>';
        echo '</div>'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
        echo '<strong class="px-3">'.$l['m_with_selected'].'</strong>'.K_NEWLINE;
		
		echo '<div class="form-row px-3 pt-2 pb-3">';
		F_submit_button_confirm('regrade', 'Regrade', 'Regrade', 'style="display:none" class="mr-1"');
		F_submit_button_confirm('regradebtn', 'Regrade', 'Regrade', 'onclick="event.preventDefault();var cbArr = document.querySelectorAll(\'table#test_result_users tbody tr td input[type=checkbox]:checked\');if(document.getElementById(\'test_id\').selectedIndex == 0){alert(\'Pilih nama test/ujian terlebih dahulu\')}else{if(cbArr.length==0){alert(\'Harap pilih hasil ujian peserta terlebih dahulu!\')}else{document.getElementById(\'regrade\').click()}}" class="btn btn-success mr-1"');
        F_submit_button_confirm('delete', $l['w_delete'], $l['h_delete'], 'onclick="return confirm(\''.$l['m_delete_confirm'].'\')" class="btn btn-danger mr-1"');
        
        F_submit_button_alt('lock', $l['w_lock'], $l['w_lock'], 'btn btn-warning mr-1');
        F_submit_button_alt('unlock', $l['w_unlock'], $l['w_unlock'], 'btn btn-light mr-1');
        F_submit_button_alt('extendtime', '+'.K_EXTEND_TIME_MINUTES.' min', $l['h_add_five_minutes'], 'btn btn-alternate');
		echo '</div>';

    }

    echo '</div>'.K_NEWLINE;

    // display svg graph
    if ($show_graph and isset($data['svgpoints']) and (preg_match_all('/[x]/', $data['svgpoints'], $match) > 1)) {
        $w = 800;
        $h = 300;
        echo '<div class="rowlll">'.K_NEWLINE;
        echo '<hr />'.K_NEWLINE;
        // legend
        echo '<div style="font-size:90%;"><br /><span style="background-color:#ff0000;color:#ffffff;">&nbsp;'.$l['w_score'].'&nbsp;</span> <span style="background-color:#0000ff;color:#ffffff;">&nbsp;'.$l['w_answers_right'].'&nbsp;</span> / <span style="background-color:#dddddd;color:#000000;">&nbsp;'.$l['w_tests'].'&nbsp;</span></div>';
        echo '<img src="../../shared/code/tce_svg_graph.php?w='.$w.'&amp;h='.$h.'&amp;p='.substr($data['svgpoints'], 1).'" width="'.$w.'" height="'.$h.'" alt="'.$l['w_result_graph'].'" />'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
    }

    if ($display_mode > 1) {
        // display statistics for modules, subjects, questions and answers
        echo '<div class="rowl">'.K_NEWLINE;
        echo F_printTestStat($test_id, $group_id, $user_id, $startdate, $enddate, 0, $data, $display_mode);
        echo '<br />'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
    }

    
}

echo '<input type="hidden" name="sel" id="sel" value="1" />'.K_NEWLINE;
echo '<input type="hidden" name="order_field" id="order_field" value="'.$order_field.'" />'.K_NEWLINE;
echo '<input type="hidden" name="orderdir" id="orderdir" value="'.$orderdir.'" />'.K_NEWLINE;
echo '<input type="hidden" name="itemcount" id="itemcount" value="'.$itemcount.'>" />'.K_NEWLINE;
// echo 'XXX';
/* echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
 */

// echo '</div>';

// echo '<div class="d-block" '.$hiddenclass.'>';
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '<div class="card mt-3">';

?>
<div class="card-header">
<h5 id="judul-koreksi-offline" class="m-0" style="cursor:pointer"><i class="pe-7s-note"></i>&nbsp;Koreksi Offline</h5>
</div>
<div class="card-body">
<div>


<div id="area-koreksi-offline" style="display:none">
<div class="rowlll border-top-0 border-right-0 border-bottom-0 alert alert-light" style="border-left-width:0.25em !important">
<span class="label font-weight-bold"><label id="data_jawabanlbl" for="data_jawabantxt">Data Jawaban</label></span>
<span><textarea class="form-control mb-2" (paste)="util.removeNewlines($event, control)" id="data_jawabantxt"></textarea><span class="ta-right">Masukkan data jawaban peserta yang berupa teks ke dalam kotak di atas, pisahkan data jawaban satu dengan lainnya menggunakan tanda koma</span></span>
</div>
<div class="rowlll mb-2"><span class="label"></span><span class="formw">atau</span></div>

<div class="rowlll border-top-0 border-right-0 border-bottom-0 alert alert-light" style="border-left-width:0.25em !important">
<span class="label"><label id="file_jawabanlbl" for="file_jawaban">Upload file</label></span>
<span class="formw"><form id="upload-offline-answers" action="tmf_upload_offline_answers.php" class="dropzone w-100p rounded" style="display:block"></form></span>
</div>
<div class="alert alert-warning rowlll"><i class="fa fa-exclamation-triangle"></i> Peringatan<ol class="mb-0"><li>Tipe file yang diunggah harus berekstensi <b>.txt</b></li><li>Apabila tidak ada <b>Data Jawaban</b> atau File yang diunggah melalui form di atas, maka sistem akan melakukan koreksi jawaban melalui file yang telah diunggah ke folder <u>cache/offline-answers.</u></li></ol></div>
<div class="d-flex jc-center">
<?php
// if(isset($_REQUEST['test_id']) and $_REQUEST['test_id']>0){
	F_submit_button_confirm('offline-eval', 'Mulai Koreksi', 'Mulai Koreksi', 'class="btn btn-success btn-block" onclick="event.preventDefault();evalstart()"');
// }else{
	// F_submit_button_confirm('offline-eval', 'Mulai Koreksi', 'Mulai Koreksi', 'style="background:#607d8b" onclick="event.preventDefault();window.scrollTo(0,0);alert(\'Pilih dahulu nama test/ujian\')"');
// }
?>
</div>
</div>
</div>
</div>

<?php        
		

echo '</div>';

echo '<div class="form-row justify-content-center mt-3">';
if ($itemcount > 0) {
	echo '<div>';
	echo '<div id="btnAction">'.K_NEWLINE;
	if(file_exists('tmf_show_offline_sheet.php')){
		
			echo '<a href="" onclick="event.preventDefault();downloadAll(\'table#test_result_users tbody tr td:last-child a\')" class="btn btn-primary m-1" title="Download and Generate offline sheet"><i class="fas fa-download"></i> Download and Generate All Offline Sheets (html)</a> ';
			echo '<a id="gaoshtml" href="" onclick="event.preventDefault();generateAll(\'table#test_result_users tbody tr td:last-child a\',\'html\',this.id)" class="btn btn-primary m-1" title="Generate offline sheet"><i class="fas fa-file-code"></i> Generate All Offline Sheets (html)</a>';
			echo '<a id="gaoszip" href="" onclick="event.preventDefault();generateAll(\'table#test_result_users tbody tr td:last-child a\',\'zip\',this.id)" class="btn btn-alternate m-1" title="Generate offline sheet"><i class="fas fa-file-archive"></i> Generate All Offline Sheets (zip)</a>';
		}else{
			echo '<a href="#" onclick="alert(\'File untuk keperluan ini harus request secara pribadi ke Maman Sulaeman\')" class="btn btn-primary" title="Download and Generate offline sheet"><i class="fas fa-download"></i> Download and Generate All Offline Sheets (html)</a> ';
			echo '<a href="#" onclick="alert(\'File untuk keperluan ini harus request secara pribadi ke Maman Sulaeman\')" class="btn btn-success" title="Generate offline sheet"><i class="fas fa-file-code"></i> Generate All Offline Sheets (html)</a> ';
			echo '<a href="#" onclick="alert(\'File untuk keperluan ini harus request secara pribadi ke Maman Sulaeman\')" class="btn btn-alternate" title="Generate offline sheet"><i class="fas fa-file-archive"></i> Generate All Offline Sheets (zip)</a> ';
		}
	echo '</div>';	
	echo '</div>';	
	echo '</div>';	
}

		
echo '<div class="form-row justify-content-center mt-1 mb-3 mx-1">';
if ($itemcount > 0) {
        echo '<div class="jc-center" id="btnAction">'.K_NEWLINE;
        // show buttons by case
		
        echo '<a href="#" onclick="exportTableToExcel(\'test_result_users\');" class="btn btn-success m-1" title="Export data ke Excel"><i class="fa fa-file-excel"></i>&nbsp;Excel</a> ';
        echo '<a href="tce_xml_results.php?menu_mode=startlongprocess'.$filter.'" class="btn btn-primary m-1" title="'.$l['h_xml_export'].'"><i class="fa fa-file-code"></i>&nbsp;XML</a> ';
        echo '<a href="tce_xml_results.php?format=JSON&amp;menu_mode=startlongprocess'.$filter.'" class="m-1 btn btn-secondary" title="JSON"><i class="fa fa-file"></i>&nbsp;JSON</a> ';
        echo '<a href="tce_tsv_result_allusers.php?'.$filter.'&amp;order_field='.urlencode($order_field).'&amp;orderdir='.$orderdir.'" class="btn btn-info m-1" title="'.$l['h_tsv_export'].'"><i class="fa fa-file-csv"></i>&nbsp;TSV</a> ';
        echo '<a href="tce_pdf_results.php?mode=1'.$filter.'" class="btn btn-danger m-1" title="'.$l['h_pdf'].'"><i class="fa fa-file-pdf"></i>&nbsp;'.$l['w_pdf'].'</a> ';
        echo '<a href="tce_pdf_results.php?mode=4'.$filter.'" class="btn btn-danger m-1" title="'.$l['h_pdf_all'].'"><i class="fa fa-file-pdf"></i>&nbsp;'.$l['w_pdf_all'].'</a> ';
        if (K_DISPLAY_PDFTEXT_BUTTON) {
            echo '<a href="tce_pdf_results.php?mode=5'.$filter.'" class="btn btn-danger m-1" title="'.$l['h_pdf_all'].' - TEXT">'.$l['w_pdf'].' TEXT</a> ';
        }
        echo '<a href="tce_email_results.php?mode=1&amp;menu_mode=startlongprocess'.$filter.'" class="btn btn-warning m-1" title="'.$l['h_email_all_results'].'"><i class="fa fa-mail-bulk"></i>&nbsp;'.$l['w_email_all_results'].'</a> ';
        echo '<a href="tce_email_results.php?mode=0&amp;menu_mode=startlongprocess'.$filter.'" class="btn btn-warning m-1" title="'.$l['h_email_all_results'].' + PDF"><i class="fa fa-mail-bulk"></i>&nbsp;'.$l['w_email_all_results'].' + PDF</a> ';
        $custom_export = K_ENABLE_CUSTOM_EXPORT;
        if (!empty($custom_export)) {
            echo '<a href="tce_export_custom.php?menu_mode=startlongprocess'.$filter.'" class="xmlbutton m-1" title="'.$custom_export.'">'.$custom_export.'</a> ';
        }
    }
echo '</div>';
echo '</div>';
// echo '<div class="rowlll">';
// echo '<div class="pagehelp">'.$l['hp_result_alluser'].'</div>'.K_NEWLINE;
// echo '</div>';
echo '</div>';

echo '</div>'.K_NEWLINE;
/* echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE; */

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


// echo '<div class="rowlll">';
// echo '<div class="pagehelp">'.$l['hp_result_alluser'].'</div>'.K_NEWLINE;
// echo '</div>';	
require_once('../code/tce_page_footer.php');
?>
<script>
function evalstart(){
	
		
	<?php if(file_exists('tmf_import_offline_users_answer.php')){ ?>
	var data_jawaban = document.getElementById("data_jawabantxt").value;
	
	var djarr = data_jawaban.split(',');
	
	
	
	djarr.forEach(function(x){
		$.ajax({
			'url': 'tmf_import_offline_users_answer.php?data_jawaban='+x+'&test_id=<?php echo $test_id; ?>',
			'type': 'POST',
			'beforeSend': function(){
					$("input#offline-eval").val("MOHON TUNGGU . . .")},
			'success': function(result){$("input#offline-eval").val("MULAI KOREKSI")},
			
		})
	})   
	
	var refreshIntervalId = setInterval(function(){
		if(window.ajax_loading===false){
			// if(!lanjut){
				alert("Selesai");
				clearInterval(refreshIntervalId);
				// $("#"+c).html(btnLbl); 
			// }
		}
	}, 1000);

	<?php }else{ ?>
	alert("File untuk keperluan ini harus request secara pribadi ke Maman Sulaeman");
	<?php } ?>
}

Dropzone.options.uploadOfflineAnswers = {
	acceptedFiles: 'text/plain'
};

$('#judul-koreksi-offline').click(function(){
	$('#area-koreksi-offline').slideToggle();
})
</script>
<?php
if(isset($_GET['opentestresult'])){
	echo '<script>'.K_NEWLINE;
	echo 'document.getElementById(\'startdate\').value = \'0001-01-01 00:00:00\';document.getElementById(\'form_resultallusers\').submit()'.K_NEWLINE;
	echo '</script>'.K_NEWLINE;
}
//============================================================+
// END OF FILE
//============================================================+
