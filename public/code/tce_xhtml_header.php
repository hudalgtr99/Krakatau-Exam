<?php

/**
 * @file
 * Outputs default XHTML header (doctype + head).
 * @package com.tecnick.tcexam.public
 * @author Nicola Asuni
 * @since 2004-04-24
 * int $pagelevel page access level (0-10), default 0
 * string $thispage_title page title, default K_SITE_TITLE
 * string $thispage_description page description, default K_SITE_DESCRIPTION
 * string $thispage_author page author, default K_SITE_AUTHOR
 * string $thispage_reply page reply to, default K_SITE_REPLY_TO
 * string $thispage_keywords page keywords, default K_SITE_KEYWORDS
 * string $thispage_icon page icon, default K_SITE_ICON
 * string $thispage_style page CSS file name, default K_SITE_STYLE
 */

/**
 */

// if necessary load default values
if (!isset($pagelevel) or empty($pagelevel)) {
    $pagelevel = 0;
}
if (!isset($thispage_title) or empty($thispage_title)) {
    $thispage_title = K_SITE_TITLE;
}
if (!isset($thispage_description) or empty($thispage_description)) {
    $thispage_description = K_SITE_DESCRIPTION;
}
if (!isset($thispage_author) or empty($thispage_author)) {
    $thispage_author = K_SITE_AUTHOR;
}
if (!isset($thispage_reply) or empty($thispage_reply)) {
    $thispage_reply = K_SITE_REPLY;
}
if (!isset($thispage_keywords) or empty($thispage_keywords)) {
    $thispage_keywords = K_SITE_KEYWORDS;
}
if (!isset($thispage_icon) or empty($thispage_icon)) {
    $thispage_icon = K_SITE_ICON;
}
if (!isset($thispage_style) or empty($thispage_style)) {
    if (strcasecmp($l['a_meta_dir'], 'rtl') == 0) {
        $thispage_style = K_SITE_STYLE_RTL;
    } else {
        $thispage_style = K_SITE_STYLE;
    }
}  

global $login_error;
if (isset($login_error) and $login_error) {
	$login_status = array("error",$l['m_login_wrong']);
	echo json_encode($login_status);
	die();
}
?>
<!doctype html>
<html class="no-js" lang="<?php echo $l['a_meta_language']; ?>" translate="no">

<head>
  <meta charset="<?php echo $l['a_meta_charset']; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  echo '<title>'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'</title>'.K_NEWLINE;
  echo '<meta name="language" content="'.$l['a_meta_language'].'" />'.K_NEWLINE;
  echo '<meta name="tcexam_level" content="'.$pagelevel.'" />'.K_NEWLINE;
  echo '<meta name="description" content="'."\x5b\x54\x43\x45\x78\x61\x6d\x5d".' '.htmlspecialchars($thispage_description, ENT_COMPAT, $l['a_meta_charset']).' ['.base64_decode(K_KEY_SECURITY).']" />'.K_NEWLINE;
  echo '<meta name="author" content="'.$thispage_author.'"/>'.K_NEWLINE;
  echo '<meta name="reply-to" content="'.htmlspecialchars($thispage_reply, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
  echo '<meta name="keywords" content="'.htmlspecialchars($thispage_keywords, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
  echo '<meta name="google" content="notranslate">'.K_NEWLINE;
  echo '<meta name="robots" content="noindex,nofollow">'.K_NEWLINE;
  echo '<meta name="googlebot" content="noindex,nofollow">'.K_NEWLINE;	
  echo '<meta property="og:title" content="'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'">'.K_NEWLINE;
  echo '<meta property="og:type" content="">'.K_NEWLINE;
  echo '<meta property="og:url" content="">'.K_NEWLINE;
  echo '<meta property="og:image" content="">'.K_NEWLINE;
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
echo '<!-- '.'T'.'C'.'E'.'x'.'a'.'m'.'19'.'73'.'01'.'04'.' -->'.K_NEWLINE;

  ?>
  <link rel="manifest" href="<?php echo K_PATH_HOST.K_PATH_TCEXAM; ?>a2hs/site.webmanifest">
  <link rel="apple-touch-icon" href="<?php echo K_PATH_HOST.K_PATH_TCEXAM; ?>a2hs/icon.png">
  <!-- Place favicon.ico in the root directory -->
  <?php
  echo '<link rel="shortcut icon" href="'.$thispage_icon.'" />'.K_NEWLINE;

  ?>
  <link rel="stylesheet" href="<?php echo $thispage_style; ?>">
  <?php
  $cscheme = unserialize(file_get_contents('../config/colorscheme.json'));
	if($cscheme['enable_ccs']){
		echo '<style>'.K_NEWLINE;
		array_shift($cscheme);
		echo ':root{'.K_NEWLINE;
		foreach($cscheme as $key => $value){

			if($key=='--bor-1'){
				echo $key.':'.$value='1px solid '.$value.';'.K_NEWLINE;
			}else{
				echo $key.':'.$value.' !important;'.K_NEWLINE;
			}
		}
		echo '}'.K_NEWLINE;
		echo '</style>'.K_NEWLINE;
	}

  if( K_DEFFONT!=='System Default' ){
	  echo '<link rel="stylesheet" href="../../fonts/'.K_DEFFONT.'/'.K_DEFFONT.'.css">';
  }
  ?>
  
  <?php //echo $svgBg.K_NEWLINE; ?>
  <!--link rel="stylesheet" href="<?php echo K_PATH_HOST.K_PATH_TCEXAM; ?>public/styles/fontawesome/css/all.min.css" type="text/css" /-->
  <meta name="theme-color" content="#fafafa">
  <?php
  if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1){
	  echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'es5.js"></script>'.K_NEWLINE;
  }
  echo '<script>'.K_NEWLINE;
  echo 'const QBLOCK_JSON = ';
  if(QBLOCK_JSON){echo 'true;';}else{echo 'false;';}
  echo K_NEWLINE;
  echo 'const LOAD_ALL_JSON = ';
  if(LOAD_ALL_JSON){echo 'true;';}else{echo 'false;';}
  echo K_NEWLINE;
  echo 'const CACHE_FEATURE = ';
  if(CACHE_FEATURE){echo 'true;';}else{echo 'false;';}
  echo K_NEWLINE;
  echo 'const K_SHOW_TERMINATE_WHEN_ALL_ANSWERED = ';
  if(K_SHOW_TERMINATE_WHEN_ALL_ANSWERED){echo 'true;';}else{echo 'false;';}
  echo K_NEWLINE;
  
  echo 'const K_SHOW_SAVE_BUTTON = ';
  if(K_SHOW_SAVE_BUTTON){echo 'true;';}else{echo 'false;';}
  echo K_NEWLINE;
  
  echo 'const K_ENABLE_DELAY = ';
  if(K_ENABLE_DELAY){echo '(Math.random()*500)*(Math.random()*10);';}else{echo '0;';}
  echo K_NEWLINE;
  
  echo 'const K_ENDTEST_PAGE = "'.K_ENDTEST_PAGE.'"';
  echo K_NEWLINE;
  
  echo 'const K_MINUTES = "'.$l['w_minutes'].'"';
  echo K_NEWLINE;
  
  $tm = unserialize(file_get_contents('../config/tmf_timer_warning.json'));
  echo 'const almostend1_time = -'.(intval($tm['almostend1_time'])*60).';';
  echo K_NEWLINE;
  echo 'const almostend1_msg = "'.$tm['almostend1_msg'].'";';
  echo K_NEWLINE;
  echo 'const almostend1_bg = "'.$tm['almostend1_bg'].'";';
  echo K_NEWLINE;
  echo 'const almostend1_col = "'.$tm['almostend1_col'].'";';
  echo K_NEWLINE;
  
  echo 'const almostend2_time = -'.(intval($tm['almostend2_time'])*60).';';
  echo K_NEWLINE;
  echo 'const almostend2_msg = "'.$tm['almostend2_msg'].'";';
  echo K_NEWLINE;
  echo 'const almostend2_bg = "'.$tm['almostend2_bg'].'";';
  echo K_NEWLINE;
  echo 'const almostend2_col = "'.$tm['almostend2_col'].'";';
  echo K_NEWLINE;
  
  echo 'const lastsec_msg = "'.$tm['lastsec_msg'].'";';
  echo K_NEWLINE;
  echo 'const lastsec_bg = "'.$tm['lastsec_bg'].'";';
  echo K_NEWLINE;
  echo 'const lastsec_col = "'.$tm['lastsec_col'].'";';
  echo K_NEWLINE;
  
  echo '</script>'.K_NEWLINE;
  
  if(K_SHOW_TERMINATE_WHEN_ALL_ANSWERED){
	echo '<style>';  
	echo '#termbtn{display:none}';
	echo '</style>';
  }
  
  
  if(!K_PUBLIC_PAGEHELP){
	  echo '<style>div.pagehelp{display:none}</style>'.K_NEWLINE;
  }
  if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo '<style>';
	echo '.tmfpatch{color: var(--col-11)!important;border:1px solid var(--col-15t);border-radius:50em;padding:0.05em 0.35em;}';
	echo 'body{background-image:url('.LOGIN_BG_IMAGE.');background-position:'.LOGIN_BG_IMAGE_POSITION.';background-size:'.LOGIN_BG_IMAGE_SIZE.';background-blend-mode:'.LOGIN_BG_IMAGE_BLEND_MODE.'}';
	echo '</style>';
	}

  ?>
<!-- </head> -->  
</head>
<?php
echo '<body>'.K_NEWLINE;

echo '<noscript>'.stripcslashes(K_JSWARN).'</noscript>'.K_NEWLINE;



echo '<div class="backdrop" id="backdrop" onclick="drawerClose()"><div id="reloadCont" style="display:none;color:#fff;position:fixed;top:45%;left:50%;transform:translate(-50%,-50%);"><div style="margin:25px auto;position:relative;font-size:xxx-large;width:50px;height:50px" class="anim-rotate"><span id="bigDeg" style="position:absolute;top:98%;left:16%;transform:translate(-50%, -50%);font-weight:lighter;font-size:65px;">&deg;</span><span style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-weight:bold"><sup>&deg;</sup></span><span style="position:absolute;top:120%;left:90%;transform:translate(-50%, -50%);"><sup>&deg;</sup></span></div><span style="cursor:pointer;pointer-events:all;padding:0.25em 1.25em;border-radius:100px;border:2px solid #fff;user-select:none" onclick="reloadCont.style.display=\'block\';backdrop(\'1\',\'1\');location.reload()">RELOAD</span></div></div>'.K_NEWLINE;

//============================================================+
// END OF FILE
//============================================================+
