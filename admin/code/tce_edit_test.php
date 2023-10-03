<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_TESTS;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/config/tce_user_registration.php');

$thispage_title = $l['t_tests_editor'];
$thispage_title_icon = '<i class="pe-7s-airplay icon-gradient bg-love-kiss"></i> ';
$thispage_help = $l['hp_edit_test'];

$enable_calendar = true;
require_once('tce_page_header.php');
echo '<style>.select2-selection {display:inline-block !important; padding-bottom: 0.25em;}</style>';
// require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('tce_functions_tcecode_editor.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('tce_functions_user_select.php');
require_once('tce_functions_test_select.php');


// comma separated list of required fields
$_REQUEST['ff_required'] = 'test_name,test_description,test_ip_range,test_duration_time,test_score_right';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_name'].','.$l['w_description'].','.$l['w_ip_range'].','.$l['w_test_time'].','.$l['w_score_right'], ENT_COMPAT, $l['a_meta_charset']);

// set default values
if (!isset($_REQUEST['test_results_to_users']) or (empty($_REQUEST['test_results_to_users']))) {
    $test_results_to_users = false;
} else {
    $test_results_to_users = F_getBoolean($_REQUEST['test_results_to_users']);
}
if (!isset($_REQUEST['test_report_to_users']) or (empty($_REQUEST['test_report_to_users']))) {
    $test_report_to_users = false;
} else {
    $test_report_to_users = F_getBoolean($_REQUEST['test_report_to_users']);
}
if (!isset($_REQUEST['subject_id']) or (empty($_REQUEST['subject_id']))) {
    $subject_id = array();
} else {
    $subject_id = $_REQUEST['subject_id'];
}
if (!isset($_REQUEST['tsubset_type']) or (empty($_REQUEST['tsubset_type']))) {
    $tsubset_type = 0;
} else {
    $tsubset_type = intval($_REQUEST['tsubset_type']);
}
if (!isset($_REQUEST['tsubset_difficulty'])) {
    $tsubset_difficulty = 1;
} else {
    $tsubset_difficulty = intval($_REQUEST['tsubset_difficulty']);
}
if (!isset($_REQUEST['tsubset_quantity']) or (empty($_REQUEST['tsubset_quantity']))) {
    $tsubset_quantity = 1;
} else {
    $tsubset_quantity = intval($_REQUEST['tsubset_quantity']);
}
if (!isset($_REQUEST['tsubset_answers']) or (empty($_REQUEST['tsubset_answers']))) {
    $tsubset_answers = 2;
} else {
    $tsubset_answers = intval($_REQUEST['tsubset_answers']);
}
if (isset($_REQUEST['tsubset_id'])) {
    $tsubset_id = intval($_REQUEST['tsubset_id']);
}
if (isset($_REQUEST['test_duration_time'])) {
    $test_duration_time = intval($_REQUEST['test_duration_time']);
}
if (isset($_REQUEST['group_id'])) {
    $group_id = intval($_REQUEST['group_id']);
}
if (!isset($_REQUEST['test_score_right']) or (empty($_REQUEST['test_score_right']))) {
    $test_score_right = 0;
} else {
    $test_score_right = floatval($_REQUEST['test_score_right']);
}
if (!isset($_REQUEST['test_score_wrong']) or (empty($_REQUEST['test_score_wrong']))) {
    $test_score_wrong = 0;
} else {
    $test_score_wrong = floatval($_REQUEST['test_score_wrong']);
}
if (!isset($_REQUEST['test_score_unanswered']) or (empty($_REQUEST['test_score_unanswered']))) {
    $test_score_unanswered = 0;
} else {
    $test_score_unanswered = floatval($_REQUEST['test_score_unanswered']);
}
if (!isset($_REQUEST['test_score_threshold']) or (empty($_REQUEST['test_score_threshold']))) {
    $test_score_threshold = 0;
} else {
    $test_score_threshold = floatval($_REQUEST['test_score_threshold']);
}
if (!isset($_REQUEST['test_random_questions_select']) or (empty($_REQUEST['test_random_questions_select']))) {
    $test_random_questions_select = false;
} else {
    $test_random_questions_select = F_getBoolean($_REQUEST['test_random_questions_select']);
}
if (!isset($_REQUEST['test_random_questions_order']) or (empty($_REQUEST['test_random_questions_order']))) {
    $test_random_questions_order = false;
} else {
    $test_random_questions_order = F_getBoolean($_REQUEST['test_random_questions_order']);
}
if (!isset($_REQUEST['test_questions_order_mode']) or (empty($_REQUEST['test_questions_order_mode']))) {
    $test_questions_order_mode = 0;
} else {
    $test_questions_order_mode = max(0, min(3, intval($_REQUEST['test_questions_order_mode'])));
}
if (!isset($_REQUEST['test_random_answers_select']) or (empty($_REQUEST['test_random_answers_select']))) {
    $test_random_answers_select = false;
} else {
    $test_random_answers_select = F_getBoolean($_REQUEST['test_random_answers_select']);
}
if (!isset($_REQUEST['test_random_answers_order']) or (empty($_REQUEST['test_random_answers_order']))) {
    $test_random_answers_order = false;
} else {
    $test_random_answers_order = F_getBoolean($_REQUEST['test_random_answers_order']);
}
if (!isset($_REQUEST['test_answers_order_mode']) or (empty($_REQUEST['test_answers_order_mode']))) {
    $test_answers_order_mode = 0;
} else {
    $test_answers_order_mode = max(0, min(2, intval($_REQUEST['test_answers_order_mode'])));
}
if (!isset($_REQUEST['test_comment_enabled']) or (empty($_REQUEST['test_comment_enabled']))) {
    $test_comment_enabled = false;
} else {
    $test_comment_enabled = F_getBoolean($_REQUEST['test_comment_enabled']);
}
if (!isset($_REQUEST['test_menu_enabled']) or (empty($_REQUEST['test_menu_enabled']))) {
    $test_menu_enabled = false;
} else {
    $test_menu_enabled = F_getBoolean($_REQUEST['test_menu_enabled']);
}
if (!isset($_REQUEST['test_noanswer_enabled']) or (empty($_REQUEST['test_noanswer_enabled']))) {
    $test_noanswer_enabled = false;
} else {
    $test_noanswer_enabled = F_getBoolean($_REQUEST['test_noanswer_enabled']);
}
if (!isset($_REQUEST['test_mcma_radio']) or (empty($_REQUEST['test_mcma_radio']))) {
    $test_mcma_radio = false;
} else {
    $test_mcma_radio = F_getBoolean($_REQUEST['test_mcma_radio']);
}
if (!isset($_REQUEST['test_repeatable']) or (empty($_REQUEST['test_repeatable']))) {
    // $test_repeatable = false;
// } else {
    $test_repeatable = 0;
}
if (!isset($_REQUEST['test_mcma_partial_score']) or (empty($_REQUEST['test_mcma_partial_score']))) {
    $test_mcma_partial_score = false;
} else {
    $test_mcma_partial_score = F_getBoolean($_REQUEST['test_mcma_partial_score']);
}
if (!isset($_REQUEST['test_logout_on_timeout']) or (empty($_REQUEST['test_logout_on_timeout']))) {
    $test_logout_on_timeout = false;
} else {
    $test_logout_on_timeout = F_getBoolean($_REQUEST['test_logout_on_timeout']);
}
if (!isset($_REQUEST['test_max_score'])) {
    $test_max_score = 0;
} else {
    $test_max_score = floatval($_REQUEST['test_max_score']);
}

$test_max_score_new = 0; // test max score
$qtype = array('S', 'M', 'T', 'O'); // question types
$qordmode = array($l['w_position'], $l['w_alphabetic'], $l['w_id'], $l['w_type'], $l['w_subject']);
$aordmode = array($l['w_position'], $l['w_alphabetic'], $l['w_id']);

$test_fieldset_name = '';

if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    if (isset($_REQUEST['link_action']) and ($_REQUEST['link_action'] == 'deletesubject')) {
	$menu_mode = 'deletesubject';
    }		
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }
} else {
    $test_id = 0;
}

if (isset($_POST['lock'])) {
    $menu_mode = 'lock';
} elseif (isset($_POST['unlock'])) {
    $menu_mode = 'unlock';
}

switch ($menu_mode) {
    case 'lock':{ // lock test by changing end date (subtract 1000 years)
        $sql = 'UPDATE '.K_TABLE_TESTS.' SET
			test_end_time='.F_empty_to_null(''.(intval(substr($test_end_time, 0, 1)) - 1).substr($test_end_time, 1)).'
			WHERE test_id='.$test_id.'';
        if (!$r = F_db_query($sql, $db)) {
            F_display_db_error(false);
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'unlock':{ // unlock test by restoring original end date (add 1000 years)
        $sql = 'UPDATE '.K_TABLE_TESTS.' SET
			test_end_time='.F_empty_to_null(''.(intval(substr($test_end_time, 0, 1)) + 1).substr($test_end_time, 1)).'
			WHERE test_id='.$test_id.'';
        if (!$r = F_db_query($sql, $db)) {
            F_display_db_error(false);
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'deletesubject':{ // delete subject
        // check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
        if (!F_check_unique(K_TABLE_TEST_USER, 'testuser_test_id='.$test_id.'')) {
            F_print_error('WARNING', $l['m_update_restrict']);
            F_stripslashes_formfields();
            break;
        }
        $sql = 'DELETE FROM '.K_TABLE_TEST_SUBJSET.' WHERE tsubset_id='.$tsubset_id.'';
        if (!$r = F_db_query($sql, $db)) {
            F_display_db_error(false);
        } else {
            F_print_error('MESSAGE', $l['m_deleted']);
        }
        break;
    }

    case 'addquestion':{ // Add question type
        // check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
        if (!F_check_unique(K_TABLE_TEST_USER, 'testuser_test_id='.$test_id.'')) {
            F_print_error('WARNING', $l['m_update_restrict']);
            $formstatus = false;
            F_stripslashes_formfields();
            break;
        }
        if ($formstatus = F_check_form_fields()) {
            if ((isset($subject_id)) and (!empty($subject_id)) and (isset($tsubset_quantity))) {
                if ($tsubset_type == 3) {
                    // free-text questions do not have alternative answers to display
                    $tsubset_answers = 0;
                } elseif (($tsubset_answers < 2) and ($tsubset_difficulty > 0)) {
                    // questions must have at least 2 alternative answers
                    $tsubset_answers = 2;
                }
                // create a comma separated list of subjects IDs
                $subjids = '';
                foreach ($subject_id as $subid) {
                    if ($subid[0] == '#') {
                        // module ID
                        $modid = intval(substr($subid, 1));
                        $sqlsm = F_select_subjects_sql('subject_module_id='.$modid.'');
                        if ($rsm = F_db_query($sqlsm, $db)) {
                            while ($msm = F_db_fetch_array($rsm)) {
                                $subjids .= $msm['subject_id'].',';
                            }
                        } else {
                            F_display_db_error();
                        }
                    } else {
                        $subjids .= intval($subid).',';
                    }
                }
                $subjids = substr($subjids, 0, -1);
                $subject_id = explode(',', $subjids);
                $subjids = '('.$subjids.')';
                $sql_answer_position = '';
                $sql_questions_position = '';
                if (!$test_random_questions_order and ($test_questions_order_mode == 0)) {
                    $sql_questions_position = ' AND question_position>0';
                }
                if (!$test_random_answers_order and ($test_answers_order_mode == 0)) {
                    $sql_answer_position = ' AND answer_position>0';
                }
                // check here if the selected number of questions are available for the current set
                // NOTE: if the same subject is used in multiple sets this control may fail.
                $sqlq = 'SELECT COUNT(*) AS numquestions FROM '.K_TABLE_QUESTIONS.'';
                $sqlq .= ' WHERE question_subject_id IN '.$subjids.'
					AND question_difficulty='.$tsubset_difficulty.'
					AND question_enabled=\'1\'';
                if ($tsubset_type > 0) {
                    $sqlq .= ' AND question_type='.$tsubset_type.'';
                }
                if ($tsubset_type == 1) {
                    // single question (MCSA)
                    // check if the selected question has enough answers
                    $sqlq .= ' AND question_id IN (
							SELECT answer_question_id
							FROM '.K_TABLE_ANSWERS.'
							WHERE answer_enabled=\'1\' AND answer_isright=\'1\'';
                    $sqlq .= $sql_answer_position;
                    $sqlq .= ' GROUP BY answer_question_id
							HAVING (COUNT(answer_id)>0))';
                    $sqlq .= ' AND question_id IN (
							SELECT answer_question_id
							FROM '.K_TABLE_ANSWERS.'
							WHERE answer_enabled=\'1\'
							AND answer_isright=\'0\'';
                    $sqlq .= $sql_answer_position;
                    $sqlq .= ' GROUP BY answer_question_id';
                    if ($tsubset_answers > 0) {
                        $sqlq .= ' HAVING (COUNT(answer_id)>='.($tsubset_answers-1).')';
                    }
                    $sqlq .= ' )';
                } elseif ($tsubset_type == 2) {
                    // multiple question (MCMA)
                    // check if the selected question has enough answers
                    $sqlq .= ' AND question_id IN (
							SELECT answer_question_id
							FROM '.K_TABLE_ANSWERS.'
							WHERE answer_enabled=\'1\'';
                    $sqlq .= $sql_answer_position;
                    $sqlq .= ' GROUP BY answer_question_id';
                    if ($tsubset_answers > 0) {
                        $sqlq .= ' HAVING (COUNT(answer_id)>='.$tsubset_answers.')';
                    }
                    $sqlq .= ' )';
                } elseif ($tsubset_type == 4) {
                    // ordering question
                    // check if the selected question has enough answers
                    $sqlq .= ' AND question_id IN (
							SELECT answer_question_id
							FROM '.K_TABLE_ANSWERS.'
							WHERE answer_enabled=\'1\'
							AND answer_position>0
							GROUP BY answer_question_id
							HAVING (COUNT(answer_id)>1))';
                }
                $sqlq .= $sql_questions_position;
                if (K_DATABASE_TYPE == 'ORACLE') {
                    $sqlq = 'SELECT * FROM ('.$sqlq.') WHERE rownum <= '.$tsubset_quantity.'';
                } else {
                    $sqlq .= ' LIMIT '.$tsubset_quantity.'';
                }
                $numofrows = 0;
                if ($rq = F_db_query($sqlq, $db)) {
                    if ($mq = F_db_fetch_array($rq)) {
                        $numofrows = $mq['numquestions'];
                    }
                } else {
                    F_display_db_error();
                }
                if ($numofrows < $tsubset_quantity) {
                    F_print_error('WARNING', $l['m_unavailable_questions']);
                    break;
                }
                if (!empty($subject_id)) {
                    // insert new subject
                    $sql = 'INSERT INTO '.K_TABLE_TEST_SUBJSET.' (tsubset_test_id,
						tsubset_type,
						tsubset_difficulty,
						tsubset_quantity,
						tsubset_answers
						) VALUES (
						\''.$test_id.'\',
						\''.$tsubset_type.'\',
						\''.$tsubset_difficulty.'\',
						\''.$tsubset_quantity.'\',
						\''.$tsubset_answers.'\'
						)';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                    } else {
                        $tsubset_id = F_db_insert_id($db, K_TABLE_TEST_SUBJSET, 'tsubset_id');
                        // add selected subject_id
                        foreach ($subject_id as $subid) {
                            $sql = 'INSERT INTO '.K_TABLE_SUBJECT_SET.' (
								subjset_tsubset_id,
								subjset_subject_id
								) VALUES (
								\''.$tsubset_id.'\',
								\''.$subid.'\'
								)';
                            if (!$r = F_db_query($sql, $db)) {
                                F_display_db_error(false);
                            }
                        }
                    }
                }
            }
			F_print_error('MESSAGE', 'Bank soal berhasil disisipkan ke dalam ujian: '.$test_name.'</span');
        }
        break;
    }

    case 'delete':{
        F_stripslashes_formfields();        // ask confirmation
        F_print_error('WARNING', $l['m_delete_confirm_test']);
        ?>
        <div class="confirmbox">
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" id="form_delete">
        <div>
        <input type="hidden" name="test_id" id="test_id" value="<?php echo $test_id; ?>" />
        <input type="hidden" name="test_name" id="test_name" value="<?php echo $test_name; ?>" />
        <?php
        F_submit_button('forcedelete', $l['w_delete'], $l['h_delete']);
        F_submit_button('cancel', $l['w_cancel'], $l['h_cancel']);
        echo F_getCSRFTokenField().K_NEWLINE;
        ?>
        </div>
        </form>
        </div>
        <?php
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields(); // Delete
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
            // delete test
            $sql = 'DELETE FROM '.K_TABLE_TESTS.' WHERE test_id='.$test_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $test_id = false;
                F_print_error('MESSAGE', $test_name.': '.$l['m_deleted']);
            }
        }
        break;
    }

    case 'update':{ // Update
        // check if the confirmation chekbox has been selected
        if (!isset($_REQUEST['confirmupdate']) or ($_REQUEST['confirmupdate'] != 1)) {
            F_print_error('WARNING', $l['m_form_missing_fields'].': '.$l['w_confirm'].' &rarr; '.$l['w_update']);
            $formstatus = false;
            F_stripslashes_formfields();
            break;
        }
        if ($formstatus = F_check_form_fields()) {
            // check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
			/** TMF Enable Test Editing when test ongoing
            if (!F_check_unique(K_TABLE_TEST_USER, 'testuser_test_id='.$test_id.'')) {
                F_print_error('WARNING', $l['m_update_restrict']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }**/
            // check if name is unique
            if (!F_check_unique(K_TABLE_TESTS, 'test_name=\''.$test_name.'\'', 'test_id', $test_id)) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            if (!empty($new_test_password)) {
                $test_password = getPasswordHash($new_test_password);
            }
            if ($test_score_threshold > $test_max_score) {
                $test_score_threshold = 0.6 * $test_max_score;
            }
            $sql = 'UPDATE '.K_TABLE_TESTS.' SET
				test_name=\''.F_escape_sql($db, $test_name).'\',
				test_description=\''.F_escape_sql($db, $test_description).'\',
				test_begin_time='.F_empty_to_null($test_begin_time).',
				test_end_time='.F_empty_to_null($test_end_time).',
				test_duration_time=\''.$test_duration_time.'\',
				test_ip_range=\''.F_escape_sql($db, $test_ip_range).'\',
				test_results_to_users=\''.intval($test_results_to_users).'\',
				test_report_to_users=\''.intval($test_report_to_users).'\',
				test_score_right=\''.$test_score_right.'\',
				test_score_wrong=\''.$test_score_wrong.'\',
				test_score_unanswered=\''.$test_score_unanswered.'\',
				test_max_score=\''.$test_max_score.'\',
				test_score_threshold=\''.$test_score_threshold.'\',
				test_random_questions_select=\''.intval($test_random_questions_select).'\',
				test_random_questions_order=\''.intval($test_random_questions_order).'\',
				test_questions_order_mode=\''.$test_questions_order_mode.'\',
				test_random_answers_select=\''.intval($test_random_answers_select).'\',
				test_random_answers_order=\''.intval($test_random_answers_order).'\',
				test_answers_order_mode=\''.$test_answers_order_mode.'\',
				test_comment_enabled=\''.intval($test_comment_enabled).'\',
				test_menu_enabled=\''.intval($test_menu_enabled).'\',
				test_noanswer_enabled=\''.intval($test_noanswer_enabled).'\',
				test_mcma_radio=\''.intval($test_mcma_radio).'\',
				test_repeatable=\''.intval($test_repeatable).'\',
				test_mcma_partial_score=\''.intval($test_mcma_partial_score).'\',
				test_logout_on_timeout=\''.intval($test_logout_on_timeout).'\',
				test_password='.F_empty_to_null($test_password).'
				WHERE test_id='.$test_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                F_print_error('MESSAGE', $l['m_updated']);
            }

            // delete previous groups
            $sql = 'DELETE FROM '.K_TABLE_TEST_GROUPS.'
				WHERE tstgrp_test_id='.$test_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            }
            // update authorized groups
            if (!empty($user_groups)) {
                foreach ($user_groups as $group_id) {
                    $sql = 'INSERT INTO '.K_TABLE_TEST_GROUPS.' (
						tstgrp_test_id,
						tstgrp_group_id
						) VALUES (
						\''.$test_id.'\',
						\''.intval($group_id).'\'
						)';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                    }
                }
            }

            // delete previous SSL certificates
            $sql = 'DELETE FROM '.K_TABLE_TEST_SSLCERTS.'
				WHERE tstssl_test_id='.$test_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            }
            // update authorized SSL certificates
            if (!empty($sslcerts)) {
                foreach ($sslcerts as $ssl_id) {
                    $sql = 'INSERT INTO '.K_TABLE_TEST_SSLCERTS.' (
						tstssl_test_id,
						tstssl_ssl_id
						) VALUES (
						\''.$test_id.'\',
						\''.intval($ssl_id).'\'
						)';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                    }
                }
            }
        }
        break;
    }

    case 'add':{ // Add
        if ($formstatus = F_check_form_fields()) {
            // check if name is unique
            if (!F_check_unique(K_TABLE_TESTS, 'test_name=\''.F_escape_sql($db, $test_name).'\'')) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            if (isset($test_id) and ($test_id > 0)) {
                // save previous test_id.
                $old_test_id = $test_id;
            }
            if (!empty($new_test_password)) {
                $test_password = getPasswordHash($new_test_password);
            }
            $sql = 'INSERT INTO '.K_TABLE_TESTS.' (
			test_name,
				test_description,
				test_begin_time,
				test_end_time,
				test_duration_time,
				test_ip_range,
				test_results_to_users,
				test_report_to_users,
				test_score_right,
				test_score_wrong,
				test_score_unanswered,
				test_max_score,
				test_user_id,
				test_score_threshold,
				test_random_questions_select,
				test_random_questions_order,
				test_questions_order_mode,
				test_random_answers_select,
				test_random_answers_order,
				test_answers_order_mode,
				test_comment_enabled,
				test_menu_enabled,
				test_noanswer_enabled,
				test_mcma_radio,
				test_repeatable,
				test_mcma_partial_score,
				test_logout_on_timeout,
				test_password
				) VALUES (
				\''.F_escape_sql($db, $test_name).'\',
				\''.F_escape_sql($db, $test_description).'\',
				'.F_empty_to_null($test_begin_time).',
				'.F_empty_to_null($test_end_time).',
				\''.$test_duration_time.'\',
				\''.F_escape_sql($db, $test_ip_range).'\',
				\''.intval($test_results_to_users).'\',
				\''.intval($test_report_to_users).'\',
				\''.$test_score_right.'\',
				\''.$test_score_wrong.'\',
				\''.$test_score_unanswered.'\',
				\''.$test_max_score.'\',
				\''.intval($_SESSION['session_user_id']).'\',
				\''.$test_score_threshold.'\',
				\''.intval($test_random_questions_select).'\',
				\''.intval($test_random_questions_order).'\',
				\''.$test_questions_order_mode.'\',
				\''.intval($test_random_answers_select).'\',
				\''.intval($test_random_answers_order).'\',
				\''.$test_answers_order_mode.'\',
				\''.intval($test_comment_enabled).'\',
				\''.intval($test_menu_enabled).'\',
				\''.intval($test_noanswer_enabled).'\',
				\''.intval($test_mcma_radio).'\',
				\''.intval($test_repeatable).'\',
				\''.intval($test_mcma_partial_score).'\',
				\''.intval($test_logout_on_timeout).'\',
				'.F_empty_to_null($test_password).'
				)';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $test_id = F_db_insert_id($db, K_TABLE_TESTS, 'test_id');
            }
            // add authorized user's groups
            if (!empty($user_groups)) {
                foreach ($user_groups as $group_id) {
                    $sql = 'INSERT INTO '.K_TABLE_TEST_GROUPS.' (
						tstgrp_test_id,
						tstgrp_group_id
						) VALUES (
						\''.$test_id.'\',
						\''.intval($group_id).'\'
						)';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                    }
                }
            }

            // update authorized SSL certificates
            if (!empty($sslcerts)) {
                foreach ($sslcerts as $ssl_id) {
                    $sql = 'INSERT INTO '.K_TABLE_TEST_SSLCERTS.' (
						tstssl_test_id,
						tstssl_ssl_id
						) VALUES (
						\''.$test_id.'\',
						\''.intval($ssl_id).'\'
						)';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                    }
                }
            }

            if (isset($old_test_id) and ($old_test_id > 0)) {
                // copy here previous selected questions to this new test
                $sql = 'SELECT *
					FROM '.K_TABLE_TEST_SUBJSET.'
					WHERE tsubset_test_id=\''.$old_test_id.'\'';
                if ($r = F_db_query($sql, $db)) {
                    while ($m = F_db_fetch_array($r)) {
                        // insert new subject
                        $sqlu = 'INSERT INTO '.K_TABLE_TEST_SUBJSET.' (
							tsubset_test_id,
							tsubset_type,
							tsubset_difficulty,
							tsubset_quantity,
							tsubset_answers
							) VALUES (
							\''.$test_id.'\',
							\''.$m['tsubset_type'].'\',
							\''.$m['tsubset_difficulty'].'\',
							\''.$m['tsubset_quantity'].'\',
							\''.$m['tsubset_answers'].'\'
							)';
                        if (!$ru = F_db_query($sqlu, $db)) {
                            F_display_db_error();
                        } else {
                            $tsubset_id = F_db_insert_id($db, K_TABLE_TEST_SUBJSET, 'tsubset_id');
                            $sqls = 'SELECT *
								FROM '.K_TABLE_SUBJECT_SET.'
								WHERE subjset_tsubset_id=\''.$m['tsubset_id'].'\'';
                            if ($rs = F_db_query($sqls, $db)) {
                                while ($ms = F_db_fetch_array($rs)) {
                                    $sqlp = 'INSERT INTO '.K_TABLE_SUBJECT_SET.' (
										subjset_tsubset_id,
										subjset_subject_id
										) VALUES (
										\''.$tsubset_id.'\',
										\''.$ms['subjset_subject_id'].'\'
										)';
                                    if (!$rp = F_db_query($sqlp, $db)) {
                                        F_display_db_error();
                                    }
                                }
                            } else {
                                F_display_db_error();
                            }
                        }
                    }
                } else {
                    F_display_db_error();
                }
            }
        }
        break;
    }

    case 'clear':{ // Clear form fields
        $test_name = '';
        $test_description = '';
        $test_begin_time = date(K_TIMESTAMP_FORMAT);
        $test_end_time = date(K_TIMESTAMP_FORMAT, time() + K_SECONDS_IN_DAY);
        $test_duration_time = 60;
        $test_ip_range = '*.*.*.*';
        $test_results_to_users = false;
        $test_report_to_users = false;
        $test_score_right = 1;
        $test_score_wrong = 0;
        $test_score_unanswered = 0;
        $test_max_score = 0;
        $test_score_threshold = 0;
        $test_random_questions_select = true;
        $test_random_questions_order = true;
        $test_questions_order_mode = 0;
        $test_random_answers_select = true;
        $test_random_answers_order = true;
        $test_answers_order_mode = 0;
        $test_comment_enabled = true;
        $test_menu_enabled = true;
        $test_noanswer_enabled = true;
        $test_mcma_radio = true;
        $test_repeatable = 0;
        $test_mcma_partial_score = true;
        $test_logout_on_timeout = false;
        $test_password = '';
        break;
    }

    default :{
        break;
    }
} //end of switch

// --- Initialize variables

if (!isset($test_num) or (!empty($test_num))) {
    $test_num = 1; // default number of PDF tests to generate
}

if ($formstatus) {
    if ($menu_mode != 'clear') {
        if (!isset($test_id) or empty($test_id)) {
            $test_id = 0;
            $test_name = '';
            $test_description = '';
            $test_begin_time = date(K_TIMESTAMP_FORMAT);
            $test_end_time = date(K_TIMESTAMP_FORMAT, time() + K_SECONDS_IN_DAY);
            $test_duration_time = 60;
            $test_ip_range = '*.*.*.*';
            $test_results_to_users = false;
            $test_report_to_users = false;
            $test_score_right = 1;
            $test_score_wrong = 0;
            $test_score_unanswered = 0;
            $test_max_score = 0;
            $test_score_threshold = 0;
            $test_random_questions_select = true;
            $test_random_questions_order = true;
            $test_questions_order_mode = 0;
            $test_random_answers_select = true;
            $test_random_answers_order = true;
            $test_answers_order_mode = 0;
            $test_comment_enabled = true;
            $test_menu_enabled = true;
            $test_noanswer_enabled = true;
            $test_mcma_radio = true;
            $test_repeatable = 0;
            $test_mcma_partial_score = true;
            $test_logout_on_timeout = false;
            $test_password = '';
        } else {
            $sql = 'SELECT * FROM '.K_TABLE_TESTS.' WHERE test_id='.$test_id.' LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $test_id = $m['test_id'];
                    $test_name = $m['test_name'];
                    $test_description = $m['test_description'];
                    $test_begin_time = $m['test_begin_time'];
                    $test_end_time = $m['test_end_time'];
                    $test_duration_time = $m['test_duration_time'];
                    $test_ip_range = $m['test_ip_range'];
                    $test_results_to_users = F_getBoolean($m['test_results_to_users']);
                    $test_report_to_users = F_getBoolean($m['test_report_to_users']);
                    $test_score_right = $m['test_score_right'];
                    $test_score_wrong = $m['test_score_wrong'];
                    $test_score_unanswered = $m['test_score_unanswered'];
                    $test_max_score = $m['test_max_score'];
                    $test_score_threshold = $m['test_score_threshold'];
                    $test_random_questions_select = F_getBoolean($m['test_random_questions_select']);
                    $test_random_questions_order = F_getBoolean($m['test_random_questions_order']);
                    $test_questions_order_mode = intval($m['test_questions_order_mode']);
                    $test_random_answers_select = F_getBoolean($m['test_random_answers_select']);
                    $test_random_answers_order = F_getBoolean($m['test_random_answers_order']);
                    $test_answers_order_mode = intval($m['test_answers_order_mode']);
                    $test_comment_enabled = F_getBoolean($m['test_comment_enabled']);
                    $test_menu_enabled = F_getBoolean($m['test_menu_enabled']);
                    $test_noanswer_enabled = F_getBoolean($m['test_noanswer_enabled']);
                    $test_mcma_radio = F_getBoolean($m['test_mcma_radio']);
                    // $test_repeatable = F_getBoolean($m['test_repeatable']);
                    $test_repeatable = $m['test_repeatable'];
                    $test_mcma_partial_score = F_getBoolean($m['test_mcma_partial_score']);
                    $test_logout_on_timeout = F_getBoolean($m['test_logout_on_timeout']);
                    $test_password = $m['test_password'];
                } else {
                    $test_name = '';
                    $test_description = '';
                    $test_begin_time = date(K_TIMESTAMP_FORMAT);
                    $test_end_time = date(K_TIMESTAMP_FORMAT, time() + K_SECONDS_IN_DAY);
                    $test_duration_time = 60;
                    $test_ip_range = '*.*.*.*';
                    $test_results_to_users = false;
                    $test_report_to_users = false;
                    $test_score_right = 1;
                    $test_score_wrong = 0;
                    $test_score_unanswered = 0;
                    $test_max_score = 0;
                    $test_score_threshold = 0;
                    $test_random_questions_select = true;
                    $test_random_questions_order = true;
                    $test_questions_order_mode = 0;
                    $test_random_answers_select = true;
                    $test_random_answers_order = true;
                    $test_answers_order_mode = 0;
                    $test_comment_enabled = true;
                    $test_menu_enabled = true;
                    $test_noanswer_enabled = true;
                    $test_mcma_radio = true;
                    $test_repeatable = 0;
                    $test_mcma_partial_score = true;
                    $test_logout_on_timeout = false;
                    $test_password = '';
                }
            } else {
                F_display_db_error();
            }
        }
    }
}

$generateTest = '';
$pdfTest = '';
	
$millennium = substr(date('Y'), 0, 1);

echo '<div>'.K_NEWLINE;
$bank_soal_warning = '';

echo '<div id="banksoalwarning" style="display:none!important"></div>'.K_NEWLINE;
echo '<div class="card mb-3">'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_testeditor">'.K_NEWLINE;



echo '<div>'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_id" class="font-weight-bold">Pilih '.$l['w_test'].'</label>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="test_id" id="test_id" size="0" onchange="document.getElementById(\'form_testeditor\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
echo '<option value="0"';
if ($test_id == 0) {
    echo ' selected="selected"';
}
echo '>+ buat test baru</option>'.K_NEWLINE;
$sql = F_select_tests_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['test_id'].'"';
        if ($m['test_id'] == $test_id) {
            echo ' selected="selected"';
            // $test_fieldset_name = ''.substr($m['test_begin_time'], 0, 10).' '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'';
			$test_fieldset_name = '<div class="font-weight-bold d-flex flex-column"><span class="my-1 mr-1">Nama Test <acronym class="badge badge-primary"><i class="fas fa-calendar-check"></i> '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</acronym></span><span class="my-1 mr-1">Tanggal Mulai Test <acronym class="badge badge-info"><i class="fas fa-calendar-plus"></i> '.
			substr($m['test_begin_time'], 0, 10).'</acronym></span></div>';
        }
        echo '>'.$countitem.'. ';
        if (substr($m['test_end_time'], 0, 1) < $millennium) {
            echo '* ';
        }
        echo substr($m['test_begin_time'], 0, 10).' '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_tests_popup.php?cid=test_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\');return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'"><i class="fas fa-window-restore"></i></a>';

echo '</span>'.K_NEWLINE;
echo '<br />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

// echo '<fieldset>'.K_NEWLINE;
echo '<div class="card border shadow-none">'.K_NEWLINE;
echo '<div class="card-header bg-light">'.K_NEWLINE;
echo '<legend class="m-0"><i class="pe-7s-airplay"></i> Pengaturan '.$l['w_test'].'</legend>'.K_NEWLINE;
echo '</div>';
echo '<div class="card-body">'.K_NEWLINE;
echo getFormRowTextInput('test_name', $l['w_name'], $l['h_test_name'], '', $test_name, '', 255, false, false, false);
echo getFormRowTextBox('test_description', $l['w_description'], $l['h_test_description'], $test_description, false);
// echo '<br/>';
echo '<div class="form-row mt-2">';
echo '<div class="col-md-4">';

//function getFormRowTextInput(
// $field_name, 
// $name, 
// $description = '', 
// $tip = '', 
// $value = '', 
// $format = '', 
// $maxlen = 255, 
// $date = false, 
// $datetime = false, 
// $password = false, 
// $prefix = '', 
// $group = false)

// $test_begin_time=str_replace(' ','T',$test_begin_time);
// echo $test_begin_time;


echo getFormRowTextInput('test_begin_time', $l['w_time_begin'], $l['w_time_begin'].' '.$l['w_datetime_format'], '', $test_begin_time, '', 19, false, false, 'datetime-local" step="any', '', false);
echo '</div>';
// echo getFormRowTextInput('user_birthdate', $l['w_birth_date'], $l['h_birth_date'].' '.$l['w_date_format'], '', $user_birthdate, '', 10, false, false, 'date', '', true);
echo '<div class="col-md-4">';
echo getFormRowTextInput('test_end_time', $l['w_time_end'], $l['w_time_end'].' '.$l['w_datetime_format'], '', $test_end_time, '', 19, false, false, 'datetime-local" step="any', '', false);
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('test_duration_time', $l['w_test_time'], $l['h_test_time'], '['.$l['w_minutes'].']', $test_duration_time, '^([0-9]*)$', 20, false, false, false);
echo '</div>';
echo '</div>';

echo '<div>'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
echo '<label for="user_groups">'.$l['w_groups'].'</label>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<select class="custom-select select2-multiple" name="user_groups[]" id="user_groups" size="5" multiple="multiple">'.K_NEWLINE;
//$sql = F_user_group_select_sql();
$sql = 'SELECT * FROM '.K_TABLE_GROUPS.' ORDER BY group_name';
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['group_id'].'"';
        if (isset($test_id) and ($test_id > 0) and (F_isTestOnGroup($test_id, $m['group_id']))) {
            echo ' selected="selected"';
        }
        echo '>'.htmlspecialchars($m['group_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;



echo '<div class="form-row">';

echo '<div class="col-md-6 mt-3">';
echo '<label for="sslcerts">'.$l['w_sslcerts'].'</label>'.K_NEWLINE;
echo '<select name="sslcerts[]" id="sslcerts" class="custom-select select2-multiple" size="5" multiple="multiple">'.K_NEWLINE;
$sql = 'SELECT * FROM '.K_TABLE_SSLCERTS.' ORDER BY ssl_name';
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['ssl_id'].'"';
        if (isset($test_id) and ($test_id > 0) and (F_isTestOnSSLCerts($test_id, $m['ssl_id']))) {
            echo ' selected="selected"';
        }
        echo '>'.htmlspecialchars($m['ssl_name'].' ('.substr($m['ssl_end_date'], 0, 10).')', ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="col-md-6 mt-3">';
echo getFormRowTextInput('test_ip_range', $l['w_ip_range'], $l['h_ip_range'], '', $test_ip_range, '^([0-9a-fA-F,\:\.\*-]*)$', 255, false, false, false);
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;



echo '<div class="form-row mt-0">';
echo '<div class="col-md-6">';
echo getFormRowTextInput('test_score_right', $l['w_score_right'], $l['h_score_right'], '', $test_score_right, '^([0-9\+\-]*)([\.]?)([0-9]*)$', 20, false, false, false,'',true);
echo '</div>';
echo '<div class="col-md-6">';
echo getFormRowTextInput('test_score_wrong', $l['w_score_wrong'], $l['h_score_wrong'], 'Jika poin jawaban salah diubah selain 0, maka pengaturan persentase bobot opsi tidak berlaku untuk ujian ini', $test_score_wrong, '^([0-9\+\-]*)([\.]?)([0-9]*)$', 20, false, false, false, '', true);
echo '</div>';
echo '</div>';


echo '<div class="form-row">';
echo '<div class="col-md-6">';
echo getFormRowTextInput('test_score_unanswered', $l['w_score_unanswered'], $l['h_score_unanswered'], '', $test_score_unanswered, '^([0-9\+\-]*)([\.]?)([0-9]*)$', 20, false, false, false, '', true);
echo '</div>';
echo '<div class="col-md-6">';
echo getFormRowTextInput('test_score_threshold', $l['w_test_score_threshold'], $l['h_test_score_threshold'], 'bisa disamakan seperti nilai KKM', $test_score_threshold, '^([0-9\+\-]*)([\.]?)([0-9]*)$', 20, false, false, false, '', true);
echo '</div>';
echo '</div>';

echo '<div class="form-row ml-0 mb-3">'.K_NEWLINE;
echo '<div class="border p-2 col-md-3">'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
echo '<label class="mb-0 font-weight-bold" for="test_random_questions_select">'.$l['w_random_questions'].'</label>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<div class="custom-checkbox custom-control">';
echo '<div class="d-block">';
echo '<input class="custom-control-input" type="checkbox" name="test_random_questions_select" id="test_random_questions_select" value="1"';
if ($test_random_questions_select) {
    echo ' checked="checked"';
}
echo ' onclick="JF_check_random_boxes()"';
echo ' title="'.$l['h_random_questions'].'" />';
echo ' <label class="custom-control-label" for="test_random_questions_select">'.$l['w_select'].'</label>'.K_NEWLINE;
echo '</div>';

echo '<div class="d-block">';
echo ' <input class="custom-control-input" type="checkbox" name="test_random_questions_order" id="test_random_questions_order" value="1"';
if ($test_random_questions_order) {
    echo ' checked="checked"';
}
echo ' onclick="JF_check_random_boxes()"';
echo ' title="'.$l['w_order'].'" />';
echo ' <label class="custom-control-label" for="test_random_questions_order">'.$l['w_order'].'</label>'.K_NEWLINE;
echo '</div>';

echo '<span id="select_questions_order_mode" style="display:block;">'.K_NEWLINE;
echo '<div class="d-flex"><label for="test_questions_order_mode" class="mr-2 align-self-center">'.$l['w_order_by'].'</label>'.K_NEWLINE;
echo ' <select class="form-control" name="test_questions_order_mode" id="test_questions_order_mode" size="1" title="'.$l['h_questions_order_mode'].'">'.K_NEWLINE;
foreach ($qordmode as $ok => $ov) {
        echo '<option value="'.$ok.'"';
    if ($test_questions_order_mode == $ok) {
        echo ' selected="selected"';
    }
        echo '>'.htmlspecialchars($ov, ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

///////////


echo '<div class="border p-2 col-md-3">'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_random_answers_select" class="font-weight-bold mb-0">'.$l['w_random_answers'].'</label>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<div class="custom-checkbox custom-control">';
echo '<div class="d-block">';
echo '<input class="custom-control-input" type="checkbox" name="test_random_answers_select" id="test_random_answers_select" value="1"';
if ($test_random_answers_select) {
    echo ' checked="checked"';
}
echo ' onclick="JF_check_random_boxes()"';
echo ' title="'.$l['h_random_answers'].'" />';
echo ' <label class="custom-control-label" for="test_random_answers_select">'.$l['w_select'].'</label>'.K_NEWLINE;
echo '</div>';

echo '<div class="d-block">';
echo ' <input class="custom-control-input" type="checkbox" name="test_random_answers_order" id="test_random_answers_order" value="1"';
if ($test_random_answers_order) {
    echo ' checked="checked"';
}
echo ' onclick="JF_check_random_boxes()"';
echo ' title="'.$l['w_order'].'" />';
echo ' <label class="custom-control-label" for="test_random_answers_order">'.$l['w_order'].'</label>'.K_NEWLINE;

echo '<span id="select_answers_order_mode" style="display:block;">'.K_NEWLINE;
echo '<div class="d-flex"><label for="test_answers_order_mode" class="mr-2 align-self-center">'.$l['w_order_by'].'</label>'.K_NEWLINE;
echo ' <select class="form-control" name="test_answers_order_mode" id="test_answers_order_mode" size="1" title="'.$l['h_answers_order_mode'].'">'.K_NEWLINE;
foreach ($aordmode as $ok => $ov) {
        echo '<option value="'.$ok.'"';
    if ($test_answers_order_mode == $ok) {
        echo ' selected="selected"';
    }
        echo '>'.htmlspecialchars($ov, ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">';
echo getFormRowCheckBox('test_mcma_radio', $l['w_mcma_radio'], '', '', 1, $test_mcma_radio, false);
echo getFormRowCheckBox('test_mcma_partial_score', $l['w_mcma_partial_score'], '', '', 1, $test_mcma_partial_score, false);
echo getFormRowCheckBox('test_noanswer_enabled', $l['w_enable_noanswer'], '', '', 1, $test_noanswer_enabled, false);
echo getFormRowCheckBox('test_menu_enabled', $l['w_enable_menu'], '', '', 1, $test_menu_enabled, false);
echo '</div>';
echo '<div class="col-md-6">';
echo getFormRowCheckBox('test_comment_enabled', $l['w_enable_comment'], '', '', 1, $test_comment_enabled, false);
echo getFormRowCheckBox('test_results_to_users', $l['w_results_to_users'], '', '', 1, $test_results_to_users, false);
echo getFormRowCheckBox('test_report_to_users', $l['w_report_to_users'], '', '', 1, $test_report_to_users, false);
// echo getFormRowCheckBox('test_repeatable', $l['w_repeatable'], '', '', 1, $test_repeatable, false);
echo '</div>';
echo '</div>';



echo '<div class="mb-2">'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
// echo '<div class="input-group-prepend">';
echo '<label for="test_repeatable">Dpt diulang ?</label>'.K_NEWLINE;
// echo '</div>';
// echo '</span>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
// echo '<div class="input-group-append">';
echo '<select class="form-control" name="test_repeatable" id="test_repeatable" size="0">'.K_NEWLINE;
for($i=-1; $i<=127; $i++){
	echo '<option value="'.$i.'" ';
	if($test_repeatable==$i){
		echo 'selected="selected"';	
	}
	echo '>';
	if($i==-1){
		echo 'ya, tak terbatas';
	}elseif($i==0){
		echo 'tidak';
	}else{
		echo ''.$i.'x';
	}
	echo '</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;



echo getFormRowCheckBox('test_logout_on_timeout', $l['w_logout_on_timeout'], '', '', 1, $test_logout_on_timeout, false);
echo '<div class="mb-2"></div>';

echo getFormRowTextInput('new_test_password', $l['w_password'], $l['h_test_password'], 'Password ujian bisa disebut juga dengan Token<br/> ( '.$l['d_password_lenght'].' )', '', K_USRREG_PASSWORD_RE, 255, false, false, false, '', true);

echo '<span class="invisible" id="banksoal"></span>';
echo '<input type="hidden" name="test_password" id="test_password" value="'.$test_password.'" />'.K_NEWLINE;



if (isset($test_id) and ($test_id > 0)) {
    // echo '<span>';
    echo '<input type="checkbox" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
    // echo '</span>';
}

echo '<div class="d-flex justify-content-center flex-wrap mx-n3 mb-n2 pt-2 border-top">'.K_NEWLINE;
// echo '<br />'.K_NEWLINE;

if (isset($test_id) and ($test_id > 0)) {
    F_submit_button_alt('update', $l['w_update'], $l['h_update'], 'btn btn-primary m-1');
}
	

	
// show buttons by case
F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'btn btn-success m-1');
if (isset($test_id) and ($test_id > 0)) {
    F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], 'btn btn-danger m-1');
    if (substr($test_end_time, 0, 1) < $millennium) {
        F_submit_button_alt('unlock', $l['w_unlock'], $l['w_unlock'], 'btn btn-light m-1' );
    } else {
        F_submit_button_alt('lock', $l['w_lock'], $l['w_lock'], 'btn btn-alternate m-1');
    }
}
F_submit_button_alt('clear', $l['w_clear'], $l['h_clear'], 'btn btn-warning m-1');

// echo '<br /><br />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// display a list of selected subject_id (topics)
if (isset($test_id) and ($test_id > 0)) {
    // echo '<div class="row"><br /></div>'.K_NEWLINE;

    echo '<div class="card mt-3 border rounded shadow-none">'.K_NEWLINE;
    // echo '<div class="card-header bg-primary text-white"><legend id="banksoal" class="m-0"><i class="pe-7s-news-paper"></i> Sisipkan Bank '.$l['w_questions'].'</legend>'.TMF_modal_button('infoSisipkanBankSoal','<i class="fas fa-question-circle"></i>').'</div>'.K_NEWLINE;
    echo '<div class="card-header bg-primary text-white d-flex"><legend class="m-0"><i class="pe-7s-news-paper"></i> Sisipkan Bank '.$l['w_questions'].'</legend>'.TMF_tooltip_button('<i class="text-white fas fa-question-circle"></i>','Anda bisa memasukkan bank soal yang telah diinput pada proses sebelumnya ke dalam tes ini. Satu tes boleh berisi beberapa bank soal.','btn btn-white').'</div>'.K_NEWLINE;
    echo '<div class="card-body p-3">'.K_NEWLINE;
	// echo '<div class="alert alert-info"></div>';
	
    echo '<div>'.K_NEWLINE;
    echo $test_fieldset_name.K_NEWLINE;
    echo '</div>'.K_NEWLINE;

    echo '<div class="mt-2 mb-3">'.K_NEWLINE;    
    echo '<label for="subject_id" class="text-capitalize font-weight-bold">Pilih '.$l['w_subjects'].'</label>'.K_NEWLINE;
    echo '<span class="formw">'.K_NEWLINE;
    echo '<select data-width="100%" class="form-control select2-multiple" name="subject_id[]" id="subject_id" size="10" multiple="multiple" title="'.$l['h_subjects'].'">'.K_NEWLINE;
    // select subject_id
    $sql = F_select_module_subjects_sql('module_enabled=\'1\' AND subject_enabled=\'1\'');
    if ($r = F_db_query($sql, $db)) {
        $prev_module_id = 0;
        while ($m = F_db_fetch_array($r)) {
            if ($m['module_id'] != $prev_module_id) {
                $prev_module_id = $m['module_id'];
                echo '<optgroup label="'.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'">'.K_NEWLINE;
				echo '<option value="#'.$m['module_id'].'" style="background-color:#DDEEFF;font-weight:bold">* '.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
            }
            echo '<option value="'.$m['subject_id'].'"';
            if (in_array($m['subject_id'], $subject_id)) {
                echo ' selected="selected"';
            }
            echo '>&nbsp;&nbsp;&nbsp;'.htmlspecialchars($m['subject_name'], ENT_NOQUOTES, $l['a_meta_charset']).' [';
            // count available questions for each type
            $qstat = '';
            $sqln = 'SELECT question_type, question_difficulty, COUNT(*) as numquestions
				FROM '.K_TABLE_QUESTIONS.'
				WHERE question_subject_id='.$m['subject_id'].'
					AND question_enabled=\'1\'
				GROUP BY question_type, question_difficulty';
            if ($rn = F_db_query($sqln, $db)) {
                while ($mn = F_db_fetch_array($rn)) {
                    $qstat .= '( jml butir '.$mn['numquestions'].', tipe '.$qtype[($mn['question_type']-1)].', tingkat kesulitan '.$mn['question_difficulty'];
                    // count min and max alternative answers
                    $amin = 999999;
                    $amax = 0;
                    $sqla = 'SELECT question_id, COUNT(*) as numanswers
						FROM '.K_TABLE_QUESTIONS.','.K_TABLE_ANSWERS.'
						WHERE answer_question_id=question_id
							AND question_subject_id='.$m['subject_id'].'
							AND question_type='.$mn['question_type'].'
							AND question_difficulty='.$mn['question_difficulty'].'
							AND question_enabled=\'1\'
							AND answer_enabled=\'1\'
						GROUP BY question_id';
                    if ($ra = F_db_query($sqla, $db)) {
                        while ($ma = F_db_fetch_array($ra)) {
                            if ($ma['numanswers'] < $amin) {
                                $amin = $ma['numanswers'];
                            }
                            if ($ma['numanswers'] > $amax) {
                                $amax = $ma['numanswers'];
                            }
                        }
                    } else {
                        F_display_db_error();
                    }
                    if ($amin == 999999) {
                        $amin = 0;
                    }
                    // display minimum alternative answers
                    $qstat .= ', jml opsi '.$amin.')';
                    if ($amax > $amin) {
                        $qstat .= '-'.$amax;
                    }
                }
            } else {
                F_display_db_error();
            }
            echo $qstat.']</option>'.K_NEWLINE;
        }
		echo '</optgroup>';
    } else {
        echo '</select></span></div>'.K_NEWLINE;
        F_display_db_error();
    }

    echo '</select>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
	echo '<div class="d-flex justify-content-end mt-1">'.TMF_modal_button('peringatanBankSoal','<i class="fa fa-exclamation-triangle"></i> PERINGATAN !','btn btn-sm btn-danger').'</div>';
    echo '</div>'.K_NEWLINE;
	
	

$peringatanBankSoalText = '<div class="form-row mb-2">
	<div class="col-md-6 mt-3"><span class="font-weight-bold">Ket. Tipe Soal</span> <ul class="list-group mt-1"><li class="list-group-item p-2"><span class="badge badge-primary">S</span> Pilihan Ganda Jawaban Tunggal</li><li class="list-group-item p-2"><span class="badge badge-success">M</span> Pilihan Ganda Jawaban Ganda</li><li class="list-group-item p-2"><span class="badge badge-warning">T</span> Teks / Uraian</li><li class="list-group-item p-2"><span class="badge badge-alternate">O</span> Ordering / Mengurutkan Jawaban</li></ul></div>
	
	<div class="col-md-6 mt-3"><span class="font-weight-bold">Peringatan</span><ol class="list-group mt-1"><li class="list-group-item">Pastikan di dalam topik yang dipilih tidak ada butir soal yang <b><u>disable (nonaktif)</u></b>. Soal yang dinonaktifkan tidak akan diujikan</li><li class="list-group-item">Pastikan soal <b><u>Single Answer</u></b> (pilihan ganda jawaban tunggal) sudah <b><u>diset kunci jawabannya</u></b>. Jika belum diset maka butir soal tersebut tidak akan diujikan</li><li class="list-group-item">Jika soal pilihan ganda menerapkan bobot opsi, maka opsi yang berbobot 100% tetap harus diset sebagai kunci jawaban (centang pada opsi benar)</li></ol>
	</div></div>';

    echo getFormRowTextInput('tsubset_quantity', $l['w_num_questions'], $l['h_num_questions'], 'Isikan jumlah soal yang akan diujikan dalam tes pada topik yang telah dipilih di atas', $tsubset_quantity, '^([0-9]*)$', 20, false, false, false, '', true);

    echo '<div class="form-row">'.K_NEWLINE;
    echo '<div class="col-md-4">'.K_NEWLINE;
    echo '<label for="tsubset_type" class="font-weight-bold text-capitalize">'.$l['w_type'].'</label>'.K_NEWLINE;
    echo '<span class="formw">'.K_NEWLINE;
    echo '<select class="form-control" name="tsubset_type" id="tsubset_type" size="0" title="'.$l['h_question_type'].'">'.K_NEWLINE;
    echo '<option value="0"';
    if ($tsubset_type == 0) {
        echo ' selected="selected"';
    }
    echo '>*** '.$l['w_all'].' ***</option>'.K_NEWLINE;
    echo '<option value="1"';
    if ($tsubset_type == 1) {
        echo ' selected="selected"';
    }
    echo '>'.$l['w_single_answer'].'</option>'.K_NEWLINE;
    echo '<option value="2"';
    if ($tsubset_type == 2) {
        echo ' selected="selected"';
    }
    echo '>'.$l['w_multiple_answers'].'</option>'.K_NEWLINE;
    echo '<option value="3"';
    if ($tsubset_type == 3) {
        echo ' selected="selected"';
    }
    echo '>'.$l['w_free_answer'].'</option>'.K_NEWLINE;
    echo '<option value="4"';
    if ($tsubset_type == 4) {
        echo ' selected="selected"';
    }
    echo '>'.$l['w_ordering_answer'].'</option>'.K_NEWLINE;
    echo '</select>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;

    echo '<div class="col-md-4">'.K_NEWLINE;
    echo '<label for="tsubset_difficulty" class="font-weight-bold text-capitalize">'.$l['w_question_difficulty'].'</label>'.K_NEWLINE;
    echo '<span class="formw">'.K_NEWLINE;
    echo '<select class="form-control" name="tsubset_difficulty" id="tsubset_difficulty" size="0" title="'.$l['h_question_difficulty'].'">'.K_NEWLINE;
    for ($i = 0; $i <= K_QUESTION_DIFFICULTY_LEVELS; ++$i) {
        echo '<option value="'.$i.'"';
        if ($i == $tsubset_difficulty) {
            echo ' selected="selected"';
        }
        echo '>'.$i.'</option>'.K_NEWLINE;
    }
    echo '</select>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;

	echo '<div class="col-md-4 font-weight-bold">';
    echo getFormRowTextInput('tsubset_answers', $l['w_num_answers'], $l['h_num_answers'], '', $tsubset_answers, '^([0-9]*)$', 20, false, false, false);
	echo '</div>';

echo '</div>'.K_NEWLINE;

echo '<div id="banksoalterpilih" class="invisible"></div>'.K_NEWLINE;

    echo '<div class="rowlll">'.K_NEWLINE;
    F_submit_button_alt("addquestion", 'Sisipkan bank soal', 'Sisipkan bank soal', 'btn btn-primary btn-block');
    echo '</div>'.K_NEWLINE;

    

    echo '</div>'.K_NEWLINE; // end xxx
    echo '</div>'.K_NEWLINE; // end xxx

	
	echo '<div title="'.$l['h_subjects'].'">'.K_NEWLINE;
    echo '<fieldset class="addedQuestions">'.K_NEWLINE;
    $subjlist = '';
	$noBS = 1;
    $sql = 'SELECT * FROM '.K_TABLE_TEST_SUBJSET.'
		WHERE tsubset_test_id=\''.$test_id.'\'
		ORDER BY tsubset_id';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            $subjlist .= '<li class="m-2 border px-2 pb-2 pt-3 rounded position-relative col-md-3 shadow-sm d-flex flex-column justify-content-between">';
			$subjlist .= '<span class="badge badge-success position-absolute" style="top:-4px;right:-4px">'.$noBS.'</span>';
            $subjects_list = '';
            $sqls = 'SELECT subject_id,subject_name,subject_module_id
				FROM '.K_TABLE_SUBJECTS.', '.K_TABLE_SUBJECT_SET.'
				WHERE subject_id=subjset_subject_id
					AND subjset_tsubset_id=\''.$m['tsubset_id'].'\'
				ORDER BY subject_name';
            if ($rs = F_db_query($sqls, $db)) {		
				// $subjects_list .= '<div class="selectedtopicWrapper">';
                while ($ms = F_db_fetch_array($rs)) {
					$sqlmn = 'SELECT module_name
					FROM '.K_TABLE_MODULES.'
					WHERE module_id='.$ms['subject_module_id'];
					if ($rmn = F_db_query($sqlmn, $db)) {
						if ($mmn = F_db_fetch_array($rmn)) {
							$module_name = $mmn[0];
						}
					}
                    $subjects_list .= '<div class="selectedtopic text-truncate"><a class="btn btn-white p-0" href="tce_edit_module.php?module_id='.$ms['subject_module_id'].'" class="moduleName" title="'.$l['t_modules_editor'].'"><i class="pe-7s-notebook"></i>&nbsp;'.htmlspecialchars($module_name, ENT_NOQUOTES, $l['a_meta_charset']).'</a><br/>';
                    $subjects_list .= '<a class="btn p-0" href="tce_edit_subject.php?subject_id='.$ms['subject_id'].'" class="topicName" title="'.$l['t_subjects_editor'].'"><span class="badge badge-light border m-0"><i class="pe-7s-bookmarks"></i>&nbsp;'.htmlspecialchars($ms['subject_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</span></a><a href="tce_show_all_questions.php?order_field=question_enabled+DESC%2C+question_position%2C+question_description&subject_module_id='.$ms['subject_module_id'].'&subject_id='.$ms['subject_id'].'&submitted=1&firstrow=0" class="btn btn-link text-decoration-none p-1"><i class="pe-7s-news-paper"></i> kelola</a></div><hr class="mb-0 mt-1">';
                }
				// $subjects_list .= '</div>';
            } else {
                F_display_db_error();
            }
            // remove last comma + space
            $subjlist .= '<div class="subjects_list_wrapper">'.substr($subjects_list, 0, -22).'</div>';
            $subjlist .= '<div class="subjects_list_footer position-relative">';
            // $subjlist .= '<button type="button" class="btn btn-light btn-sm" data-toggle="tooltip" title="'.$l['h_num_questions'].'" data-original-title="'.$l['h_num_questions'].'">'.$m['tsubset_quantity'].'</button> ';
			$subjlist .= '<button onclick="document.getElementById(\'detailBankSoal'.$noBS.'\').style.display = \'unset\';document.getElementById(\'btnSDetailBS'.$noBS.'\').style.display = \'unset\';this.style.display=\'none\'" id="btnLDetailBS'.$noBS.'" class="btn btn-link btn-block text-left border border-primary border-left-0 border-right-0 border-bottom-0 rounded-0 mt-3 text-decoration-none pl-0" type="button" style="display:unset;border-top-width:0.2em !important"><i class="fa fa-eye"></i> lihat detail</button>'.K_NEWLINE;
			$subjlist .= '<button onclick="document.getElementById(\'detailBankSoal'.$noBS.'\').style.display = \'none\';document.getElementById(\'btnLDetailBS'.$noBS.'\').style.display = \'unset\';this.style.display=\'none\'" id="btnSDetailBS'.$noBS.'" class="btn btn-link btn-block text-left border border-primary border-left-0 border-right-0 border-bottom-0 rounded-0 mt-3 text-decoration-none pl-1" type="button" style="display:none;border-top-width:0.2em !important"><i class="fa fa-eye-slash"></i> sembunyikan detail</button>'.K_NEWLINE;
			$subjlist .= '<div style="display:none" id="detailBankSoal'.$noBS.'">';
			$subjlist .= '<ol class="list-group">';
			$noBS++;
			$subjlist .= '<li class="list-group-item p-2">'.$l['h_num_questions'].' <span class="badge badge-success badge-pill">'.$m['tsubset_quantity'].'</span></li>';
            // $subjlist .= '<acronym class="offbox" title="'.$l['h_question_type'].'">';
            $subjlist .= '<li class="list-group-item p-2">'.$l['h_question_type'].' <span class="badge badge-success badge-pill">';
            if ($m['tsubset_type'] > 0) {
                $subjlist .= $qtype[($m['tsubset_type'] - 1)];
            } else {
                // all question types
                $subjlist .= '*';
            }
            $subjlist .= '</span></li>';
            // $subjlist .= '<acronym class="offbox" title="'.$l['h_question_difficulty'].'">'.$m['tsubset_difficulty'].'</acronym> ';
            $subjlist .= '<li class="list-group-item p-2">'.$l['h_question_difficulty'].' <span class="badge badge-success badge-pill">'.$m['tsubset_difficulty'].'</span></li>';
            $subjlist .= '<li class="list-group-item p-2">'.$l['h_num_answers'].' <span class="badge badge-success badge-pill">'.$m['tsubset_answers'].'</span></li>';
            // $subjlist .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?link_action=deletesubject&amp;test_id='.$test_id.'&amp;tsubset_id='.$m['tsubset_id'].'" title="'.$l['h_delete'].'" class="btn btn-danger" onclick="return confirm(\'Yakin ingin menghapus ?\')"><i class="fas fa-trash"></i> Hapus</a>';
            $subjlist .= '</li>'.K_NEWLINE;
            $subjlist .= '</ol>'.K_NEWLINE;			
            $subjlist .= '</div>'.K_NEWLINE;
			$subjlist .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?link_action=deletesubject&amp;test_id='.$test_id.'&amp;tsubset_id='.$m['tsubset_id'].'" title="'.$l['h_delete'].'" class="btn btn-link position-absolute btn-sm text-danger py-0 px-1 text-decoration-none" style="right:-5px;top:23px" onclick="return confirm(\'Yakin ingin menghapus ?\')"><i class="fas fa-trash"></i> Hapus</a>';
            $subjlist .= '</div>'.K_NEWLINE;
			

            // update test_max_score
            $test_max_score_new += $test_score_right * $m['tsubset_difficulty'] * $m['tsubset_quantity'];
            if (isset($test_max_score) and ($test_max_score_new != $test_max_score)) {
                $test_max_score = $test_max_score_new;
                // update max score on test table
                $sqlup = 'UPDATE '.K_TABLE_TESTS.' SET test_max_score='.$test_max_score.' WHERE test_id='.$test_id.'';
                if (!$rup = F_db_query($sqlup, $db)) {
                    F_display_db_error(false);
                }
            }
        }
        if (strlen($subjlist) > 0) {
			// kondisi jika SUDAH ada bank soal
			echo '<div class="card border shadow-none mt-3">'; //start card banksoalterpilih
			echo '<div class="card-header bg-success text-white"><i class="pe-7s-pin"></i>&nbsp;Bank Soal Terpilih</div>';
			echo '<div class="card-body px-1 pb-0 pt-2">';
            echo '<ul class="list-group list-unstyled flex-row flex-wrap">'.K_NEWLINE.$subjlist.'</ul>'.K_NEWLINE;
			echo '</div>'; //close card-body banksoalterpilih
			echo '</div>'; //close card banksoalterpilih
			
			echo '<div class="card mt-3 bg-alternate">'; //start card max score
			echo '<div class="card-body text-white">';
			echo '<h5 class="m-0">'.$l['w_max_score'].'<span class="ml-2 badge badge-light badge-pill text-alternate">'.$test_max_score_new.'</span></h5>';
			echo '</div>'; //close card-body max score
			echo '</div>'; //close card max score
        }else{
			// kondisi jika belum ada bank soal
		}
    } else {
        F_display_db_error();
    }
    // echo $l['w_max_score'].': '.$test_max_score_new;
    echo '<input type="hidden" name="test_max_score" id="test_max_score" value="'.$test_max_score_new.'" />';
    echo '</fieldset>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
	
    if (isset($test_max_score_new) and ($test_max_score_new > 0)) {
		
	// generate test data / offline page
    $generateTest .= '<div class="card">'.K_NEWLINE;
    $generateTest .= '<div class="card-header">'.K_NEWLINE;
	$generateTest .= '<label class="m-0" for="test_num"><i class="pe-7s-repeat"></i> Generate Halaman Ujian</label>'.K_NEWLINE;
	$generateTest .= '</div>'.K_NEWLINE;
	$generateTest .= '<div class="card-body">'.K_NEWLINE;
	$generateTest .= '<div class="mb-3">Bagian ini merupakan jalan pintas dari halaman <a href="tmf_generate.php?test_id='.$test_id.'" target="blank">Generate Halaman Ujian</a> yang memiliki fungsi yang sama yaitu menciptakan halaman tes dari sisi admin, sehingga mempercepat proses loading soal.<div class="alert alert-danger py-2 px-3 mt-2"><span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;Peringatan</span>&nbsp;Karena aktivitas ini membutuhkan sumber daya database yang cukup besar, maka untuk keamanan ujian, dimohon TIDAK melakukan Generate Halaman Ujian saat proses ujian sedang berlangsung</div></div>'.K_NEWLINE;
	$generateTest .= '<a class="btn btn-primary btn-block text-white" id="generate_test_link" title="Generate test data" class="" onclick="" style=""><i class="pe-7s-repeat"></i> '.$l['w_generate'].'</a><span class="d-block"><div id="generated"><span id="total_user"></span><span id="generated_user"></span><span id="done"></span>
</div></div>';
	$generateTest .= '</span>'.K_NEWLINE;
	// $generateTest .= '</div>'.K_NEWLINE;
	
        $pdfTest .= '<div class="card my-3">'.K_NEWLINE;
        $pdfTest .= '<div class="card-header"><i class="fa fa-file-pdf"></i>&nbsp;<label class="m-0" for="test_num">'.$l['w_pdf_offline_test'].'</label></div>'.K_NEWLINE;
        // $pdfTest .= '<span class="formw">'.K_NEWLINE;
		$pdfTest .= '<div class="card-body">'.K_NEWLINE;
		$pdfTest .= '<div class="input-group">'.K_NEWLINE;
        $pdfTest .= '<input class="form-control input-group-prepend" type="text" name="test_num" id="test_num" value="'.$test_num.'" size="4" maxlength="10" title="'.$l['h_pdf_offline_test'].'" />'.K_NEWLINE;
        $pdfTest .= '<a href="tce_pdf_testgen.php?test_id='.$test_id.'&amp;num='.$test_num.'" title="'.$l['h_pdf_offline_test'].'" class="btn btn-primary input-group-append" onclick="pdfWindow=window.open(\'tce_pdf_testgen.php?test_id='.$test_id.'&amp;num=\' + document.getElementById(\'form_testeditor\').test_num.value + \'\',\'pdfWindow\',\'dependent,menubar=yes,resizable=yes,scrollbars=yes,status=yes,toolbar=yes\'); return false;" style="flex:0 0 7em"><i class="align-self-center fa fa-file-pdf"></i>&nbsp;'.$l['w_generate'].'</a>';
        // $pdfTest .= '</span>&nbsp;'.K_NEWLINE;
        $pdfTest .= '</div>'.K_NEWLINE;
        $pdfTest .= '</div>'.K_NEWLINE;
        $pdfTest .= '</div>'.K_NEWLINE;
		
		// $generateTest .= '<div class="rowlll">'.K_NEWLINE;
	// $generateTest .= '<label for="test_num">Hasil tes</label>'.K_NEWLINE;
	// $generateTest .= '<span class="formw" style="margin:0">'.K_NEWLINE;
	$generateTest .= '<div class="card-footer"><a target="blank" id="buka_hasil_tes" href="tce_show_result_allusers.php?test_id='.$test_id.'&opentestresult=1" title="Buka hasil tes" class="btn btn-success btn-block" onclick=""><i class="pe-7s-cup"></i> Buka Hasil Tes</a>';
	// $generateTest .= '</span>&nbsp;'.K_NEWLINE;
	$generateTest .= '</div>'.K_NEWLINE;
	$generateTest .= '</div>'.K_NEWLINE;
	
	$bank_soal_warning .= '<script>'.K_NEWLINE;
		$bank_soal_warning .= '$("#banksoalwarning").html("<div class=\"alert bg-primary p-0 text-right\"><div class=\"p-2\"><a id=\'banksoalbtn\' class=\"btn btn-sm bg-white text-primary\"><i class=\"fa fa-plus-square\"></i>&nbsp;Sisipkan bank soal</a><a id=\'banksoalterpilihbtn\' class=\"btn btn-sm bg-white text-primary ml-1\"><i class=\"fa fa-thumbtack\"></i>&nbsp;Bank soal terpilih</a></div></div>")'.K_NEWLINE;
		$bank_soal_warning .= '$("#banksoalwarning").show();'.K_NEWLINE;
		$bank_soal_warning .= '</script>'.K_NEWLINE;
		
    }
	else{
		$bank_soal_warning .= '<script>'.K_NEWLINE;
		$bank_soal_warning .= '$("#banksoalwarning").html("<div class=\"alert bg-danger p-0 text-right text-white mb-3 rounded\"><div class=\"p-3\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;Lengkapi ujian ini dengan bank soal <a class=\'btn btn-dark py-1 px-2 opacity-5\' id=\'banksoalbtn\'>klik disini</a> untuk menambahkan bank soal ke dalam ujian</div>")'.K_NEWLINE;
		$bank_soal_warning .= '$("#banksoalwarning").show();'.K_NEWLINE;
		$bank_soal_warning .= '</script>'.K_NEWLINE;
	}
}
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

// echo '<div class="pagehelp">'.$l['hp_edit_test'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo $generateTest;
echo $pdfTest;
echo '</div>'.K_NEWLINE;

// javascript controls
echo '<script type="text/javascript">'.K_NEWLINE;
echo '//<![CDATA['.K_NEWLINE;
echo 'function JF_check_random_boxes() {'.K_NEWLINE;
echo ' if (document.getElementById(\'test_random_questions_select\').checked==true){document.getElementById(\'test_random_questions_order\').checked=true;}'.K_NEWLINE;
echo ' if ((document.getElementById(\'test_random_questions_order\').checked==false)&&(document.getElementById(\'test_random_questions_select\').checked==true)){document.getElementById(\'test_random_questions_order\').checked=true;}'.K_NEWLINE;
echo ' if (document.getElementById(\'test_random_questions_order\').checked==false){document.getElementById(\'select_questions_order_mode\').style.display="block";}else{document.getElementById(\'select_questions_order_mode\').style.display="none";}'.K_NEWLINE;
echo ' if (document.getElementById(\'test_random_answers_select\').checked==true){document.getElementById(\'test_random_answers_order\').checked=true;}'.K_NEWLINE;
echo ' if ((document.getElementById(\'test_random_answers_order\').checked==false)&&(document.getElementById(\'test_random_answers_select\').checked==true)){document.getElementById(\'test_random_answers_order\').checked=true;}'.K_NEWLINE;
echo ' if (document.getElementById(\'test_random_answers_order\').checked==false){document.getElementById(\'select_answers_order_mode\').style.display="block";}else{document.getElementById(\'select_answers_order_mode\').style.display="none";}'.K_NEWLINE;
echo '}'.K_NEWLINE;
echo 'JF_check_random_boxes();'.K_NEWLINE;
echo '//]]>'.K_NEWLINE;
echo '</script>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');
//============================================================+
// END OF FILE
//============================================================+
// echo TMF_modal_info('infoSisipkanBankSoal','Info - Sisipkan Bank Soal', 'Anda bisa memasukkan bank soal yang telah diinput pada proses sebelumnya ke dalam tes ini. Satu tes boleh berisi beberapa bank soal.');
if(isset($peringatanBankSoalText)){
	echo TMF_modal_info('peringatanBankSoal','Peringatan', $peringatanBankSoalText);
}

echo $bank_soal_warning;

?>
<script>
$("#banksoalwarning").scrollToFixed({
	fixed: function(){
		$(this).addClass('w-100 fixed-left');
		$(this).find('.alert').addClass('rounded-0 shadow');
	},
	postFixed: function(){
		$(this).removeClass('w-100 fixed-left');
		$(this).find('.alert').removeClass('rounded-0 shadow');
	}
});

$("#banksoalbtn").click(function(){
	$("html, body").animate({
		scrollTop: $("#banksoal").offset().top
	},500);
});

$("#banksoalterpilihbtn").click(function(){
	$("html, body").animate({
		scrollTop: $("#banksoalterpilih").offset().top
	},500);
})

$('#subject_id').val([]).trigger('change');

</script>

<script>
if(document.getElementById("confirmupdate")){
	let confUpdate = document.getElementById("confirmupdate");
	if(confUpdate.checked == false){
		confUpdate.click();
	}
	confUpdate.style.display = "none";
}

function checkTotalUser(){
$.ajax({
		'url': 'tmf_generate_test.php?check_total_user&test_id=<?php echo $test_id; ?>',
		'type': 'GET',
		'success': function(result){$("div#generated").prop("class", "alert alert-success mt-2 small");$("div#generated span#total_user").html("Sistem sedang melakukan generate halaman ujian untuk : "+result+" peserta.")}
});
}
function F_genDur(){	
var gen_tstart = $("span#gen_start").text();
var gen_tend = $("input#timer").val();
var genDur = gen_tend - gen_tstart;
return genDur
}
function generateTest(){	
$.ajax({
		'url': 'tmf_generate_test.php?test_id=<?php echo $test_id; ?>',
		'type': 'GET',
		'beforeSend': function(){$("div#generated").prop("class", "alert alert-warning mt-2 small");$("div#generated span#done").html("<b><span class='text-warning'>&infin; LOADING . . . </span></b>")},
		'success': function(result){$("div#generated").prop("class", "alert alert-success mt-2 small");$("div#generated span#done").html("<b><span class='text-success'>&check; SELESAI<br/>"+result+"</span></b>");$("p#gen_end_p").show();$("span#gen_end").text($("input#timer").val());$("span#total_user").hide()}
});
}
function delGenTest(){	
$.ajax({
		'url': 'tmf_generate_test.php?del_generated_test&test_id=<?php echo $test_id; ?>',
		'type': 'GET',
		'beforeSend': function(){$("a#del_gen_test").text("Mohon Tunggu")},
		'success': function(result){alert("Selesai menghapus data test");location.reload();},
});
}
function checkGeneratedTest(){	
$.ajax({
		'url': 'tmf_generate_test.php?check_generated_test&test_id=<?php echo $test_id; ?>',
		'type': 'GET',
		'success': function(result){$("div#generated").prop("class", "alert alert-success mt-2 small");$("div#generated span#generated_user").html("sudah tergenerate sebanyak : "+result+" peserta.")}
});
}
$("a#generate_test_link").click(function(){
$("p#gen_start_p").show();
$("span#gen_start").text($("input#timer").val());
	checkTotalUser();
	generateTest();
})
$("a#del_gen_test").click(function(){
if(confirm("Continue?")){
	delGenTest();
}})

</script>