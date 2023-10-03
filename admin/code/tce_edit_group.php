<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_GROUPS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_group_editor'];
$thispage_title_icon = '<i class="pe-7s-users icon-gradient bg-happy-itmeo"></i> ';
$thispage_help = $l['hp_edit_group'];
require_once('../code/tce_page_header.php');

require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../code/tce_functions_user_select.php');

$user_id = intval($_SESSION['session_user_id']);
$userip = $_SESSION['session_user_ip'];
$userlevel = intval($_SESSION['session_user_level']);

if (isset($_REQUEST['group_id'])) {
    $group_id = intval($_REQUEST['group_id']);
    if (!F_isAuthorizedEditorForGroup($group_id)) {
        F_print_error('ERROR', $l['m_authorization_denied']);
        exit;
    }
} else {
    $group_id = 0;
}
if (isset($_REQUEST['group_name'])) {
    $group_name = $_REQUEST['group_name'];
} else {
    $group_name = '';
}

// comma separated list of required fields
$_REQUEST['ff_required'] = 'group_name';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_name'], ENT_COMPAT, $l['a_meta_charset']);

switch ($menu_mode) { // process submitted data

    case 'delete':{
        F_stripslashes_formfields(); // ask confirmation
        if ($_SESSION['session_user_level'] < K_AUTH_DELETE_GROUPS) {
            F_print_error('ERROR', $l['m_authorization_denied']);
            break;
        }
        // F_print_error('WARNING', $l['m_delete_confirm']);
		echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_delete">'.K_NEWLINE;
		echo '<div class="alert alert-warning fade show" role="alert">'.K_NEWLINE;
		echo '<h4 class="alert-heading">'.$l['m_delete_confirm'].'</h4>'.K_NEWLINE;
        echo '<p>Apakah yakin ingin melanjutkan proses penghapusan?</p>'.K_NEWLINE;
        echo '<hr>'.K_NEWLINE;
        F_submit_button_alt('forcedelete', $l['w_delete'], $l['h_delete'], "mb-2 mr-2 btn btn-danger");
        F_submit_button_alt('cancel', $l['w_cancel'], $l['h_cancel'], "mb-2 mr-2 btn-transition btn btn-outline-danger");
		echo '</div>'.K_NEWLINE;
		
        // echo '<div class="confirmbox">'.K_NEWLINE;
        
        // echo '<div>'.K_NEWLINE;
        echo '<input type="hidden" name="group_id" id="group_id" value="'.$group_id.'" />'.K_NEWLINE;
        echo '<input type="hidden" name="group_name" id="group_name" value="'.stripslashes($group_name).'" />'.K_NEWLINE;
        
        // echo '</div>'.K_NEWLINE;
        echo F_getCSRFTokenField().K_NEWLINE;
        echo '</form>'.K_NEWLINE;
        // echo '</div>'.K_NEWLINE;
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields(); // Delete specified user
        if ($_SESSION['session_user_level'] < K_AUTH_DELETE_GROUPS) {
            F_print_error('ERROR', $l['m_authorization_denied']);
            break;
        }
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
            $sql = 'DELETE FROM '.K_TABLE_GROUPS.' WHERE group_id='.$group_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $group_id=false;
                F_print_error('MESSAGE', '['.stripslashes($group_name).'] '.$l['m_group_deleted']);
            }
        }
        break;
    }

    case 'update':{ // Update user
        // check if the confirmation chekbox has been selected
        if (!isset($_REQUEST['confirmupdate']) or ($_REQUEST['confirmupdate'] != 1)) {
            F_print_error('WARNING', $l['m_form_missing_fields'].': '.$l['w_confirm'].' &rarr; '.$l['w_update']);
            F_stripslashes_formfields();
            break;
        }
        if ($formstatus = F_check_form_fields()) {
            // check if name is unique
            if (!F_check_unique(K_TABLE_GROUPS, 'group_name=\''.F_escape_sql($db, $group_name).'\'', 'group_id', $group_id)) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            $sql = 'UPDATE '.K_TABLE_GROUPS.' SET
				group_name=\''.F_escape_sql($db, $group_name).'\'
				WHERE group_id='.$group_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                F_print_error('MESSAGE', $group_name.': group telah diperbarui');
            }
        }
        break;
    }

    case 'add':{ // Add user
        if ($formstatus = F_check_form_fields()) { // check submitted form fields
            // check if name is unique
            if (!F_check_unique(K_TABLE_GROUPS, 'group_name=\''.F_escape_sql($db, $group_name).'\'')) {
                F_print_error('WARNING', $l['m_duplicate_name']);
                $formstatus = false;
                F_stripslashes_formfields();
                break;
            }
            $sql = 'INSERT INTO '.K_TABLE_GROUPS.' (
				group_name
				) VALUES (
				\''.F_escape_sql($db, $group_name).'\')';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            } else {
                $group_id = F_db_insert_id($db, K_TABLE_GROUPS, 'group_id');
            }
            // add current user to the new group
            $sql = 'INSERT INTO '.K_TABLE_USERGROUP.' (
				usrgrp_user_id,
				usrgrp_group_id
				) VALUES (
				\''.$_SESSION['session_user_id'].'\',
				\''.$group_id.'\'
				)';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error(false);
            }else{
				F_print_error('MESSAGE', 'Group berhasil ditambahkan');
			}
        }
        break;
    }

    case 'clear':{ // Clear form fields
        $group_name = '';
        break;
    }

    default :{
        break;
    }
} //end of switch

// --- Initialize variables
if ($formstatus) {
    if ($menu_mode != 'clear') {
        if (!isset($group_id) or empty($group_id)) {
            $group_id = 0;
            $group_name = '';
        } else {
            $sql = F_user_group_select_sql('group_id='.$group_id).' LIMIT 1';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
                    $group_id = $m['group_id'];
                    $group_name = $m['group_name'];
                } else {
                    $group_name = '';
                }
            } else {
                F_display_db_error();
            }
        }
    }
}

echo '<div class="main-card mb-3 card">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_groupeditor">'.K_NEWLINE;
if($group_id>0){
	$form_title = '<i class="pe-7s-pen mr-2"></i>Edit Group';
}else{
	$form_title = '<i class="pe-7s-plus mr-2"></i>Tambah Group';
}
echo '<div class="card-header text-left">'.$form_title.'</div>'.K_NEWLINE;
echo '<div class="card-body">'.K_NEWLINE;

echo '<div class="position-relative form-group">'.K_NEWLINE;
// echo '<span class="label">'.K_NEWLINE;
echo '<label for="group_id">'.$l['w_group'].'</label>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="group_id" id="group_id" onchange="document.getElementById(\'form_groupeditor\').submit()">'.K_NEWLINE;
echo '<option value="0" class="mb-2 mr-2 btn btn-success"';
if ($group_id == 0) {
    echo ' selected="selected"';
}
echo '>+ tambah group baru</option>'.K_NEWLINE;
$sql = F_user_group_select_sql();
if ($r = F_db_query($sql, $db)) {
	$no = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['group_id'].'"';
        if ($m['group_id'] == $group_id) {
            echo ' selected="selected"';
        }
        echo '>'.$no.'. '.htmlspecialchars($m['group_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
		$no++;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// echo getFormNoscriptSelect('selectrecord');

// echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo getFormRowTextInput('group_name', $l['w_name'], $l['h_group_name'], '', $group_name, '', 255, false, false, false, '', true);

// echo '<div class="row jc-center">'.K_NEWLINE;

// show buttons by case
echo '</div>'.K_NEWLINE;

echo '<div class="d-block text-center card-footer">'.K_NEWLINE;
if (isset($group_id) and ($group_id > 0)) {
    // echo '<span class="d-iflex jc-center">';
    echo '<input class="custom-control-input" type="checkbox" checked="checked" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
    F_submit_button_alt('update', $l['w_update'], $l['h_update'], 'mr-2 btn-transition btn btn-primary');
    // echo '</span>';
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], "mr-2 btn-transition btn btn-success");
    if ($_SESSION['session_user_level'] >= K_AUTH_DELETE_GROUPS) {
        // your account and anonymous user can't be deleted
        F_submit_button_alt('delete', $l['w_delete'], $l['h_delete'], "mr-2 btn-transition btn btn-outline-danger");
    }
} else {
    F_submit_button_alt('add', $l['w_add'], $l['h_add'], "mr-2 btn-transition btn btn-success");
}
F_submit_button_alt('clear', $l['w_clear'], $l['h_clear'], "mr-2 btn-transition btn btn-outline-warning");

echo '</div>'.K_NEWLINE;

echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

// echo '<div class="pagehelp">'.$l['hp_edit_group'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
