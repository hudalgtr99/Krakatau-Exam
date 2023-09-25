<?php
//============================================================+
// File name   : tce_edit_subject.php
// Begin       : 2004-04-26
// Last Update : 2020-05-06
//
// Description : Display form to edit exam subject_id (topics).
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
 * Display form to edit exam subject_id (topics).
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2004-04-27
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_SUBJECTS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_subjects_editor'];
$thispage_title_icon = '<i class="pe-7s-bookmarks icon-gradient bg-sunny-morning"></i> ';
$thispage_help = $l['hp_edit_subject'];

require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../code/tce_functions_tcecode_editor.php');
require_once('../../shared/code/tce_functions_auth_sql.php');

// upload multimedia files
$uploadedfile = array();
for ($id = 0; $id < 2; ++$id) {
    if (isset($_POST['sendfile'.$id]) and ($_FILES['userfile'.$id]['name'])) {
        require_once('../code/tce_functions_upload.php');
        $uploadedfile['\''.$id.'\''] = F_upload_file('userfile'.$id, K_PATH_CACHE);
    }
}

// comma separated list of required fields
$_REQUEST['ff_required'] = 'subject_name';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_name'], ENT_COMPAT, $l['a_meta_charset']);

// set default values
if (!isset($_REQUEST['subject_enabled']) or (empty($_REQUEST['subject_enabled']))) {
    $subject_enabled = false;
} else {
    $subject_enabled = F_getBoolean($_REQUEST['subject_enabled']);
}
if (isset($_REQUEST['subject_id'])) {
    $subject_id = intval($_REQUEST['subject_id']);
} else {
    $subject_id = 0;
}
if (isset($_REQUEST['subject_module_id'])) {
    $subject_module_id = intval($_REQUEST['subject_module_id']);
} else {
    $subject_module_id = 0;
}
if (isset($_REQUEST['changecategory']) and ($_REQUEST['changecategory'] > 0)) {
    $changecategory = 1;
} elseif (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
} else {
    $changecategory = 0;
}
if (isset($_REQUEST['subject_name'])) {
    $subject_name = utrim($_REQUEST['subject_name']);
} else {
    $subject_name = '';
}
if (isset($_REQUEST['subject_description'])) {
    $subject_description = utrim($_REQUEST['subject_description']);
} else {
    $subject_description = '';
}

if ($subject_id > 0) {
    if ($changecategory == 0) {
        $sql = 'SELECT subject_module_id FROM '.K_TABLE_SUBJECTS.' WHERE subject_id='.$subject_id.' LIMIT 1';
        if ($r = F_db_query($sql, $db)) {
            if ($m = F_db_fetch_array($r)) {
                // $subject_module_id = $m['subject_module_id'];
				$subject_module_id = intval($m['subject_module_id']);
                // check user's authorization for parent module
                if ((!F_isAuthorizedUser(K_TABLE_MODULES, 'module_id', $subject_module_id, 'module_user_id'))
                    and (!F_isAuthorizedUser(K_TABLE_SUBJECTS, 'subject_id', $subject_id, 'subject_user_id'))) {
                    F_print_error('ERROR', $l['m_authorization_denied'], true);
                }
            }
        } else {
            F_display_db_error();
        }
    }
} else {
    $subject_id = 0;
}

switch ($menu_mode) {
    case 'delete':{
        F_stripslashes_formfields();
        // check if this record is used (test_log)
        if (!F_check_unique(K_TABLE_SUBJECT_SET, 'subjset_subject_id='.$subject_id.'')) {
            //this record will be only disabled and not deleted because it's used
            $sql = 'UPDATE '.K_TABLE_SUBJECTS.' SET
				subject_enabled=\'0\'
				WHERE subject_id='.$subject_id.'';
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
            <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $subject_id; ?>" />
            <input type="hidden" name="subject_module_id" id="subject_module_id" value="<?php echo $subject_module_id; ?>" />
            <input type="hidden" name="subject_name" id="subject_name" value="<?php echo htmlspecialchars($subject_name, ENT_COMPAT, $l['a_meta_charset']); ?>" />
            <?php
			echo '<div class="alert alert-warning fade show" role="alert">'.K_NEWLINE;
			echo '<h4 class="alert-heading">'.$l['m_delete_confirm'].'</h4>'.K_NEWLINE;
			echo '<p>Apakah yakin ingin melanjutkan proses penghapusan?</p>'.K_NEWLINE;
			echo '<hr>'.K_NEWLINE;
            F_submit_button_alt('forcedelete', $l['w_delete'], $l['h_delete'], 'mb-2 mr-2 btn btn-danger');
            F_submit_button_alt('cancel', $l['w_cancel'], $l['h_cancel'], 'mb-2 mr-2 btn-transition btn btn-outline-danger');
            echo F_getCSRFTokenField().K_NEWLINE;
			echo '</div>'.K_NEWLINE;
            ?>
            </div>
            </form>
            </div>
        <?php
        }
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields();
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
            $sql = 'DELETE FROM '.K_TABLE_SUBJECTS.' WHERE subject_id='.$subject_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $subject_id=false;
                F_print_error('MESSAGE', $subject_name.': '.$l['m_deleted']);
            }
        }
        break;
    }

    case 'update':{ // Update
        // check if the confirmation chekbox has been selected
        if (!isset($_REQUEST['confirmupdate']) or ($_REQUEST['confirmupdate'] != 1)) {
            F_print_error('WARNING', $l['m_form_missing_fields'].': '.$l['w_confirm'].' &rarr; '.$l['w_update']);
            F_stripslashes_formfields();
            break;
        }
        if ($formstatus = F_check_form_fields()) {
            // check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
            if (!F_check_unique(K_TABLE_SUBJECT_SET, 'subjset_subject_id='.intval($subject_id).'')) {
                F_print_error('WARNING', $l['m_update_restrict']);
                // enable or disable record
                $sql = 'UPDATE '.K_TABLE_SUBJECTS.' SET
					subject_enabled=\''.intval($subject_enabled).'\'
					WHERE subject_id='.$subject_id.'';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                } else {
                    $strmsg = $l['w_record_status'].': ';
                    if ($subject_enabled) {
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
            // check if name is unique for selected module
            if (!F_check_unique(K_TABLE_SUBJECTS, 'subject_name=\''.F_escape_sql($db, $subject_name).'\' AND subject_module_id='.$subject_module_id.'', 'subject_id', $subject_id)) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            $sql = 'UPDATE '.K_TABLE_SUBJECTS.' SET
				subject_name=\''.F_escape_sql($db, $subject_name).'\',
				subject_description='.F_empty_to_null($subject_description).',
				subject_enabled=\''.intval($subject_enabled).'\',
				subject_module_id='.$subject_module_id.'
				WHERE subject_id='.$subject_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                F_print_error('MESSAGE', $l['m_updated']);
            }
        }
        break;
    }

    case 'add':{ // Add
        if ($formstatus = F_check_form_fields()) {
            // check if name is unique
            if (!F_check_unique(K_TABLE_SUBJECTS, 'subject_name=\''.F_escape_sql($db, $subject_name).'\' AND subject_module_id='.$subject_module_id.'')) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            $sql = 'INSERT INTO '.K_TABLE_SUBJECTS.' (
				subject_name,
				subject_description,
				subject_enabled,
				subject_user_id,
				subject_module_id
				) VALUES (
				\''.F_escape_sql($db, $subject_name).'\',
				'.F_empty_to_null($subject_description).',
				\''.intval($subject_enabled).'\',
				\''.intval($_SESSION['session_user_id']).'\',
				'.$subject_module_id.'
				)';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $subject_id = F_db_insert_id($db, K_TABLE_SUBJECTS, 'subject_id');
				F_print_error('MESSAGE', 'Topik berhasil ditambahkan');
            }
        }
        break;
    }

    case 'clear':{ // Clear form fields
        $subject_name = '';
        $subject_description = '';
        $subject_enabled = true;
        break;
    }

    default :{
        break;
    }
} //end of switch

// select default module (if not specified)
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

// --- Initialize variables
if ($formstatus) {
    if ($menu_mode != 'clear') {
        if (($changecategory > 0) or empty($subject_id)) {
            $subject_id = 0;
            $subject_name = '';
            $subject_description = '';
            $subject_enabled = true;
        } else {
            $sql = F_select_subjects_sql('subject_id='.$subject_id.' AND subject_module_id='.$subject_module_id).' LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $subject_id = $m['subject_id'];
                    $subject_name = $m['subject_name'];
                    $subject_description = $m['subject_description'];
                    $subject_enabled = F_getBoolean($m['subject_enabled']);
                    $subject_module_id = $m['subject_module_id'];
                } else {
                    $subject_name = '';
                    $subject_description = '';
                    $subject_enabled = true;
                }
            } else {
                F_display_db_error();
            }
        }
    }
}


if ($subject_module_id <= 0) {
    echo '<div class="container">'.K_NEWLINE;
    echo '<p><a href="tce_edit_module.php" title="'.$l['t_modules_editor'].'" class="xmlbutton">&lt; '.$l['t_modules_editor'].'</a></p>'.K_NEWLINE;
    echo '<div class="pagehelp">'.$l['hp_edit_subject'].'</div>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
    require_once('../code/tce_page_footer.php');
    exit;
}

echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'inserttag.js" type="text/javascript"></script>'.K_NEWLINE;
if (K_ENABLE_VIRTUAL_KEYBOARD) {
    echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'vk/vk_easy.js?vk_skin=default" type="text/javascript"></script>'.K_NEWLINE;
}

echo '<div class="main-card mb-3 card">'.K_NEWLINE;
if($subject_id>0){
	$form_title = '<i class="pe-7s-pen mr-2"></i>Edit Topik';
}else{
	$form_title = '<i class="pe-7s-plus mr-2"></i>Tambah Topik';
}
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_subjecteditor">'.K_NEWLINE;
echo '<div class="card-header text-left">'.$form_title.'</div>'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;
echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text text-capitalize" for="subject_module_id">'.$l['w_module'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="subject_module_id" id="subject_module_id" onchange="document.getElementById(\'form_subjecteditor\').changecategory.value=1; document.getElementById(\'form_subjecteditor\').submit();" title="'.$l['w_module'].'">'.K_NEWLINE;
$sql = F_select_modules_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['module_id'].'"';
        if ($m['module_id'] == $subject_module_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.". ";
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
// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text text-capitalize" for="subject_id">'.$l['w_subject'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="subject_id" id="subject_id" onchange="document.getElementById(\'form_subjecteditor\').submit()" title="'.$l['h_subject'].'">'.K_NEWLINE;
echo '<option value="0" class="btn btn-success"';
if ($subject_id == 0) {
    echo ' selected="selected"';
}
echo '>+ tambah topik baru</option>'.K_NEWLINE;
$sql = F_select_subjects_sql('subject_module_id='.$subject_module_id);
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['subject_id'].'"';
        if ($m['subject_id'] == $subject_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. ';
        if (F_getBoolean($m['subject_enabled'])) {
            echo '+';
        } else {
            echo '-';
        }
        echo ' '.htmlspecialchars($m['subject_name'], ENT_NOQUOTES, $l['a_meta_charset']).'&nbsp;</option>'.K_NEWLINE;
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
// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

echo '<div class="mb-3"></div>'.K_NEWLINE;

echo getFormRowTextInput('subject_name', $l['w_name'], $l['h_subject_name'], '', $subject_name, '', 255, false, false, false, '', true);

echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text text-capitalize" for="subject_description">'.$l['w_description'].'</label>'.K_NEWLINE;
// echo '<br />'.K_NEWLINE;
// echo '<a href="#" title="'.$l['h_preview'].'" class="xmlbutton" onclick="previewWindow=window.open(\'tce_preview_tcecode.php?tcexamcode=\'+encodeURIComponent(document.getElementById(\'form_subjecteditor\').subject_description.value),\'previewWindow\',\'dependent,height=500,width=500,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no\'); return false;">'.$l['w_preview'].'</a>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw d-block">'.K_NEWLINE;
echo '<textarea class="form-control" cols="50" rows="5" name="subject_description" id="subject_description" onselect="FJ_update_selection(document.getElementById(\'form_subjecteditor\').subject_description)" title="'.$l['h_subject_description'].'"';
if (K_ENABLE_VIRTUAL_KEYBOARD) {
    echo ' class="keyboardInput"';
}
echo '>'.htmlspecialchars($subject_description, ENT_NOQUOTES, $l['a_meta_charset']).'</textarea>'.K_NEWLINE;
echo '<br />'.K_NEWLINE;
// echo tcecodeEditorTagButtons('form_subjecteditor', 'subject_description');
// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="mt-1 mb-3">'.K_NEWLINE;
echo getFormRowCheckBox('subject_enabled', $l['w_enabled'], $l['h_enabled'], '', 1, $subject_enabled, false, '');
echo '</div>'.K_NEWLINE;
// echo '<div class="pagehelp">'.$l['hp_edit_subject'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="d-block text-center card-footer">'.K_NEWLINE;

// show buttons by case
if (isset($subject_id) and ($subject_id > 0)) {
    // echo '<span>';
    echo '<input checked="checked" class="d-none" type="checkbox" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
    F_submit_button_alt('update', $l['w_update'], $l['h_update'], 'btn btn-primary mr-2 mt-2');
    // echo '</span>';
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'btn btn-success mr-2 mt-2');
    F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], 'btn-transition btn btn-outline-danger text-capitalize mr-2 mt-2');
} else {
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'btn btn-success mr-2 mt-2');
}
F_submit_button_alt('clear', $l['w_clear'], $l['h_clear'], 'btn-transition btn btn-outline-warning text-capitalize mt-2');

echo '</div>'.K_NEWLINE;

echo '<div class="d-flex justify-content-around justify-content-sm-between flex-wrap px-3">'.K_NEWLINE;

// echo '&nbsp;'.K_NEWLINE;
if ($subject_module_id > 0) {
	echo '<span class="nav-item border border-primary rounded card-shadow-primary rounded-pill">'.K_NEWLINE;
    echo '<a href="tce_edit_module.php?module_id='.$subject_module_id.'" title="'.$l['t_modules_editor'].'" class="nav-link"><i class="nav-link-icon pe-7s-notebook"></i><span>'.$l['t_modules_editor'].'</span></a>';
	echo '</span>'.K_NEWLINE;
}



if (isset($subject_id) and ($subject_id > 0)) {
	echo '<span class="nav-item border border-primary rounded card-shadow-primary rounded-pill">'.K_NEWLINE;
    echo '<a href="tce_edit_question.php?subject_module_id='.$subject_module_id.'&amp;question_subject_id='.$subject_id.'" title="'.$l['t_questions_editor'].'" class="nav-link"><span class="text-right">'.$l['t_questions_editor'].'</span><i class="nav-link-icon pe-7s-help1 ml-0 mr-n1"></i></a>';
	echo '</span>'.K_NEWLINE;
}

// echo '&nbsp;'.K_NEWLINE;

// echo '&nbsp;'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<a href="tce_show_all_questions.php?order_field=question_enabled+DESC%2C+question_position%2C+question_description&subject_module_id='.$subject_module_id.'&submitted=1&firstrow=0" class="d-block btn btn-primary text-center mt-3 mx-3 rounded-pill"><i class="fa fa-fw"></i> Kembali ke bank soal <i class="pe-7s-news-paper"></i></a>'.K_NEWLINE;

echo '<div class="row"><hr /></div>'.K_NEWLINE;

// echo '<div class="rowl" title="'.$l['h_preview'].'">'.K_NEWLINE;
// echo $l['w_preview'].K_NEWLINE;
// echo '<div class="preview">'.K_NEWLINE;

// echo F_decode_tcecode($subject_description);

// echo '&nbsp;'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
