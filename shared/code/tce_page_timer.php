<?php
//============================================================+
// File name   : tce_page_timer.php
// Begin       : 2004-04-29
// Last Update : 2010-10-05
//
// Description : Display timer (date-time + countdown).
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
//    Copyright (C) 2004-2010 Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display client timer (date-time + countdown).
 * @package com.tecnick.tcexam.shared
 * @author Nicola Asuni
 * @since 2004-04-29
 */

if (!isset($_REQUEST['examtime'])) {
    $examtime = 0; // remaining exam time in seconds
    $enable_countdown = 'false';
    $timeout_logout = 'false';
} else {
    $examtime = floatval($_REQUEST['examtime']);
    $enable_countdown = 'true';
    if (isset($_REQUEST['timeout_logout']) and ($_REQUEST['timeout_logout'])) {
        $timeout_logout = 'true';
    } else {
        $timeout_logout = 'false';
    }
}
if(f_sc_name('tce_test_execute.php') and $_SESSION['session_user_level']>0 and isset($_REQUEST['testid'])){
		$timerTestExecute='timerTestExecute';
		$utilTop='utilTopTest';
		$icon_settings = '<span id="iconsettings" class="icon-settings txt-lg c-pointer" onclick="qSettingToggle(this)"></span>';
	}else{
		$timerTestExecute='timerClock';
		$utilTop='utilTopClock';
		$icon_settings = '';
	}
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" id="timerform">'.K_NEWLINE;

echo '<div id="utilTop" class="d-flex '.$utilTop.' jc-sb fwrap">'.K_NEWLINE;
echo '<div id="nosoalTop" class="d-flex"><span class="hidden show768 mr-7 ft-500 ml-5">'.ucwords($l['w_question_no']).'</span></div>'.$icon_settings.K_NEWLINE;
echo '<div class="d-flex">'.K_NEWLINE;
echo '<div id="timerdiv" class="d-flex '.$timerTestExecute.'">'.K_NEWLINE;
if(f_sc_name('tce_test_execute.php') and $_SESSION['session_user_level']>0 and isset($_REQUEST['testid'])){
	// $timeLabel = '<span class="icon-clock hidden show768"></span> <span id="timeLeftLbl" class="hidden show768 txt-small">'.$l['w_timeleft'].'</span>';
	$timeLabel = '<span id="timeLeftLbl" class="hidden show768">'.$l['w_timeleft'].'</span>';
}else{
	// $timeLabel = '<span class="icon-clock"></span> '.$l['w_time'];
	$timeLabel = ''.$l['w_time'];
}
echo '<label for="timer" class="timerlabel hidden show768">'.$timeLabel.'</label>'.K_NEWLINE;
echo '<input type="text" name="timer" id="timer" value="" size="29" maxlength="29" title="'.$l['w_clock_timer'].'" readonly="readonly"/></div>'.K_NEWLINE;
echo '<div id="qlistTop"></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div id="almostend" style="width:100%;text-align:center;font-size:small"></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
//echo '&nbsp;</div>'.K_NEWLINE;
echo '</form>'.K_NEWLINE;
if(defined('K_SITE_TIMER_SCRIPT')){
	echo '<script src="'.K_SITE_TIMER_SCRIPT.'" type="text/javascript"></script>'.K_NEWLINE;
}else{
	echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'timer.js" type="text/javascript"></script>'.K_NEWLINE;
}
echo '<script type="text/javascript">'.K_NEWLINE;
echo '//<![CDATA['.K_NEWLINE;
echo 'FJ_start_timer('.$enable_countdown.', '.(time() - $examtime).', \''.addslashes($l['m_exam_end_time']).'\', '.$timeout_logout.', '.(round(microtime(true) * 1000)).');'.K_NEWLINE;
echo '//]]>'.K_NEWLINE;
echo '</script>'.K_NEWLINE;

//============================================================+
// END OF FILE
//============================================================+
