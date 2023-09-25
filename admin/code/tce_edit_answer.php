<style>
#mmCloseBtn{
    align-self: center;
	padding: 1em 0.85em !important;
}
.cke_dialog_contents tr:first-child {
    color: unset;
    background: unset;
}
</style>
<?php
//============================================================+
// File name   : tce_edit_answer.php
// Begin       : 2004-04-27
// Last Update : 2020-05-06
//
// Description : Edit answers.
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
 * Display form to edit exam answers.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2004-04-27
 */

/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_ANSWERS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_answers_editor'];
$thispage_title_icon = '<i class="pe-7s-pin icon-gradient bg-sunny-morning"></i> ';
$thispage_help = $l['hp_edit_answer'];

require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../code/tce_functions_tcecode_editor.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
?>
<script type="text/javascript" src="../../shared/jscripts/ckeditor/ckeditor.js"></script>
<script>
	function ckEditor(a,b){
		if(CKEDITOR.instances[a]){
			CKEDITOR.instances[a].destroy();
			document.getElementById(b).textContent = 'Load Editor';
			document.getElementById(b).classList.remove("bg-red");
			
		}else{
			// CKEDITOR.config.extraPlugins = "base64image";
			CKEDITOR.config.imageUploadUrl = 'tmf_image_upload_url.php';
			CKEDITOR.replace( a ,{
				filebrowserBrowseUrl : '../../filemanager/dialog.php?akey=<?php echo K_RANDOM_SECURITY; ?>&type=2&editor=ckeditor&fldr=',
				filebrowserUploadUrl : '../../filemanager/dialog.php?responseType=json&akey=<?php echo K_RANDOM_SECURITY; ?>&type=2&editor=ckeditor&fldr=',
				filebrowserImageBrowseUrl : '../../filemanager/dialog.php?akey=<?php echo K_RANDOM_SECURITY; ?>&type=2&editor=ckeditor&fldr='
				// uploadUrl = '../../xxx/upload.php'
			});
			document.getElementById(b).textContent = 'Unload Editor';
			document.getElementById(b).classList.add("bg-red");
			
		}
	}
</script>
<?php
// upload multimedia files
$uploadedfile = array();
for ($id = 0; $id < 2; ++$id) {
    if (isset($_POST['sendfile'.$id]) and ($_FILES['userfile'.$id]['name'])) {
        require_once('../code/tce_functions_upload.php');
        $uploadedfile['\''.$id.'\''] = F_upload_file('userfile'.$id, K_PATH_CACHE);
    }
}

// comma separated list of required fields
$_REQUEST['ff_required'] = 'answer_description';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_description'], ENT_COMPAT, $l['a_meta_charset']);

// set default values
if (isset($_REQUEST['subject_module_id'])) {
    $subject_module_id = intval($_REQUEST['subject_module_id']);
} else {
    $subject_module_id = 0;
}
if (isset($_REQUEST['question_subject_id'])) {
    $question_subject_id = intval($_REQUEST['question_subject_id']);
} else {
    $question_subject_id = 0;
}
if (!isset($_REQUEST['answer_id'])) {
    $answer_id = 0;
} else {
    $answer_id = intval($_REQUEST['answer_id']);
}
if (!isset($_REQUEST['answer_isright']) or (empty($_REQUEST['answer_isright']))) {
    $answer_isright = false;
} else {
    $answer_isright = F_getBoolean($_REQUEST['answer_isright']);
}
if (!isset($_REQUEST['answer_enabled']) or (empty($_REQUEST['answer_enabled']))) {
    $answer_enabled = false;
} else {
    $answer_enabled = F_getBoolean($_REQUEST['answer_enabled']);
}
if (isset($_REQUEST['changemodule']) and ($_REQUEST['changemodule'] > 0)) {
    $changemodule = 1;
} elseif (isset($_REQUEST['selectmodule'])) {
    $changemodule = 1;
} else {
    $changemodule = 0;
}
if (isset($_REQUEST['changesubject']) and ($_REQUEST['changesubject'] > 0)) {
    $changesubject = 1;
} elseif (isset($_REQUEST['selectsubject'])) {
    $changesubject = 1;
} else {
    $changesubject = 0;
}
if (isset($_REQUEST['changecategory']) and ($_REQUEST['changecategory'] > 0)) {
    $changecategory = 1;
} elseif (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
} else {
    $changecategory = 0;
}
if (!isset($_REQUEST['answer_position']) or empty($_REQUEST['answer_position'])) {
    $answer_position = 0;
} else {
    $answer_position = intval($_REQUEST['answer_position']);
}
if (!isset($_REQUEST['max_position']) or empty($_REQUEST['max_position'])) {
    $max_position = 0;
} else {
    $max_position = intval($_REQUEST['max_position']);
}
if (isset($_REQUEST['prev_answer_position'])) {
    $prev_answer_position = intval($_REQUEST['prev_answer_position']);
} else {
    $prev_answer_position = 0;
}
if (isset($_REQUEST['subject_id'])) {
    $subject_id = intval($_REQUEST['subject_id']);
} else {
    $subject_id = 0;
}
if (isset($_REQUEST['answer_question_id'])) {
    $answer_question_id = intval($_REQUEST['answer_question_id']);
} else {
    $answer_question_id =  0;
}
if (!isset($answer_keyboard_key) or (empty($answer_keyboard_key))) {
    $answer_keyboard_key = '';
} else {
    $answer_keyboard_key = intval($answer_keyboard_key);
}
if (isset($_REQUEST['answer_description'])) {
    $answer_description = utrim($_REQUEST['answer_description']);
    if (function_exists('normalizer_normalize')) {
    // normalize UTF-8 string based on settings
        $answer_description = F_utf8_normalizer($answer_description, K_UTF8_NORMALIZATION_MODE);
    }
}

if (isset($_REQUEST['answer_weight'])) {
    $answer_weight = intval($_REQUEST['answer_weight']);
} else {
    $answer_weight =  null;
}

if (isset($_REQUEST['answer_explanation'])) {
    $answer_explanation = utrim($_REQUEST['answer_explanation']);
} else {
    $answer_explanation = '';
}
$qtype = array('S', 'M', 'T', 'O'); // question types

// check user's authorization
if ($answer_id > 0) {
    $sql = 'SELECT subject_module_id,question_subject_id,answer_question_id
		FROM '.K_TABLE_SUBJECTS.', '.K_TABLE_QUESTIONS.', '.K_TABLE_ANSWERS.'
		WHERE subject_id=question_subject_id
			AND question_id=answer_question_id
			AND answer_id='.$answer_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            // check user's authorization for parent module
            if ((!F_isAuthorizedUser(K_TABLE_MODULES, 'module_id', $m['subject_module_id'], 'module_user_id'))
                and (!F_isAuthorizedUser(K_TABLE_SUBJECTS, 'subject_id', $m['question_subject_id'], 'subject_user_id'))) {
                F_print_error('ERROR', $l['m_authorization_denied'], true);
            }
        }
    } else {
        F_display_db_error();
    }
}

switch ($menu_mode) {
    case 'delete':{
        F_stripslashes_formfields();
        // check if this record is used (test_log)
        if (!F_check_unique(K_TABLE_LOG_ANSWER, 'logansw_answer_id='.$answer_id.'')) {
            //this record will be only disabled and not deleted because it's used
            $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
				answer_enabled=\'0\'
				WHERE answer_id='.$answer_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error();
            }
            F_print_error('WARNING', $l['m_disabled_vs_deleted']);
        } else {
            // ask confirmation
            // F_print_error('WARNING', $l['m_delete_confirm']);
            ?>
            <div class="confirmbox">
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" id="form_delete">
            <div>
            <input type="hidden" name="answer_id" id="answer_id" value="<?php echo $answer_id; ?>" />
            <input type="hidden" name="subject_module_id" id="subject_module_id" value="<?php echo $subject_module_id; ?>" />
            <input type="hidden" name="question_subject_id" id="question_subject_id" value="<?php echo $question_subject_id; ?>" />
            <input type="hidden" name="answer_question_id" id="answer_question_id" value="<?php echo $answer_question_id; ?>" />
            <input type="hidden" name="answer_description" id="answer_description" value="<?php echo $answer_description; ?>" />
            <input type="hidden" name="answer_explanation" id="answer_explanation" value="<?php echo $answer_explanation; ?>" />
			<input type="hidden" name="answer_weight" id="answer_weight" value="<?php echo $answer_weight; ?>" />
			
            <?php
			echo '<div class="alert alert-warning fade show" role="alert">'.K_NEWLINE;
			echo '<h4 class="alert-heading">'.$l['m_delete_confirm'].'</h4>'.K_NEWLINE;
			echo '<p>Apakah yakin ingin melanjutkan proses penghapusan?</p>'.K_NEWLINE;
			echo '<hr>'.K_NEWLINE;
            F_submit_button_alt('forcedelete', $l['w_delete'], $l['h_delete'], 'mr-2 btn btn-danger');
            F_submit_button_alt('cancel', $l['w_cancel'], $l['h_cancel'], 'btn-transition btn btn-outline-danger');
            echo F_getCSRFTokenField().K_NEWLINE;
            ?>
            </div>
            </form>
            </div>
        <?php
        }
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields(); // Delete
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)

            $sql = 'START TRANSACTION';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                break;
            }

            // get answer position (if defined)
            $sql = 'SELECT answer_position
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_id='.$answer_id.'
				LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $answer_position = $m['answer_position'];
                }
            } else {
                F_display_db_error();
            }
            // delete answer
            $sql = 'DELETE FROM '.K_TABLE_ANSWERS.' WHERE answer_id='.$answer_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                F_db_query('ROLLBACK', $db); // rollback transaction
            } else {
                $answer_id=false;
                // adjust questions ordering
                if ($answer_position > 0) {
                    $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
						answer_position=answer_position-1
						WHERE answer_question_id='.$answer_question_id.'
							AND answer_position>'.$answer_position.'';
                    if (!$r = F_db_query($sql, $db)) {
                        F_display_db_error(false);
                        F_db_query('ROLLBACK', $db); // rollback transaction
                    }
                }

                $sql = 'COMMIT';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                    break;
                }

                F_print_error('MESSAGE', $l['m_deleted']);
            }
        }
        break;
    }

    case 'update':{ // Update
	$affectedtestlogid = 'SELECT (logansw_testlog_id) FROM '.K_TABLE_LOG_ANSWER.' WHERE logansw_answer_id='.$answer_id;
		if($r = F_db_query($affectedtestlogid, $db)) {
			while($m = F_db_fetch_array($r)) {
				if(file_exists(K_PATH_QBLOCK.$m[0].'.json')){
					// echo $m[0];
					unlink(K_PATH_QBLOCK.$m[0].'.json');
				}
			}
		}
		
        // check if the confirmation chekbox has been selected
        if (!isset($_REQUEST['confirmupdate']) or ($_REQUEST['confirmupdate'] != 1)) {
            F_print_error('WARNING', $l['m_form_missing_fields'].': '.$l['w_confirm'].' &rarr; '.$l['w_update']);
            F_stripslashes_formfields();
            break;
        }
        if ($formstatus = F_check_form_fields()) {
            // get previous answer position (if defined)
            $prev_answer_position = 0;
            $sql = 'SELECT answer_position
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_id='.$answer_id.'
				LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $prev_answer_position = intval($m['answer_position']);
                }
            } else {
                F_display_db_error();
            }

            // check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
			/** TMF Enable Answer Editing when test ongoing
            if (!F_check_unique(K_TABLE_LOG_ANSWER, 'logansw_answer_id='.$answer_id.'')) {
                F_print_error('WARNING', $l['m_update_restrict']);

                // when the answer is disabled, the position is discarded
                if (!$answer_enabled) {
                    $answer_position = 0;
                } else {
                    $answer_position = $prev_answer_position;
                }
                // enable or disable record
                $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
					answer_enabled=\''.$answer_enabled.'\',
					answer_position='.F_zero_to_null($answer_position).'
					WHERE answer_id='.$answer_id.'';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                } else {
                    $strmsg = $l['w_record_status'].': ';
                    if ($answer_enabled) {
                        $strmsg .= $l['w_enabled'];
                    } else {
                        $strmsg .= $l['w_disabled'];
                    }
                    F_print_error('MESSAGE', $strmsg);
                }
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
			**/
            // check if alternate key is unique
            if (K_DATABASE_TYPE == 'ORACLE') {
                $chksql = 'dbms_lob.instr(answer_description,\''.F_escape_sql($db, $answer_description).'\',1,1)>0';
            } elseif ((K_DATABASE_TYPE == 'MYSQL') and K_MYSQL_QA_BIN_UNIQUITY) {
                $chksql = 'answer_description=\''.F_escape_sql($db, $answer_description).'\' COLLATE utf8_bin';
            } else {
                $chksql = 'answer_description=\''.F_escape_sql($db, $answer_description).'\'';
            }
            if ($answer_position > 0) {
                $chksql .= ' AND answer_position='.$answer_position;
            }
            if (!F_check_unique(K_TABLE_ANSWERS, $chksql.' AND answer_question_id='.$answer_question_id, 'answer_id', $answer_id)) {
                F_print_error('WARNING', $l['m_duplicate_answer']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }

            $sql = 'START TRANSACTION';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                break;
            }

            // when the answer is disabled, the position is discarded
            if (!$answer_enabled) {
                $answer_position = 0;
            }
            if ($answer_position > $max_position) {
                $answer_position = $max_position;
            }
            // arrange positions if necessary
            if ($answer_position != $prev_answer_position) {
                if ($answer_position > 0) {
                    if ($prev_answer_position > 0) {
                        // swap positions
                        $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
							answer_position='.$prev_answer_position.'
							WHERE answer_question_id='.$answer_question_id.'
								AND answer_position='.$answer_position.'';
                    } elseif ($prev_answer_position == 0) {
                        // right shift positions
                        $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
							answer_position=answer_position+1
							WHERE answer_question_id='.$answer_question_id.'
								AND answer_position>='.$answer_position.'';
                    }
                } else {
                    // left shift positions
                    $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
						answer_position=answer_position-1
						WHERE answer_question_id='.$answer_question_id.'
							AND answer_position>'.$prev_answer_position.'';
                }
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                    F_db_query('ROLLBACK', $db); // rollback transaction
                }
            }
            // update field
            $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
				answer_question_id='.$answer_question_id.',
				answer_description=\''.F_escape_sql($db, $answer_description).'\',
				answer_explanation='.F_empty_to_null($answer_explanation).',
				answer_isright=\''.intval($answer_isright).'\',
				answer_enabled=\''.intval($answer_enabled).'\',
				answer_position='.F_zero_to_null($answer_position).',
				answer_keyboard_key='.F_empty_to_null($answer_keyboard_key).',
				answer_weight=\''.intval($answer_weight).'\'
				WHERE answer_id='.$answer_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                F_db_query('ROLLBACK', $db); // rollback transaction
            } else {
                F_print_error('MESSAGE', $l['m_updated']);
            }

            $sql = 'COMMIT';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                break;
            }
        }
        break;
    }

    case 'add':{ // Add
        if ($formstatus = F_check_form_fields()) {
            // check if alternate key is unique
            if (K_DATABASE_TYPE == 'ORACLE') {
                $chksql = 'dbms_lob.instr(answer_description,\''.F_escape_sql($db, $answer_description).'\',1,1)>0';
            } elseif ((K_DATABASE_TYPE == 'MYSQL') and K_MYSQL_QA_BIN_UNIQUITY) {
                $chksql = 'answer_description=\''.F_escape_sql($db, $answer_description).'\' COLLATE utf8_bin';
            } else {
                $chksql = 'answer_description=\''.F_escape_sql($db, $answer_description).'\'';
            }
            if ($answer_position > 0) {
                $chksql .= ' AND answer_position='.$answer_position;
            }
            if (!F_check_unique(K_TABLE_ANSWERS, $chksql.' AND answer_question_id='.$answer_question_id)) {
                F_print_error('WARNING', $l['m_duplicate_answer']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }

            $sql = 'START TRANSACTION';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                break;
            }
            // adjust questions ordering
            if ($answer_position > 0) {
                $sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
					answer_position=answer_position+1
					WHERE answer_question_id='.$answer_question_id.'
						AND answer_position>='.$answer_position.'';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                    F_db_query('ROLLBACK', $db); // rollback transaction
                }
            }
            $sql = 'INSERT INTO '.K_TABLE_ANSWERS.' (
				answer_question_id,
				answer_description,
				answer_explanation,
				answer_isright,
				answer_enabled,
				answer_position,
				answer_keyboard_key,
				answer_weight
				) VALUES (
				'.$answer_question_id.',
				\''.F_escape_sql($db, $answer_description).'\',
				'.F_empty_to_null($answer_explanation).',
				\''.intval($answer_isright).'\',
				\''.intval($answer_enabled).'\',
				'.F_zero_to_null($answer_position).',
				'.F_empty_to_null($answer_keyboard_key).',
				\''.intval($answer_weight).'\'
				)';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                F_db_query('ROLLBACK', $db); // rollback transaction
            } else {
                $answer_id = F_db_insert_id($db, K_TABLE_ANSWERS, 'answer_id');
            }
            $sql = 'COMMIT';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
                break;
            }else{
				F_print_error('MESSAGE', 'Opsi berhasil ditambahkan');
			}
        }
        break;
    }

    case 'clear':{ // Clear form fields
        $answer_description = '';
        $answer_explanation = '';
		$answer_weight = null;
        $answer_isright = false;
        $answer_enabled = true;
        $answer_position = 0;
        $answer_keyboard_key = '';
        break;
    }

    default :{
        break;
    }
} //end of switch

// select default module/subject (if not specified)
if ($subject_module_id <= 0) {
    $sql = F_select_modules_sql().' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $subject_module_id = $m['module_id'];
        } else {
            $subject_module_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

// select default subject
if (($changemodule > 0) or ($question_subject_id <= 0)) {
    $sql = F_select_subjects_sql('subject_module_id='.$subject_module_id.'').' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $question_subject_id = $m['subject_id'];
        } else {
            $question_subject_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

// select default question
if (($changesubject > 0) or ($changemodule > 0)     or ($answer_question_id <= 0)) {
    $sql = 'SELECT question_id
		FROM '.K_TABLE_QUESTIONS.'
		WHERE question_subject_id='.$question_subject_id.'
		ORDER BY ';
    if (K_DATABASE_TYPE == 'ORACLE') {
        $sql .= 'CAST(question_description as varchar2(100))';
    } else {
        $sql .= 'question_description LIMIT 1';
    }
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $answer_question_id = $m['question_id'];
        } else {
            $answer_question_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

// --- Initialize variables
if ($formstatus) {
    if ($menu_mode != 'clear') {
        if (($changemodule > 0) or ($changesubject > 0) or ($changecategory > 0) or empty($answer_id)) {
            $answer_id = 0;
            $answer_description = '';
            $answer_explanation = '';
            $answer_isright = false;
            $answer_enabled = true;
            $answer_position = 0;
            $answer_keyboard_key = '';
			$answer_weight = null;
        } else {
            $sql = 'SELECT *
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_id='.$answer_id.'
				LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $answer_id = $m['answer_id'];
                    $answer_question_id = $m['answer_question_id'];
                    $answer_description = $m['answer_description'];
                    $answer_explanation = $m['answer_explanation'];
                    $answer_isright = F_getBoolean($m['answer_isright']);
                    $answer_enabled = F_getBoolean($m['answer_enabled']);
                    $answer_position = $m['answer_position'];
                    $answer_keyboard_key = $m['answer_keyboard_key'];
					$answer_weight = $m['answer_weight'];
                } else {
                    $answer_description = '';
                    $answer_explanation = '';
                    $answer_isright = false;
                    $answer_enabled = true;
                    $answer_position = 0;
                    $answer_keyboard_key = '';
					$answer_weight = null;
                }
            } else {
                F_display_db_error();
            }
        }
    }
}

if (($subject_module_id <= 0) or ($question_subject_id <= 0) or ($answer_question_id <= 0)) {
    echo '<div class="main-card mb-3 card p-3">'.K_NEWLINE;
	echo '<span class="nav-item border border-primary rounded card-shadow-primary rounded-pill">'.K_NEWLINE;
    echo '<a href="tce_edit_question.php" title="'.$l['t_questions_editor'].'" class="nav-link"><i class="nav-link-icon pe-7s-help1"></i>'.$l['t_questions_editor'].'</a>'.K_NEWLINE;
    // echo '<div class="pagehelp">'.$l['hp_edit_answer'].'</div>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
    require_once('../code/tce_page_footer.php');
    exit;
}

echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'inserttag.js" type="text/javascript"></script>'.K_NEWLINE;
if (K_ENABLE_VIRTUAL_KEYBOARD) {
    echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'vk/vk_easy.js?vk_skin=default" type="text/javascript"></script>'.K_NEWLINE;
}

echo '<div class="main-card mb-3 card">'.K_NEWLINE;

if($answer_id>0){
	$form_title = '<i class="pe-7s-pen mr-2"></i>Edit Jawaban';
}else{
	$form_title = '<i class="pe-7s-plus mr-2"></i>Tambah Jawaban';
}

echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_answereditor">'.K_NEWLINE;
echo '<div class="card-header text-left">'.$form_title.'</div>'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="subject_module_id">'.$l['w_module'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<input type="hidden" name="changemodule" id="changemodule" value="" />'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="subject_module_id" id="subject_module_id" onchange="document.getElementById(\'form_answereditor\').changemodule.value=1; document.getElementById(\'form_answereditor\').submit();" title="'.$l['w_module'].'">'.K_NEWLINE;
$sql = F_select_modules_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['module_id'].'"';
        if ($m['module_id'] == $subject_module_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. ';
        if (F_getBoolean($m['module_enabled'])) {
            echo '+';
        } else {
            echo '-';
        }
        echo ' '.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'&nbsp;</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectmodule');

echo '<div class="input-group mt-2">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="question_subject_id">'.$l['w_subject'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<input type="hidden" name="changesubject" id="changesubject" value="" />'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="question_subject_id" id="question_subject_id"  onchange="document.getElementById(\'form_answereditor\').changesubject.value=1; document.getElementById(\'form_answereditor\').submit();" title="'.$l['h_subject'].'">'.K_NEWLINE;
$countitem = 1; //number of already inserted answers
$sql = F_select_subjects_sql('subject_module_id='.$subject_module_id);
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['subject_id'].'"';
        if ($m['subject_id'] == $question_subject_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. ';
        if (F_getBoolean($m['subject_enabled'])) {
            echo '+';
        } else {
            echo '-';
        }
        echo ' '.htmlspecialchars(F_remove_tcecode($m['subject_name']), ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectsubject');

echo '<div class="input-group mt-2">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="answer_question_id">'.$l['w_question'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
echo '<select name="answer_question_id" class="custom-select select2-single" id="answer_question_id"  onchange="document.getElementById(\'form_answereditor\').changecategory.value=1; document.getElementById(\'form_answereditor\').submit()" title="'.$l['h_question'].'">'.K_NEWLINE;
$sql = 'SELECT * FROM '.K_TABLE_QUESTIONS.' WHERE question_subject_id='.intval($question_subject_id).' ORDER BY question_enabled DESC, question_position,';
if (K_DATABASE_TYPE == 'ORACLE') {
    $sql .= 'CAST(question_description as varchar2(100))';
} else {
    $sql .= 'question_description';
}
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['question_id'].'"';
        if ($m['question_id'] == $answer_question_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. ';
        if (!F_getBoolean($m['question_enabled'])) {
            echo '-';
        } else {
            echo $qtype[($m['question_type'] - 1)];
        }
        echo ' '.htmlspecialchars(F_substr_utf8(F_remove_tcecode($m['question_description']), 0, K_SELECT_SUBSTRING), ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo '<div class="input-group mt-2">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="answer_id">'.$l['w_answer'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="answer_id" id="answer_id"  onchange="document.getElementById(\'form_answereditor\').submit()" title="'.$l['h_answer'].'">'.K_NEWLINE;
echo '<option value="0" class="btn btn-success"';
if ($answer_id == 0) {
    echo ' selected="selected"';
}
echo '>+ tambah opsi baru</option>'.K_NEWLINE;
$sql = 'SELECT * FROM '.K_TABLE_ANSWERS.' WHERE answer_question_id='.intval($answer_question_id).' ORDER BY answer_position, answer_enabled DESC, answer_isright DESC,';
if (K_DATABASE_TYPE == 'ORACLE') {
    $sql .= 'CAST(answer_description as varchar2(100))';
} else {
    $sql .= 'answer_description';
}
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['answer_id'].'"';
        if ($m['answer_id'] == $answer_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. ';
        if (!F_getBoolean($m['answer_enabled'])) {
            echo '-';
        } elseif (F_getBoolean($m['answer_isright'])) {
            echo 'T';
        } else {
            echo 'F';
        }
        echo ' '.htmlspecialchars(F_substr_utf8(F_remove_tcecode($m['answer_description']), 0, K_SELECT_SUBSTRING), ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');


echo '<div class="position-relative form-group mt-3">'.K_NEWLINE;
echo '<div class="d-flex justify-content-between align-items-center">'.K_NEWLINE;
echo '<label for="answer_description">Teks jawaban</label>'.K_NEWLINE;
echo '<a class="badge badge-alternate rounded-pill" href="#answer_description" id="editor_btn" onclick="ckEditor(\'answer_description\',\'editor_btn\')">Load Editor</a>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<textarea class="form-control" name="answer_description" id="answer_description">';
echo $answer_description.'</textarea>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormRowTextInput('answer_weight', 'Bobot Jawaban (%)', 'Bobot Jawaban " onchange="checkRight()', 'Masukkan bobot jawaban dengan angka dari 1 - 100<br/>Bobot 100% harus mencentang checkbox benar di bawah ini', $answer_weight, '', 255, false, false, false);

if (K_ENABLE_ANSWER_EXPLANATION) {
    echo '<div class="position-relative form-group mt-3">'.K_NEWLINE;
	echo '<div class="d-flex justify-content-between align-items-center">'.K_NEWLINE;
    echo '<label for="answer_explanation">'.ucfirst($l['w_explanation']).' (opsional)</label>'.K_NEWLINE;
    echo '<a class="badge badge-alternate rounded-pill" id="aex_btn" href="#answer_explanation" onclick="ckEditor(\'answer_explanation\',\'aex_btn\')">Load Editor</a> ';
	echo '</div>'.K_NEWLINE;
	echo '<textarea class="form-control" name="answer_explanation" id="answer_explanation">';
	echo $answer_explanation.'</textarea>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
}

echo '<div class="form-inline">'.K_NEWLINE;
echo '<div class="form-check-inline">'.K_NEWLINE;
echo getFormRowCheckBox('answer_isright', $l['w_right'], $l['h_answer_isright'].', atau jika pengaturan bobot jawaban adalah 100%" data-toggle="tooltip', '', 1, $answer_isright, false, '');
echo '</div>'.K_NEWLINE;
echo '<div class="form-check-inline">'.K_NEWLINE;
echo getFormRowCheckBox('answer_enabled', $l['w_enabled'], $l['h_enabled'], '', 1, $answer_enabled, false, '');
echo '</div>'.K_NEWLINE;


echo '<div class="form-check-inline">'.K_NEWLINE;
echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="answer_position">'.$l['w_position'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<select class="custom-select" name="answer_position" id="answer_position"  title="'.$l['h_position'].'">'.K_NEWLINE;
if (isset($answer_id) and ($answer_id > 0)) {
    $max_position = (1 + F_count_rows(K_TABLE_ANSWERS, 'WHERE answer_question_id='.$answer_question_id.' AND answer_position>0 AND answer_id<>'.$answer_id.''));
} else {
    $max_position = 0;
}
echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
for ($pos=1; $pos <= $max_position; ++$pos) {
    echo '<option value="'.$pos.'"';
    if ($pos == $answer_position) {
        echo ' selected="selected"';
    }
    echo '>'.$pos.'</option>'.K_NEWLINE;
}
echo '<option value="'.($max_position + 1).'" style="color:#ff0000">'.($max_position + 1).'</option>'.K_NEWLINE;
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<input type="hidden" name="max_position" id="max_position" value="'.$max_position.'" />'.K_NEWLINE;

echo '<div class="form-check-inline">'.K_NEWLINE;
echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="answer_keyboard_key">'.$l['w_keyboard_key'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<select class="custom-select" name="answer_keyboard_key" id="answer_keyboard_key"  title="'.$l['h_answer_keyboard_key'].'">'.K_NEWLINE;
echo '<option value="">&nbsp;</option>'.K_NEWLINE;
for ($ascii = 32; $ascii <= 126; ++$ascii) {
    echo '<option value="'.$ascii.'"';
    if ($ascii == $answer_keyboard_key) {
        echo ' selected="selected"';
    }
    echo '>';
    if ($ascii == 32) {
        echo 'SP';
    } else {
        echo htmlspecialchars(chr($ascii), ENT_NOQUOTES, $l['a_meta_charset']);
    }
    echo '</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

echo '<div class="d-block text-center card-footer">'.K_NEWLINE;

// show buttons by case

if (isset($answer_id) and ($answer_id > 0)) {
    echo '<span>';
    echo '<input class="d-none" checked="checked" type="checkbox" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
    F_submit_button_alt('update', $l['w_update'], $l['h_update'], 'mb-2 mr-2 btn btn-primary');
    echo '</span>';
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'mb-2 mr-2 btn btn-success');
    F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], 'btn-transition btn btn-outline-danger text-capitalize mr-2 mb-2');
} else {
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'mb-2 mr-2 btn btn-success');
}
F_submit_button_alt('clear', $l['w_clear'], $l['h_clear'], 'btn-transition btn btn-outline-warning text-capitalize mr-2 mb-2');

echo '</div>'.K_NEWLINE;

echo '<div class="d-flex justify-content-around justify-content-sm-between flex-wrap px-3">'.K_NEWLINE;
echo '<span class="nav-item border border-primary rounded card-shadow-primary rounded-pill">'.K_NEWLINE;
if (isset($answer_question_id) and ($answer_question_id > 0)) {
    echo '<a href="tce_edit_question.php?subject_module_id='.$subject_module_id.'&amp;question_subject_id='.$question_subject_id.'&amp;question_id='.$answer_question_id.'" title="'.$l['t_questions_editor'].'" class="nav-link"><i class="nav-link-icon pe-7s-help1"></i><span>'.$l['t_questions_editor'].'</a>';
}

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div><a href="tce_show_all_questions.php?order_field=question_enabled+DESC%2C+question_position%2C+question_description&subject_module_id='.$subject_module_id.'&subject_id='.$question_subject_id.'&submitted=1&firstrow=0#qid_'.$answer_question_id.'" class="d-block btn btn-primary text-center mt-3 mx-3 rounded-pill"><i class="fa fa-fw"></i> Kembali ke bank soal <i class="pe-7s-news-paper"></i></a></div>'.K_NEWLINE;

echo F_getCSRFTokenField().K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</form>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');
?>
<script>
	$(document).ready(function(){
		checkRight();	
	});
	
	$('#answer_isright').change(function () {
		let ai = $("#answer_isright");
		let aw = $("#answer_weight");
		if(ai.prop("checked")==true){
			if(ai.val()<100){
				aw.val(100)
			}
		}else{
			aw.val(0)
		}
		// console.log(ai.prop("checked"));
		// console.log();
		// if(aw.val().length<1){
			// aw.val(0);
		// }else{
			
		// }
		
	});
	
</script>
