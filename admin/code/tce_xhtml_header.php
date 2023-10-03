<?php

//if necessary load default values
if (!isset($pagelevel) or empty($pagelevel)) {
    $pagelevel = 0;
}
if (!isset($thispage_title) or empty($thispage_title)) {
    $thispage_title = K_TCEXAM_TITLE;
}
if (!isset($thispage_description) or empty($thispage_description)) {
    $thispage_description = K_TCEXAM_DESCRIPTION;
}
if (!isset($thispage_author) or empty($thispage_author)) {
    $thispage_author = K_TCEXAM_AUTHOR;
}
if (!isset($thispage_reply) or empty($thispage_reply)) {
    $thispage_reply = K_TCEXAM_REPLY_TO;
}
if (!isset($thispage_keywords) or empty($thispage_keywords)) {
    $thispage_keywords = K_TCEXAM_KEYWORDS;
}
if (!isset($thispage_icon) or empty($thispage_icon)) {
    $thispage_icon = K_TCEXAM_ICON;
}
if (!isset($thispage_style) or empty($thispage_style)) {
    if (strcasecmp($l['a_meta_dir'], 'rtl') == 0) {
        $thispage_style = K_TCEXAM_STYLE_RTL;
    } else {
        $thispage_style = K_TCEXAM_STYLE;
    }
}

if($_SESSION['session_user_level']<1){
	header('Location: ../../public/index.php');
	exit;
}


echo '<!doctype html>'.K_NEWLINE;
echo '<html lang="en">'.K_NEWLINE;

echo '<head>'.K_NEWLINE;
echo '<title>'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'</title>'.K_NEWLINE;
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">'.K_NEWLINE;
echo '<meta http-equiv="Content-Type" content="text/html; charset='.$l['a_meta_charset'].'" />'.K_NEWLINE;
echo '<meta name="language" content="'.$l['a_meta_language'].'" />'.K_NEWLINE;
echo '<meta name="tcexam_level" content="'.$pagelevel.'" />'.K_NEWLINE;
echo '<meta name="description" content="'.htmlspecialchars($thispage_description, ENT_COMPAT, $l['a_meta_charset']).' ['.base64_decode(K_KEY_SECURITY).']" />'.K_NEWLINE;
echo '<meta name="author" content="nick"/>'.K_NEWLINE;
echo '<meta name="reply-to" content="'.htmlspecialchars($thispage_reply, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
echo '<meta name="keywords" content="'.htmlspecialchars($thispage_keywords, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
echo '<meta name="robots" content="noindex,nofollow">'.K_NEWLINE;
echo '<meta name="googlebot" content="noindex,nofollow">'.K_NEWLINE;
echo '<meta name="msapplication-tap-highlight" content="no">'.K_NEWLINE;

?>

<?php
echo '<link rel="stylesheet" href="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/assets/css/main.css">'.K_NEWLINE;

echo '<link rel="stylesheet" href="'.K_PATH_HOST.K_PATH_TCEXAM.'admin/styles/select2.min.css">'.K_NEWLINE;
echo '<link rel="stylesheet" href="'.K_PATH_HOST.K_PATH_TCEXAM.'admin/styles/select2-bootstrap4.min.css">'.K_NEWLINE;
?>
<style>
html {font-size:15px}
.select2-search__field:focus{color:#495057;background-color:#fff;border-color:#a9bcee;outline:0;box-shadow:0 0 0 0.2rem rgb(0 123 255 / 25%)}
.select2-container{width:auto !important}
.input-group{flex-wrap:nowrap;overflow:hidden}
/*.select2-selection {display:inline-block !important; padding-bottom: 0.25em;}*/
.fixed-left{left:0 !important}
/*.select2-container--bootstrap4 {min-width:auto!important;max-width:100%!important;width:auto!important}*/
@media (max-width: 991.98px){
	.popover, .dropdown-menu {top: 25% !important}
	.app-header .app-header__content.header-mobile-open{top:60px}
}


</style>
<?php  
echo '<link rel="shortcut icon" href="'.$thispage_icon.'" />'.K_NEWLINE;
echo '<script>'.K_NEWLINE;
echo 'const K_ADDRESS_LINE1 = "'.K_ADDRESS_LINE1.'"'.K_NEWLINE;
echo 'const K_ADDRESS_LINE2 = "'.K_ADDRESS_LINE2.'"'.K_NEWLINE;
echo 'const K_ADDRESS_LINE3 = "'.K_ADDRESS_LINE3.'"'.K_NEWLINE;
echo '</script>'.K_NEWLINE;
// calendar
if (isset($enable_calendar) and $enable_calendar) {
    echo '<style type="text/css">@import url('.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar-blue.css);</style>'.K_NEWLINE;
    echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar.js"></script>'.K_NEWLINE;
    if (F_file_exists(''.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-'.$l['a_meta_language'].'.js')) {
        echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-'.$l['a_meta_language'].'.js"></script>'.K_NEWLINE;
    } else {
        echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-en.js"></script>'.K_NEWLINE;
    }
    echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar-setup.js"></script>'.K_NEWLINE;
}
echo '<!-- T'.'CE'.'x'.'am1'.'97'.'30'.'10'.'4 -->'.K_NEWLINE;

echo '</head>'.K_NEWLINE;

if(file_exists(K_PATH_HOST.K_PATH_TCEXAM.'cache/photo/'.$_SESSION['session_user_name'].'.jpg')){
	$foto=$_SESSION['session_user_name'].'.jpg';
}else{
	$foto='default.jpg';
}
echo '<body>'.K_NEWLINE;
echo '<div id="atas" class="invisible"></div>'.K_NEWLINE;
echo '<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar">'.K_NEWLINE;
echo '<div class="d-print-none app-header header-shadow">
            <div class="app-header__logo">
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
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    <div class="app-header__content">
                <div class="app-header-left">
					<img width="42px" height="42px" src="'.K_PATH_HOST.K_PATH_TCEXAM.'cache/logo/'.K_INSTITUTION_LOGO.'" />
					<div class="ml-3"><div class="small">'.K_APP_DESC.'</div><div id="insName" class="page-title-subheading">'.K_INSTITUTION_NAME.'</div></div>
                </div>
                <div class="app-header-right">
				'.K_NEWLINE;
echo '                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="'.K_PATH_HOST.K_PATH_TCEXAM.'cache/photo/'.$foto.'" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="window.location.href=\'../../public/code/tce_user_change_password.php\'">Ganti Password</button>
                                            <a href="tce_logout.php" onclick="return confirm(\'Yakin ingin logout dari aplikasi ?\')" type="button" tabindex="0" class="dropdown-item">Logout</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        '.urldecode($_SESSION['session_user_firstname']).'
                                    </div>
                                    <div class="widget-subheading">
                                        Level '.urldecode($_SESSION['session_user_level']).'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div>'.K_NEWLINE;
echo '<div class="app-main">'.K_NEWLINE;
global $login_error;
if (isset($login_error) and $login_error) {
    F_print_error('WARNING', $l['m_login_wrong']);
}

//============================================================+
// END OF FILE
//============================================================+
