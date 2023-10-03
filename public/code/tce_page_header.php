<?php

if(!isset($_POST['question-block'])){
require_once('tce_xhtml_header.php');

// display header (image logo + timer)
echo '<div class="header"';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo ' style="background:var(--col-15t)"';
}
echo '>'.K_NEWLINE;
echo '<div class="d-flex jc-sb">'.K_NEWLINE;
echo '<div id="menu_open">';
//if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']>0){
	echo '<span onclick="menuOpen()"><i class="icon-bars"></i></span>';
//}else{
//	echo '<span>&#9776;</span>';
//}
echo '</div>'.K_NEWLINE;

echo '<div id="topRight" class="d-flex jc-se c-pointer">'.K_NEWLINE;
if($_SESSION['session_user_level']>4){
	echo '<div style="background: var(--col-10);user-select:none;padding:0.4em 0.65em" onclick="window.open(\'../../admin/code/index.php\')" class="mr-7 txt-small brad"><span class="icon-cogs"></span> Admin</div>';
}
if (K_LANGUAGE_SELECTOR) {
    $lang_array = unserialize(K_AVAILABLE_LANGUAGES);
    $lngstr = '';
    foreach ($lang_array as $lang_code => $lang_name) {
        if ($lang_code == K_USER_LANG) {
            $lngstr .= strtoupper($lang_code);
        }
    }
	$activeLang = $lngstr;
}

if(isset($activeLang)){
	echo '<div class="hidden show768 mr-5" id="langSelLbl" onclick="langSelOpen()">'.$l['w_language'].'</div><div id="langSelBtn" onclick="langSelOpen()"><span class="icon-flag-o"></span><span id="activeLang">'.$activeLang.'</span></div>'.K_NEWLINE;
}
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']>0){
echo '<div class="hidden show768 mr-5" id="userInfoLbl" onclick="userInfoOpen()">'.$l['w_user'].'</div> <div id="userInfoBtn" onclick="userInfoOpen()"><span class="icon-user-o"></span></div>'.K_NEWLINE;
}

echo '</div></div>'.K_NEWLINE;
echo '<div class="right">'.K_NEWLINE;
echo '<a name="timersection" id="timersection"></a>'.K_NEWLINE;
//include('../../shared/code/tce_page_timer.php');
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']>0){
echo '<div class="qlistCont" id="userInfoID">'.K_NEWLINE;
echo '<div id="qlistTitle"><div><p><span class="icon-user-o"></span> '.$l['w_user'].'</p><span id="qlistClose" onclick="userInfoHide()">&times;<span></div></div>';
echo '<div id="userInfoCont">'.K_NEWLINE;
echo '<div><span>'.$l['w_level'].'</span><span>'.$_SESSION['session_user_level'].'</span></div>'.K_NEWLINE;
echo '<div><span>'.$l['w_username'].'</span><span>'.$_SESSION['session_user_name'].'</span></div>'.K_NEWLINE;
echo '<div><span>'.$l['w_name'].'</span><span>'.urldecode(F_getFirstName($_SESSION['session_user_firstname'])).'</span></div>'.K_NEWLINE;
if($_SESSION['session_user_lastname']!=""){
	echo '<div><span>'.$l['w_lastname'].'</span><span>'.F_getFirstName($_SESSION['session_user_lastname']).'</span></div>'.K_NEWLINE;
}
echo '<div class="logout"><span><a href="tce_logout.php" class="logoutbutton" title="'.$l['h_logout_link'].'" onclick="return confirm(\'Apakah yakin ingin logout dari aplikasi?\')"><span class="icon-switch"></span> '.$l['w_logout'].'</a></span></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
}

echo '<div class="qlistCont" id="langSelID">'.K_NEWLINE;
echo '<div id="qlistTitle"><div><p><span class="icon-flag-o"></span> '.$l['w_language'].'</p><span id="qlistClose" onclick="langSelHide()">&times;<span></div></div>';
echo '<div>'.K_NEWLINE;
// language selector
//if (K_LANGUAGE_SELECTOR and (stristr($_SERVER['SCRIPT_NAME'], 'tce_test_execute.php') === false)) {
if (K_LANGUAGE_SELECTOR) {
    echo '<div class="minibutton" dir="ltr">'.K_NEWLINE;
    echo '<span class="langselector" title="change language">'.K_NEWLINE;
    $lang_array = unserialize(K_AVAILABLE_LANGUAGES);
    $lngstr = '';
    foreach ($lang_array as $lang_code => $lang_name) {
        //$lngstr .= ' ';
        if ($lang_code == K_USER_LANG) {
            $lngstr .= '<span class="selected" title="'.$lang_name.'">'.strtoupper($lang_code).'</span>';
        } else {
            // query string was removed because unnecessary
            //if (isset($_SERVER['QUERY_STRING']) AND (strlen($_SERVER['QUERY_STRING'])>0)) {
            //	$querystr = preg_replace("/([\?|\&]?)lang=([a-z]{2,3})/si", '', $_SERVER['QUERY_STRING']);
            //}
            //if (isset($querystr) AND (strlen($querystr)>0)) {
            //	$langlink = $_SERVER['SCRIPT_NAME'].'?'.str_replace('&', '&amp;', $querystr).'&amp;lang='.$lang_code;
            //} else {
                $langlink = $_SERVER['SCRIPT_NAME'].'?lang='.$lang_code;
            //}
            $lngstr .= '<a href="'.$langlink.'" class="langselector" title="'.$lang_name.'">'.strtoupper($lang_code).'</a>';
        }
    }
    //echo substr($lngstr, 3);
    echo $lngstr;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
}
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// display menu
//if($_SESSION['session_user_level']>0){
echo '<div id="scrollayer" class="scrollmenu">'.K_NEWLINE;
echo '<p id="menu_close" onclick="menuClose()">&times;</p>'.K_NEWLINE;
echo '<div id="insCont" class="ta-center px-0 py-1em">'.K_NEWLINE;
echo '	<div id="insLogo"><img style="width:77px;height:77px" src="'.K_PATH_HOST.K_PATH_TCEXAM.'cache/logo/'.K_INSTITUTION_LOGO.'"/></div>'.K_NEWLINE;
echo '	<div id="appDesc"><p class="m-0 mt-10 px-5">'.K_APP_DESC.'</p></div>'.K_NEWLINE;
echo '	<div id="insName"><p class="ft-bold m-0 px-5 mt-5">'.K_INSTITUTION_NAME.'</p></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// CSS changes for old browsers
echo '<!--[if lte IE 7]>'.K_NEWLINE;
echo '<style type="text/css">'.K_NEWLINE;
echo 'ul.menu li {text-align:left;behavior:url("../../shared/jscripts/IEmen.htc");}'.K_NEWLINE;
echo 'ul.menu ul {background-color:#003399;margin:0;padding:0;display:none;position:absolute;top:20px;left:0px;}'.K_NEWLINE;
echo 'ul.menu ul li {width:200px;text-align:left;margin:0;}'.K_NEWLINE;
echo 'ul.menu ul ul {display:none;position:absolute;top:0px;left:190px;}'.K_NEWLINE;
echo '</style>'.K_NEWLINE;
echo '<![endif]-->'.K_NEWLINE;
require_once(dirname(__FILE__).'/tce_page_menu.php');
echo '</div>'.K_NEWLINE;
//}

echo '<div class="body">'.K_NEWLINE;
include('../../shared/code/tce_page_timer.php');
//include('../../shared/code/tce_page_timer.php');
echo '<a name="topofdoc" id="topofdoc"></a>'.K_NEWLINE;
if(isset($thispage_title_icon)){
	$page_icon = $thispage_title_icon;
}else{
	$page_icon = '';
}

if(isset($_REQUEST['testid'])){
	$testid = 'id="h1_testpage"';
	if(isset($_REQUEST['terminatetest']) or isset($hide_title)){
		$testid .= 'style="display:none"';
	}
}else{
	$testid = 'id="nottestpage" class="bg-white box-bd brad-top5 bd-gray6" style="border-bottom:none"';
}

echo '<div id="containerWrapper" class="p-1em-768">';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']>0){
	if(!isset($_REQUEST['testid'])){
		echo '<h1 '.$testid.'>'.$page_icon.' '.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'</h1>'.K_NEWLINE;
	}
}
}
//============================================================+
// END OF FILE
//============================================================+
