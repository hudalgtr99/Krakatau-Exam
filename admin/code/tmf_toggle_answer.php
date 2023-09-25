<?php
//============================================================+
// File name   : tmf_toggle_answer.php
// Begin       : 2021-03-13
// Last Update : -
//
// Description : Toggle answer right/wrong
//
// Author: Maman Sulaeman
//
//============================================================+

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_ANSWERS;
require_once('../../shared/code/tce_authorization.php');

// $thispage_title = $l['t_answers_editor'];
// require_once('../code/tce_page_header.php');
// require_once('../../shared/code/tce_functions_form.php');
// require_once('../../shared/code/tce_functions_tcecode.php');
// require_once('../code/tce_functions_tcecode_editor.php');
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

if(intval($_GET['answer_isright'])==1){
	$answer_weight=100;
}else{
	$answer_weight=0;
}

$sql = 'UPDATE '.K_TABLE_ANSWERS.' SET
	answer_isright=\''.intval($_GET['answer_isright']).'\', answer_weight=\''.$answer_weight.'\'
	WHERE answer_id='.intval($_GET['answer_id']).' AND answer_question_id='.intval($_GET['answer_question_id']).'';
if (!$r = F_db_query($sql, $db)) {
	F_display_db_error(false);
	F_db_query('ROLLBACK', $db); // rollback transaction
} else {
	// F_print_error('MESSAGE', $l['m_updated']);
	echo '1';
}

$sql = 'COMMIT';
if (!$r = F_db_query($sql, $db)) {
	F_display_db_error(false);
	// break;
}