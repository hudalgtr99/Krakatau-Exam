<?php

if(f_sc_name('tmf_show_offline_sheet.php')){
	require_once('tce_xhtml_header_offline.php');
}else{
	require_once('tce_xhtml_header.php');
}
// display header (image logo + timer)
/*
echo '<div class="header">'.K_NEWLINE;
echo '<div class="left"></div>'.K_NEWLINE;
echo '<div class="right">'.K_NEWLINE;
if(!f_sc_name('tmf_show_offline_sheet.php')){
	echo '<a name="timersection" id="timersection"></a>'.K_NEWLINE;
	include('../../shared/code/tce_page_timer.php');
}
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
*/


// display menu
echo '<div id="menuBody" class="app-sidebar sidebar-shadow bg-vicious-stance sidebar-text-light">'.K_NEWLINE;
echo '<div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>'.K_NEWLINE;
echo '<div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>'.K_NEWLINE;
echo '<div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>'.K_NEWLINE;
					

echo '<div class="scrollbar-sidebar scrollbar-container';
if(f_sc_name('tmf_show_offline_sheet.php')){
	echo 'hidden';
}
echo ' ">'.K_NEWLINE;
// echo '<div class="scrollbar-container">';
echo '<div class="app-sidebar__inner">'.K_NEWLINE;
// echo '<ul class="vertical-nav-menu">'.K_NEWLINE;
if($_SESSION['session_user_level']>0){
// echo '<div class="card mb-1 widget-content bg-midnight-bloom">';
// echo '<p>'.K_APP_DESC.'</p>'.K_NEWLINE;	
// echo '<div>'.K_NEWLINE;
// echo '<p><img width="55px" height="55px" src="'.K_PATH_HOST.K_PATH_TCEXAM.'cache/logo/'.K_INSTITUTION_LOGO.'" /></p>'.K_NEWLINE;
// echo '<p>'.K_INSTITUTION_NAME.'</p>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;
}
// echo '</div>';

// CSS changes for old browsers
/* echo '<!--[if lte IE 7]>'.K_NEWLINE;
echo '<style type="text/css">'.K_NEWLINE;
echo 'ul.menu li {text-align:left;behavior:url("../../shared/jscripts/IEmen.htc");}'.K_NEWLINE;
echo 'ul.menu ul {background-color:#003399;margin:0;padding:0;display:none;position:absolute;top:20px;left:0px;}'.K_NEWLINE;
echo 'ul.menu ul li {width:200px;text-align:left;margin:0;}'.K_NEWLINE;
echo 'ul.menu ul ul {display:none;position:absolute;top:0px;left:190px;}'.K_NEWLINE;
echo '</style>'.K_NEWLINE;
echo '<![endif]-->'.K_NEWLINE; */
require_once(dirname(__FILE__).'/tce_page_menu.php');
// echo '</ul>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '</div>'.K_NEWLINE;

echo '</div>'.K_NEWLINE; //div.menuBody

echo '<div class="app-main__outer">'.K_NEWLINE;
if(isset($thispage_title_icon)){
	$page_icon = $thispage_title_icon;
}else{
	$page_icon = '<i class="pe-7s-home icon-gradient bg-night-fade"></i> ';
}

echo '<div class="app-main__inner">'.K_NEWLINE;
// echo '<a name="topofdoc" id="topofdoc"></a>'.K_NEWLINE;
if(f_sc_name('tmf_show_offline_sheet.php')){
	echo '<div>'.K_NEWLINE;
	echo '<h1 class="pageTitle">
	<span id="menuShow" class="spmenubars spicoheader"><i class="fas fa-bars"></i></span>
	<span id="menuHide" class="spmenubars spicoheader"><i class="fas fa-times"></i></span>
	<span class="spicoheader"><i class="fas fa-school"></i></span><span class="splblheader">'.K_INSTITUTION_NAME.'</span></h1>'.K_NEWLINE;
	echo '<h1 class="pageTitle pageTitleDesc"><span class="splblheader">'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'</span></h1>'.K_NEWLINE;
}else{
	// echo '<div class="h-title d-iflex">'.K_NEWLINE;
	echo '<div class="d-print-none app-page-title pt-3 pb-0 px-4 mb-3" style="background:none">'.K_NEWLINE;
	echo '<div class="page-title-wrapper">'.K_NEWLINE;
	echo '<div class="page-title-heading">'.K_NEWLINE;
	echo '<div class="page-title-icon" style="font-size:1.5rem;padding:unset;width:45px;height:45px">'.$page_icon.'</div><div>'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).K_NEWLINE;
	if(isset($thispage_help)){
		echo '<button type="button" class="mb-2 mr-2 border-0 btn-transition btn btn-outline-info badge" data-toggle="modal" data-target="#modalPagehelp"><i class="fas fa-info-circle"></i></button>'.K_NEWLINE;
	}
	echo '</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
}
echo '</div>'.K_NEWLINE;

//============================================================+
// END OF FILE
//============================================================+
