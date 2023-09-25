<?php
//============================================================+
// File name   : tce_edit_module.php
// Begin       : 2008-11-28
// Last Update : 2020-05-06
//
// Description : Display form to edit modules.
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
 * Display form to edit modules.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2008-11-28
 */

/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_MODULES;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_modules_editor'];
$thispage_title_icon = '<i class="pe-7s-notebook icon-gradient bg-sunny-morning"></i> ';
$thispage_help = $l['hp_edit_module'];

require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_auth_sql.php');

// set default values
if (!isset($_REQUEST['module_enabled']) or (empty($_REQUEST['module_enabled']))) {
    $module_enabled = false;
} else {
    $module_enabled = F_getBoolean($_REQUEST['module_enabled']);
}
if (isset($_REQUEST['module_name'])) {
    $module_name = utrim($_REQUEST['module_name']);
} else {
    $module_name = '';
}
if (isset($_REQUEST['module_user_id'])) {
    $module_user_id = intval($_REQUEST['module_user_id']);
} else {
    $module_user_id = intval($_SESSION['session_user_id']);
}

if (isset($_REQUEST['module_id']) and ($_REQUEST['module_id'] > 0)) {
    $module_id = intval($_REQUEST['module_id']);
    // check user's authorization for module
    if (!F_isAuthorizedUser(K_TABLE_MODULES, 'module_id', $module_id, 'module_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }
} else {
    $module_id = 0;
}

// comma separated list of required fields
$_REQUEST['ff_required'] = 'module_name';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_name'], ENT_COMPAT, $l['a_meta_charset']);

switch ($menu_mode) {
    case 'delete':{
        F_stripslashes_formfields();
        // check if this record is used (test_log)
        if (!F_check_unique(K_TABLE_SUBJECTS.','.K_TABLE_SUBJECT_SET, 'subjset_subject_id=subject_id AND subject_module_id='.$module_id.'')) {
            //this record will be only disabled and not deleted because it's used
            $sql = 'UPDATE '.K_TABLE_MODULES.' SET
				module_enabled=\'0\'
				WHERE module_id='.$module_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error();
            }
            F_print_error('WARNING', $l['m_disabled_vs_deleted']);
        } else {
            // ask confirmation
            // F_print_error('WARNING', $l['m_delete_confirm']);
            ?>
            
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" id="form_delete">
            
            <input type="hidden" name="module_id" id="module_id" value="<?php echo $module_id; ?>" />
            <input type="hidden" name="module_name" id="module_name" value="<?php echo htmlspecialchars($module_name, ENT_COMPAT, $l['a_meta_charset']); ?>" />
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
            
            </form>
            
        <?php
        }
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields();
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
            $sql = 'DELETE FROM '.K_TABLE_MODULES.' WHERE module_id='.$module_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $module_id=false;
                F_print_error('MESSAGE', $module_name.': '.$l['m_deleted']);
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
            if (!F_check_unique(K_TABLE_SUBJECTS.','.K_TABLE_SUBJECT_SET, 'subjset_subject_id=subject_id AND subject_module_id='.$module_id.'')) {
                F_print_error('WARNING', $l['m_update_restrict']);

                // enable or disable record
                $sql = 'UPDATE '.K_TABLE_MODULES.' SET
					module_enabled=\''.intval($module_enabled).'\'
					WHERE module_id='.$module_id.'';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                } else {
                    $strmsg = $l['w_record_status'].': ';
                    if ($module_enabled) {
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
            // check if name is unique
            if (!F_check_unique(K_TABLE_MODULES, 'module_name=\''.F_escape_sql($db, $module_name).'\'', 'module_id', $module_id)) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
                $module_user_id = intval($module_user_id);
            } else {
                $module_user_id = intval($_SESSION['session_user_id']);
            }
            $sql = 'UPDATE '.K_TABLE_MODULES.' SET
				module_name=\''.F_escape_sql($db, $module_name).'\',
				module_enabled=\''.intval($module_enabled).'\',
				module_user_id=\''.$module_user_id.'\'
				WHERE module_id='.$module_id.'';
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
            if (!F_check_unique(K_TABLE_MODULES, 'module_name=\''.F_escape_sql($db, $module_name).'\'')) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
                $module_user_id = intval($module_user_id);
            } else {
                $module_user_id = intval($_SESSION['session_user_id']);
            }
            $sql = 'INSERT INTO '.K_TABLE_MODULES.' (
				module_name,
				module_enabled,
				module_user_id
				) VALUES (
				\''.F_escape_sql($db, $module_name).'\',
				\''.intval($module_enabled).'\',
				\''.$module_user_id.'\'
				)';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $module_id = F_db_insert_id($db, K_TABLE_MODULES, 'module_id');
				F_print_error('MESSAGE', 'Modul berhasil ditambahkan');
            }
        }
        break;
    }

    case 'clear':{ // Clear form fields
        $module_name = '';
        $module_enabled = true;
        $module_user_id = intval($_SESSION['session_user_id']);
        break;
    }

    default :{
        break;
    }
} //end of switch

// --- Initialize variables
if ($formstatus) {
    if ($menu_mode != 'clear') {
        if (empty($module_id)) {
            $module_id = 0;
            $module_name = '';
            $module_enabled = true;
            $module_user_id = intval($_SESSION['session_user_id']);
        } else {
            $sql = F_select_modules_sql('module_id='.$module_id).' LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $module_id = $m['module_id'];
                    $module_name = $m['module_name'];
                    $module_enabled = F_getBoolean($m['module_enabled']);
                    $module_user_id = intval($m['module_user_id']);
                } else {
                    $module_name = '';
                    $module_enabled = true;
                    $module_user_id = intval($_SESSION['session_user_id']);
                }
            } else {
                F_display_db_error();
            }
        }
    }
}

echo '<div class="main-card mb-3 card">'.K_NEWLINE;

if($module_id>0){
	$form_title = '<i class="pe-7s-pen mr-2"></i>Edit Modul';
}else{
	$form_title = '<i class="pe-7s-plus mr-2"></i>Tambah Modul';
}

echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_moduleeditor">'.K_NEWLINE;

echo '<div class="card-header text-left">'.$form_title.'</div>'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;
echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="module_id">'.ucfirst($l['w_module']).'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<div class="input-group-append">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="module_id" id="module_id" onchange="document.getElementById(\'form_moduleeditor\').submit()" title="'.$l['h_module_name'].'">'.K_NEWLINE;
echo '<option value="0" class="mb-2 mr-2 btn btn-success"';
if ($module_id == 0) {
    echo ' selected="selected"';
}
echo '>+ tambah modul baru</option>'.K_NEWLINE;
$sql = F_select_modules_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['module_id'].'"';
        if ($m['module_id'] == $module_id) {
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
    echo '</select></span></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo '<div class="form-row">'.K_NEWLINE;

echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('module_name', $l['w_name'], $l['h_module_name'], '', $module_name, '', 255, false, false, false, '', true);
echo '</div>'.K_NEWLINE;

echo '<div class="col-md-6">'.K_NEWLINE;
echo '<div class="input-group mb-3">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="module_user_id">'.$l['w_owner'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
$userids = array();
if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
    echo '<select class="custom-select" name="module_user_id" id="module_user_id" title="'.$l['h_module_owner'].'" onchange="">'.K_NEWLINE;
    $sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.' WHERE (user_level>5) ORDER BY user_lastname, user_firstname, user_name';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            $userids[] = $m['user_id'];
            echo '<option value="'.$m['user_id'].'"';
            if ($m['user_id'] == $module_user_id) {
                echo ' selected="selected"';
            }
            echo '>'.htmlspecialchars('('.$m['user_name'].') '.$m['user_lastname'].' '.$m['user_firstname'].'', ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        }
    } else {
        echo '</select></span></div>'.K_NEWLINE;
        F_display_db_error();
    }
    echo '</select>'.K_NEWLINE;
} else {
    $userdata = '';
    $userids[] = $module_user_id;
    $sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.' WHERE user_id='.$module_user_id.'';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            echo '<span style="font-style:italic;color:#333333;">('.unhtmlentities(strip_tags($m['user_name'].') '.$m['user_lastname'].' '.$m['user_firstname'])).'</span>'.K_NEWLINE;
        }
    } else {
        echo '</select></span></div>'.K_NEWLINE;
        F_display_db_error();
    }
}

// link for user selection popup
$jslink = 'tce_select_users_popup.php?cid=module_user_id';
if (!empty($userids)) {
    $uids = implode('x', $userids);
    if (strlen(K_PATH_PUBLIC_CODE.$jslink.$uids) < 512) {
        // add this filter only if the URL is short
        $jslink .= '&amp;uids='.$uids;
    }
}
$jsaction = 'selectWindow=window.open(\''.$jslink.'\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\');return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text">'.$l['w_groups'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
$sqlg = 'SELECT *
	FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
	WHERE usrgrp_group_id=group_id
		AND usrgrp_user_id='.$module_user_id.'
	ORDER BY group_name';
if ($rg = F_db_query($sqlg, $db)) {
    echo '<input class="form-control" type="text" disabled value="';
    while ($mg = F_db_fetch_array($rg)) {
        echo ' · '.unhtmlentities(strip_tags($mg['group_name'])).'';
    }
    echo '"></input>';
} else {
    F_display_db_error();
}
// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="mt-2">'.K_NEWLINE;
echo getFormRowCheckBox('module_enabled', $l['w_enabled'], $l['h_enabled'], '', 1, $module_enabled, false, '');
echo '</div>'.K_NEWLINE;

// echo '<div class="pagehelp">'.$l['hp_edit_module'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="d-block text-center card-footer">'.K_NEWLINE;

// show buttons by case
if (isset($module_id) and ($module_id > 0)) {
    echo '<span>';
    echo '<input class="d-none" type="checkbox" checked="checked" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
    F_submit_button_alt('update', $l['w_update'], $l['h_update'], 'btn btn-primary mr-2 mt-2');
    echo '</span>';
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'btn btn-success mr-2 mt-2');
    F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], 'btn-transition btn btn-outline-danger mr-2 mt-2');
} else {
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], 'btn btn-success mr-2 mt-2');
}
F_submit_button_alt('clear', $l['w_clear'], $l['h_clear'], 'btn-transition btn btn-outline-warning mt-2');

echo '</div>'.K_NEWLINE;

echo '<div>'.K_NEWLINE;
echo '<span class="right">'.K_NEWLINE;

if (isset($module_id) and ($module_id > 0)) {
	echo '<div class="d-flex justify-content-end mr-3">'.K_NEWLINE;
	echo '<span class="nav-item border border-primary rounded card-shadow-primary rounded-pill">'.K_NEWLINE;
    echo '<a href="tce_edit_subject.php?subject_module_id='.$module_id.'" class="nav-link" title="'.$l['t_subjects_editor'].'" class="xmlbutton"><span class="text-right">'.$l['t_subjects_editor'].'</span><i class="nav-link-icon pe-7s-bookmarks ml-0 mr-n1"></i></a>';
	echo '</span>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
}

echo '&nbsp;'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '&nbsp;'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
