<?php

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

echo '<div>'.K_NEWLINE;
// echo '<div></div>'.K_NEWLINE;
echo '<div>'.K_NEWLINE;
echo '<div>'.K_NEWLINE;
if(f_sc_name('tce_test_execute.php') and $_SESSION['session_user_level']>0 and isset($_REQUEST['testid'])){
	// $timeLabel = '<span class="icon-clock hidden show768"></span> <span id="timeLeftLbl" class="hidden show768 txt-small">'.$l['w_timeleft'].'</span>';
	$timeLabel = '';
}else{
	// $timeLabel = '<span class="icon-clock"></span> '.$l['w_time'];
	$timeLabel = '';
}
// echo '<label for="timer">'.$timeLabel.'</label>'.K_NEWLINE;
echo '<input type="text" name="timer" id="timer" class="form-control" value="" title="'.$l['w_clock_timer'].'" readonly="readonly"/></div>'.K_NEWLINE;
// echo '<div id="qlistTop"></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<div id="almostend" style="width:100%;text-align:center;font-size:small"></div>'.K_NEWLINE;
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
