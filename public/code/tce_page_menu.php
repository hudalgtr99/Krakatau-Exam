<?php
//============================================================+
// File name   : tce_page_menu.php
// Begin       : 2010-09-16
// Last Update : 2012-12-19
//
// Description : Output XHTML unordered list menu.
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
//    Copyright (C) 2004-2012 Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Output XHTML unordered list menu.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2010-09-16
 */

/**
 */

require_once('../../shared/code/tce_functions_menu.php');

$menu = array(
    'index.php' => array('link' => 'index.php', 'title' => $l['h_index'], 'name' => '<span class="icon-home-outline"></span> '.$l['w_index'], 'level' => K_AUTH_PUBLIC_INDEX, 'key' => 'i', 'enabled' => true),
    'tmf_chat.php' => array('link' => 'tmf_chat.php', 'title' => 'Chat', 'name' => '<span class="icon-bubble2"></span> Chat', 'level' => K_AUTH_PAGE_USER, 'key' => 'c', 'enabled' => K_CHAT_FEATURE),
    'tce_test_allresults.php' => array('link' => 'tce_test_allresults.php', 'title' => $l['t_all_results_user'], 'name' => '<span class="icon-clipboard"></span> '.$l['w_results'], 'level' => K_AUTH_PUBLIC_TEST_RESULTS, 'key' => 'r', 'enabled' => ($_SESSION['session_user_level'] >= K_AUTH_PUBLIC_TEST_RESULTS)),
	'tmf_skl.php' => array('link' => 'tmf_skl.php', 'title' => 'Surat Keterangan Lulus Online', 'name' => '<span class="icon-stack"></span> SKL Online', 'level' => 2, 'key' => 'r', 'enabled' => ($_SESSION['session_user_level'] > 1)),
    'tce_page_user.php' => array('link' => 'tce_page_user.php', 'title' => $l['w_user'], 'name' => '<span class="icon-user-o"></span> '.$l['w_user'], 'level' => K_AUTH_PAGE_USER, 'key' => 'u', 'enabled' => ($_SESSION['session_user_level'] > 0)),
    'admin' => array('link' => '../../admin/code/index.php', 'title' => $l['h_admin_link'], 'name' => '<span class="active admin"><span class="icon-cogs"></span> '.$l['w_admin']."</span>", 'level' => K_ADMIN_LINK, 'key' => 'a', 'enabled' => ($_SESSION['session_user_level'] >= K_ADMIN_LINK)),
    'tce_logout.php' => array('link' => 'tce_logout.php', 'title' => $l['h_logout_link'], 'name' => '<span class="icon-switch"></span> '.$l['w_logout'], 'level' => 1, 'key' => 'q', 'enabled' => ($_SESSION['session_user_level'] > 0)),
    'tce_login.php' => array('link' => 'tce_login.php', 'title' => $l['h_login_link'], 'name' => '<span class="icon-lock"></span>'.$l['w_login'], 'level' => 0, 'key' => 'l', 'enabled' => ($_SESSION['session_user_level'] < 1))
);

$menu['tce_page_user.php']['sub'] = array(
    'tce_user_change_email.php' => array('link' => 'tce_user_change_email.php', 'title' => $l['t_user_change_email'], 'name' => '<span class="icon-mail"></span> '.$l['w_change_email'], 'level' => K_AUTH_USER_CHANGE_EMAIL, 'key' => '', 'enabled' => true),
    'tce_user_change_password.php' => array('link' => 'tce_user_change_password.php', 'title' => $l['t_user_change_password'], 'name' => '<span class="icon-lock"></span> '.$l['w_change_password'], 'level' => K_AUTH_USER_CHANGE_PASSWORD, 'key' => '', 'enabled' => true)
);

echo '<a name="menusection" id="menusection"></a>'.K_NEWLINE;

// link to skip navigation
echo '<div class="hidden">';
echo '<a href="#topofdoc" accesskey="2" title="[2] '.$l['w_skip_navigation'].'">'.$l['w_skip_navigation'].'</a>';
echo '</div>'.K_NEWLINE;

$menudata = '';
foreach ($menu as $link => $data) {
    $menudata .= F_menu_link($link, $data, 0);
}

if (!empty($menudata)) {
    echo '<ul class="menu">'.K_NEWLINE;
    echo $menudata;
    echo '</ul>'.K_NEWLINE; // end of menu
}

//============================================================+
// END OF FILE
//============================================================+
