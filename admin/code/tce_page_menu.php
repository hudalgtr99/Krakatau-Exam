<?php

require_once('../config/tce_auth.php');
require_once('../../shared/code/tce_functions_menu.php');

$caret = '<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>';

$menu = array(
    'index.php' => array('link' => 'index.php', 'title' => $l['h_index'], 'name' => "<i class='metismenu-icon pe-7s-home'></i> ".$l['w_index'], 'level' => K_AUTH_INDEX, 'key' => '', 'enabled' => true),
    'tmf_general_settings.php' => array('link' => 'tmf_general_settings.php', 'title' => 'General Settings', 'name' => '<i class="metismenu-icon pe-7s-settings"></i> General Settings', 'level' => K_AUTH_ADMIN_USERS, 'key' => 'c', 'enabled' => true),	
    'tmf_chat.php' => array('link' => '../../public/code/tmf_chat.php', 'title' => 'Chat', 'name' => '<i class="metismenu-icon pe-7s-comment"></i> Chat', 'level' => K_AUTH_ADMIN_USERS, 'key' => 'c', 'enabled' => K_CHAT_FEATURE),	
    'tce_menu_users.php' => array('link' => '#parent', 'title' => $l['w_users'], 'name' => "<i class='metismenu-icon pe-7s-users'></i> ".ucfirst($l['w_users']).$caret, 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true),
	'tmf_reset_user.php' => array('link' => 'tmf_reset_user.php', 'title' => 'Reset Peserta', 'name' => '<i class="metismenu-icon pe-7s-shuffle"></i> Reset Peserta', 'level' => K_AUTH_INDEX, 'key' => 'c', 'enabled' => true),
    'tce_menu_modules.php' => array('link' => '#parent', 'title' => $l['w_modules'], 'name' => "<i class='metismenu-icon pe-7s-album'></i> ".ucfirst($l['w_modules']).$caret, 'level' => K_AUTH_ADMIN_MODULES, 'key' => '', 'enabled' => true),
    'tce_menu_tests.php' => array('link' => '#parent', 'title' => $l['w_tests'], 'name' => "<i class='metismenu-icon pe-7s-display2'></i> ".ucfirst($l['w_tests']).$caret, 'level' => K_AUTH_ADMIN_TESTS, 'key' => '', 'enabled' => true),
    // 'tce_edit_backup.php' => array('link' => 'tce_edit_backup.php', 'title' => $l['t_backup_editor'], 'name' => "<i class='metismenu-icon pe-7s-box1'></i> ".ucfirst($l['w_backup']), 'level' => K_AUTH_BACKUP, 'key' => '', 'enabled' => ((K_DATABASE_TYPE == 'MYSQL') or (K_DATABASE_TYPE == 'POSTGRESQL'))),
    // 'update' => array('link' => 'tmf_update.php', 'title' => 'Update TMF', 'name' => "<i class='metismenu-icon pe-7s-graph1'></i> Update", 'level' => 10, 'key' => '', 'enabled' => true),
    'public' => array('link' => '../../public/code/index.php', 'title' => $l['h_public_link'], 'name' => "<i class='metismenu-icon pe-7s-rocket'></i> ".ucfirst($l['w_public']), 'level' => 0, 'key' => '', 'enabled' => true),
    // 'tmf_help_support.php' => array('link' => 'tmf_help_support.php', 'title' => 'Bantuan dan Dukungan', 'name' => "<i class='metismenu-icon pe-7s-help2'></i> Bantuan dan Dukungan", 'level' => K_AUTH_ADMIN_INFO, 'key' => '', 'enabled' => true),
    'tce_page_info.php' => array('link' => 'tce_page_info.php', 'title' => $l['h_info'], 'name' => "<i class='metismenu-icon pe-7s-info'></i> ".ucfirst($l['w_info']), 'level' => K_AUTH_ADMIN_INFO, 'key' => '', 'enabled' => true),
    'tce_logout.php' => array('link' => 'tce_logout.php', 'title' => $l['h_logout_link'].'" onclick="return confirm(\'Yakin ingin keluar dari aplikasi ?\')', 'name' => "<i class='metismenu-icon pe-7s-power'></i> ".ucfirst($l['w_logout']), 'level' => 1, 'key' => '', 'enabled' => ($_SESSION['session_user_level'] > 0)),
    'tce_login.php' => array('link' => 'tce_login.php', 'title' => $l['h_login_button'], 'name' => "<i class='metismenu-icon pe-7s-lock'></i> ".ucfirst($l['w_login']), 'level' => 0, 'key' => '', 'enabled' => ($_SESSION['session_user_level'] < 1))
);

$menu['tce_menu_users.php']['sub'] = array(
    'tce_edit_user.php' => array('link' => 'tce_edit_user.php', 'title' => $l['t_user_editor'], 'name' => "<i class='pe-7s-user'></i> Kelola ".ucfirst($l['w_users']), 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true),
    'tce_edit_group.php' => array('link' => 'tce_edit_group.php', 'title' => $l['t_group_editor'], 'name' => "<i class='pe-7s-users'></i> Kelola ".ucfirst($l['w_groups']), 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true),
    'tce_select_users.php' => array('link' => 'tce_select_users.php', 'title' => $l['t_user_select'], 'name' => "<i class='pe-7s-id'></i> Daftar User", 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true),
    'tce_show_online_users.php' => array('link' => 'tce_show_online_users.php', 'title' => $l['t_online_users'], 'name' => "<i class='pe-7s-signal'></i> ".ucfirst($l['w_online']), 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true),
    'tce_import_users.php' => array('link' => 'tce_import_users.php', 'title' => $l['t_user_importer'], 'name' => "<i class='pe-7s-cloud-upload'></i> ".ucfirst($l['w_import']), 'level' => K_AUTH_ADMIN_USERS, 'key' => '', 'enabled' => true)
);

if(file_exists('tmf_word_import.php')){
	$msword_import_file = 'tmf_word_import.php';
	$msword_import_title = 'MS Word Import';
	$msword_import_level = K_AUTH_ADMIN_IMPORT;
}else{
	$msword_import_file = 'tmf_msword_online_converter.php';
	$msword_import_title = 'MS Word to XML Converter';
	$msword_import_level = K_AUTH_ADMIN_IMPORT;
}
	
$menu['tce_menu_modules.php']['sub'] = array(
    'tce_edit_module.php' => array('link' => 'tce_edit_module.php', 'title' => $l['t_modules_editor'], 'name' => "<i class='pe-7s-notebook'></i> Kelola ".ucfirst($l['w_modules']), 'level' => K_AUTH_ADMIN_MODULES, 'key' => '', 'enabled' => true),
    'tce_edit_subject.php' => array('link' => 'tce_edit_subject.php', 'title' => $l['t_subjects_editor'], 'name' => "<i class='pe-7s-bookmarks'></i> Kelola ".ucfirst($l['w_subjects']), 'level' => K_AUTH_ADMIN_SUBJECTS, 'key' => '', 'enabled' => true),
    'tce_edit_question.php' => array('link' => 'tce_edit_question.php', 'title' => $l['t_questions_editor'], 'name' => "<i class='pe-7s-help1'></i> Kelola ".ucfirst($l['w_questions']), 'level' => K_AUTH_ADMIN_QUESTIONS, 'key' => '', 'enabled' => true),
    'tce_edit_answer.php' => array('link' => 'tce_edit_answer.php', 'title' => $l['t_answers_editor'], 'name' => "<i class='pe-7s-pin'></i> Kelola ".ucfirst($l['w_answers']), 'level' => K_AUTH_ADMIN_ANSWERS, 'key' => '', 'enabled' => true),
    'tce_show_all_questions.php' => array('link' => 'tce_show_all_questions.php', 'title' => $l['t_questions_list'], 'name' => "<i class='pe-7s-news-paper'></i> Kelola Bank Soal", 'level' => K_AUTH_ADMIN_RESULTS, 'key' => '', 'enabled' => true),
    'tce_import_questions.php' => array('link' => 'tce_import_questions.php', 'title' => $l['t_question_importer'], 'name' => "<i class='pe-7s-upload'></i> ".ucfirst($l['w_import'])." Soal", 'level' => K_AUTH_ADMIN_IMPORT, 'key' => '', 'enabled' => true),
	$msword_import_file => array('link' => $msword_import_file, 'title' => $msword_import_title, 'name' => "<i class='fas fa-file-word'></i> ".$msword_import_title, 'level' => $msword_import_level, 'key' => '', 'enabled' => true),
    'tce_filemanager.php' => array('link' => 'tce_filemanager.php', 'title' => $l['t_filemanager'], 'name' => "<i class='pe-7s-folder'></i> ".ucfirst($l['w_file_manager']), 'level' => K_AUTH_ADMIN_FILEMANAGER, 'key' => '', 'enabled' => true),
	'tmf_filebrowser.php' => array('link' => 'tmf_filebrowser.php', 'title' => 'File Browser', 'name' => "<i class='pe-7s-folder'></i> File Browser", 'level' => K_AUTH_ADMIN_FILEMANAGER, 'key' => '', 'enabled' => false),
    'tce_edit_sslcerts.php' => array('link' => 'tce_edit_sslcerts.php', 'title' => $l['t_sslcerts'], 'name' => "<i class='pe-7s-key'></i> ".ucfirst($l['w_sslcerts']), 'level' => K_AUTH_ADMIN_SSLCERT, 'key' => '', 'enabled' => true)
);

$menu['tce_menu_tests.php']['sub'] = array(
    'tce_edit_test.php' => array('link' => 'tce_edit_test.php', 'title' => $l['t_tests_editor'], 'name' => "<i class='pe-7s-airplay'></i> Kelola test", 'level' => K_AUTH_ADMIN_TESTS, 'key' => '', 'enabled' => true),
    'tmf_generate.php' => array('link' => 'tmf_generate.php', 'title' => 'Generate Halaman Ujian', 'name' => "<i class='pe-7s-repeat'></i> Generate Halaman Ujian", 'level' => K_AUTH_ADMIN_TESTS, 'key' => '', 'enabled' => true),
    'tce_select_tests.php' => array('link' => 'tce_select_tests.php', 'title' => $l['t_test_select'], 'name' => "<i class='pe-7s-note2'></i> Daftar Test", 'level' => K_AUTH_ADMIN_TESTS, 'key' => '', 'enabled' => true),
    'tce_import_omr_answers.php' => array('link' => 'tce_import_omr_answers.php', 'title' => $l['t_omr_answers_importer'], 'name' => "<i class='pe-7s-download'></i> ".ucfirst($l['w_import_omr_answers']), 'level' => K_AUTH_ADMIN_OMR_IMPORT, 'key' => '', 'enabled' => true),
    'tce_import_omr_bulk.php' => array('link' => 'tce_import_omr_bulk.php', 'title' => $l['t_omr_bulk_importer'], 'name' => "<i class='pe-7s-copy-file'></i> ".ucfirst($l['t_omr_bulk_importer']), 'level' => K_AUTH_ADMIN_OMR_IMPORT, 'key' => '', 'enabled' => true),
    'tce_edit_rating.php' => array('link' => 'tce_edit_rating.php', 'title' => $l['t_rating_editor'], 'name' => "<i class='pe-7s-note'></i> ".ucfirst($l['w_rating']), 'level' => K_AUTH_ADMIN_RATING, 'key' => '', 'enabled' => true),
    'tce_show_result_allusers.php' => array('link' => 'tce_show_result_allusers.php', 'title' => $l['t_result_all_users'], 'name' => "<i class='pe-7s-cup'></i> ".ucfirst($l['w_results']), 'level' => K_AUTH_ADMIN_RESULTS, 'key' => '', 'enabled' => true),
    'tce_show_result_user.php' => array('link' => 'tce_show_result_user.php', 'title' => $l['t_result_user'], 'name' => "<i class='pe-7s-study'></i> Detail Tes Per-".ucfirst($l['w_users']), 'level' => K_AUTH_ADMIN_RESULTS, 'key' => '', 'enabled' => true),
    'tmf_show_notest_allusers.php' => array('link' => 'tmf_show_notest_allusers.php', 'title' => 'Kehadiran tes', 'name' => "<i class='pe-7s-display1'></i> Kehadiran tes", 'level' => K_AUTH_ADMIN_RESULTS, 'key' => '', 'enabled' => true)
);

// echo '<a name="menusection" id="menusection"></a>'.K_NEWLINE;

// link to skip navigation
// echo '<div class="hidden">';
// echo '<a href="#topofdoc" accesskey="2" title="[2] '.$l['w_skip_navigation'].'">'.$l['w_skip_navigation'].'</a>';
// echo '</div>'.K_NEWLINE;

echo '<ul class="vertical-nav-menu metismenu">'.K_NEWLINE;
foreach ($menu as $link => $data) {
    echo F_menu_link_alt($link, $data, 0);
}
echo '</ul>'.K_NEWLINE; // end of menu

//============================================================+
// END OF FILE
//============================================================+
