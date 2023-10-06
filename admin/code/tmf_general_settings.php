<?php
require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_USERS;

require_once('../../shared/code/tce_authorization.php');

require_once('../../shared/config/tce_user_registration.php');

$json = unserialize(file_get_contents(K_PATH_MAIN.'shared/config/tmf_general_settings.json'));
if(isset($_GET['imglogo'])){
	foreach(glob(K_PATH_CACHE.'logo/*') as $filename){
		echo '<option data-img-src="../../cache/logo/'.basename($filename).'" value="'.basename($filename).'" ';
		if(basename($filename)===$json['logoImg']){
			echo ' selected="selected"';
		}
		echo '>'.basename($filename).'</option>'.K_NEWLINE;
	}
	die();	
}


if (!isset($_POST['realtime_grading']) or (empty($_POST['realtime_grading']))) {
    $realtime_grading = false;
} else {
    $realtime_grading = F_getBoolean($_REQUEST['realtime_grading']);
}

if (!isset($_POST['answer_all_questions']) or (empty($_POST['answer_all_questions']))) {
    $answer_all_questions = false;
} else {
    $answer_all_questions = F_getBoolean($_REQUEST['answer_all_questions']);
}

if (!isset($_POST['show_terminate_when_all_answered']) or (empty($_POST['show_terminate_when_all_answered']))) {
    $show_terminate_when_all_answered = false;
} else {
    $show_terminate_when_all_answered = F_getBoolean($_REQUEST['show_terminate_when_all_answered']);
}

if (!isset($_POST['show_save_button']) or (empty($_POST['show_save_button']))) {
    $show_save_button = false;
} else {
    $show_save_button = F_getBoolean($_REQUEST['show_save_button']);
}

if (!isset($_POST['chat_feature']) or (empty($_POST['chat_feature']))) {
    $chat_feature = false;
} else {
    $chat_feature = F_getBoolean($_REQUEST['chat_feature']);
}

if (!isset($_POST['display_test_desc']) or (empty($_POST['display_test_desc']))) {
    $display_test_desc = false;
} else {
    $display_test_desc = F_getBoolean($_REQUEST['display_test_desc']);
}

if (!isset($_POST['jsonFile']) or (empty($_POST['jsonFile']))) {
    $jsonFile = false;
} else {
    $jsonFile = F_getBoolean($_REQUEST['jsonFile']);
}

if (!isset($_POST['createAllJsonFileOnStartup']) or (empty($_POST['createAllJsonFileOnStartup']))) {
    $createAllJsonFileOnStartup = false;
} else {
    $createAllJsonFileOnStartup = F_getBoolean($_REQUEST['createAllJsonFileOnStartup']);
}

if (!isset($_POST['cacheFeature']) or (empty($_POST['cacheFeature']))) {
    $cacheFeature = false;
} else {
    $cacheFeature = F_getBoolean($_REQUEST['cacheFeature']);
}

if (!isset($_POST['clearStorageOnLogin']) or (empty($_POST['clearStorageOnLogin']))) {
    $clearStorageOnLogin = false;
} else {
    $clearStorageOnLogin = F_getBoolean($_REQUEST['clearStorageOnLogin']);
}

if (!isset($_POST['hideExpTest']) or (empty($_POST['hideExpTest']))) {
    $hideExpTest = false;
} else {
    $hideExpTest = F_getBoolean($_REQUEST['hideExpTest']);
}

if (!isset($_POST['PDFResult']) or (empty($_POST['PDFResult']))) {
    $PDFResult = false;
} else {
    $PDFResult = F_getBoolean($_REQUEST['PDFResult']);
}

if (!isset($_POST['pubPageHelp']) or (empty($_POST['pubPageHelp']))) {
    $pubPageHelp = false;
} else {
    $pubPageHelp = F_getBoolean($_REQUEST['pubPageHelp']);
}

if (!isset($_POST['logoImg']) or (empty($_POST['logoImg']))) {
    $logoImg = false;
} else {
    $logoImg = F_getBoolean($_REQUEST['logoImg']);
}

if (!isset($_POST['SSGenJSON']) or (empty($_POST['SSGenJSON']))) {
    $SSGenJSON = false;
} else {
    $SSGenJSON = F_getBoolean($_REQUEST['SSGenJSON']);
}

if (!isset($_POST['triggerCacheAllFromServer']) or (empty($_POST['triggerCacheAllFromServer']))) {
    $triggerCacheAllFromServer = false;
} else {
    $triggerCacheAllFromServer = F_getBoolean($_REQUEST['triggerCacheAllFromServer']);
}

if (!isset($_POST['forgotPass']) or (empty($_POST['forgotPass']))) {
    $forgotPass = false;
} else {
    $forgotPass = F_getBoolean($_REQUEST['forgotPass']);
}

if (!isset($_POST['enableMultiLogin']) or (empty($_POST['enableMultiLogin']))) {
    $enableMultiLogin = false;
} else {
    $enableMultiLogin = F_getBoolean($_REQUEST['enableMultiLogin']);
}

if (!isset($_POST['userReg']) or (empty($_POST['userReg']))) {
    $userReg = false;
} else {
    $userReg = F_getBoolean($_REQUEST['userReg']);
}

if (!isset($_POST['enable_greeting']) or (empty($_POST['enable_greeting']))) {
    $enable_greeting = false;
} else {
    $enable_greeting = F_getBoolean($_REQUEST['enable_greeting']);
}

if (!isset($_POST['enable_delay']) or (empty($_POST['enable_delay']))) {
    $enable_delay = false;
} else {
    $enable_delay = F_getBoolean($_REQUEST['enable_delay']);
}

if (!isset($_POST['enable_langsel']) or (empty($_POST['enable_langsel']))) {
    $enable_langsel = false;
} else {
    $enable_langsel = F_getBoolean($_REQUEST['enable_langsel']);
}

if (!isset($_POST['enable_ccs']) or (empty($_POST['enable_ccs']))) {
    $enable_ccs = false;
} else {
    $enable_ccs = F_getBoolean($_REQUEST['enable_ccs']);
}

if(isset($_POST['update'])){
	$arr = array();
	$arr['siteName'] = urlencode(stripcslashes(strip_tags($_POST['siteName'])));
	$arr['siteDesc'] = urlencode(stripcslashes(strip_tags($_POST['siteDesc'])));
	$arr['siteAuthor'] = urlencode(stripcslashes(strip_tags($_POST['siteAuthor'])));
	$arr['siteReplyTo'] = urlencode(stripcslashes(strip_tags($_POST['siteReplyTo'])));
	$arr['siteKeyword'] = urlencode(stripcslashes(strip_tags($_POST['siteKeyword'])));
	$arr['defLang'] = strip_tags($_POST['defLang']);
	$arr['logoutURL'] = urlencode(strip_tags($_POST['logoutURL']));
	$arr['jsWarn'] = urlencode(stripcslashes($_POST['jsWarn']));
	$arr['clientDisMsg'] = urlencode(stripcslashes($_POST['clientDisMsg']));
	$arr['timezone'] = strip_tags($_POST['timezone']);
	$arr['clientUA'] = strip_tags($_POST['clientUA']);
	$arr['clientVer'] = strip_tags($_POST['clientVer']);
	$arr['appName'] = stripcslashes(strip_tags($_POST['appName']));
	$arr['appShortName'] = stripcslashes(strip_tags($_POST['appShortName']));
	$arr['institutionName'] = stripcslashes(strip_tags($_POST['institutionName']));
	$arr['endtest_page'] = strip_tags($_POST['endtest_page']);
	$arr['addrLine1'] = stripcslashes(strip_tags($_POST['addrLine1']));
	$arr['addrLine2'] = stripcslashes(strip_tags($_POST['addrLine2']));
	$arr['addrLine3'] = stripcslashes(strip_tags($_POST['addrLine3']));
	$arr['realtime_grading'] = $realtime_grading;
	$arr['answer_all_questions'] = $answer_all_questions;
	$arr['show_terminate_when_all_answered'] = $show_terminate_when_all_answered;
	if(intval(strip_tags($_POST['allow_submit_after']))>100){
		$allow_submit_after = 100;
	}else{
		$allow_submit_after = intval(strip_tags($_POST['allow_submit_after']));
	}
	$arr['allow_submit_after'] = $allow_submit_after;
	$arr['show_save_button'] = $show_save_button;
	$arr['hideExpTest'] = $hideExpTest;
	$arr['PDFResult'] = $PDFResult;
	$arr['pubPageHelp'] = $pubPageHelp;
	$arr['jsonFile'] = $jsonFile;
	$arr['SSGenJSON'] = $SSGenJSON;
	$arr['triggerCacheAllFromServer'] = $triggerCacheAllFromServer;
	$arr['forgotPass'] = $forgotPass;
	$arr['enableMultiLogin'] = $enableMultiLogin;
	$arr['userReg'] = $userReg;
	$arr['enable_langsel'] = $enable_langsel;
	$arr['createAllJsonFileOnStartup'] = $createAllJsonFileOnStartup;
	$arr['cacheFeature'] = $cacheFeature;
	$arr['enable_delay'] = $enable_delay;
	$arr['clearStorageOnLogin'] = $clearStorageOnLogin;
	$arr['chat_feature'] = $chat_feature;
	$arr['display_test_desc'] = $display_test_desc;
	$arr['loginBg'] = strip_tags($_POST['loginBg']);
	$arr['loginBgPosition'] = strip_tags($_POST['loginBgPosition']);
	$arr['defFont'] = strip_tags($_POST['defFont']);
	$arr['logoImg'] = strip_tags($_POST['logoImg']);
	$arr['loginBgSize'] = strip_tags($_POST['loginBgSize']);
	$arr['loginBgBlend'] = strip_tags($_POST['loginBgBlend']);

	$gsfile = K_PATH_MAIN.'shared/config/tmf_general_settings.json';
	chmod($gsfile, 0777);
	$fp = fopen($gsfile, 'w');
	fwrite($fp, serialize($arr));
	fclose($fp);
	
	$manifest_arr = array(
		"background_color"=>"white",
		"description"=>strip_tags($_POST['appName']),
		"name"=>stripcslashes(strip_tags($_POST['appName']." - ".$_POST['institutionName'])),
		"short_name"=>stripcslashes(strip_tags($_POST['appShortName']." ".$_POST['institutionName'])),
		"display"=>"standalone",
		"icons" => [
			array(
				"src"=>"android-icon-36x36.png",
				"sizes"=>"36x36",
				"type"=>"image/png",
				"density"=>"0.75"
			),
			array(
				   "src"=>"android-icon-48x48.png",
				   "sizes"=>"48x48",
				   "type"=>"image/png",
				   "density"=>"1.0"
			),
			array(
			   "src"=>"android-icon-72x72.png",
			   "sizes"=>"72x72",
			   "type"=>"image/png",
			   "density"=>"1.5"
			),
			array(
				   "src"=>"android-icon-96x96.png",
				   "sizes"=>"96x96",
				   "type"=>"image/png",
				   "density"=>"2.0"
			),
			array(
				   "src"=>"android-icon-144x144.png",
				   "sizes"=>"144x144",
				   "type"=>"image/png",
				   "density"=>"3.0"
			),
			array(
				   "src"=>"android-icon-192x192.png",
				   "sizes"=>"192x192",
				   "type"=>"image/png",
				   "density"=>"4.0"
			)],
		"start_url"=>K_PATH_HOST.K_PATH_TCEXAM."public/code/index.php?utm_source=homescreen"	
		);
		
	$fpm = fopen(K_PATH_MAIN.'a2hs/site.webmanifest', 'w');
	fwrite($fpm, stripcslashes(json_encode($manifest_arr)));
	fclose($fpm);
	chmod($gsfile, 0444);
	
	header('Location: tmf_general_settings.php');
	// die();
}

if(isset($_POST['update-greeting'])){
	$arr = array();
	$arr['enable_greeting'] = $enable_greeting;
	$arr['greetLine1'] = strip_tags($_POST['greetLine1']);
	$arr['greetLine2'] = strip_tags($_POST['greetLine2']);
	
	$grfile = K_PATH_MAIN.'public/config/tmf_greetings.json';
	chmod($grfile, 0777);
	
	$fp = fopen($grfile, 'w');
	fwrite($fp, serialize($arr));
	fclose($fp);
	chmod($grfile, 0444);
}

if(isset($_POST['update-addinfologin'])){
	$arr = array();
	$arr['ail_beforefield'] = strip_tags($_POST['ail_beforefield']);
	$arr['ail_afterfield'] = strip_tags($_POST['ail_afterfield']);
	
	$ailfile = K_PATH_MAIN.'public/config/tmf_additional_info_login.json';
	chmod($ailfile, 0777);
	
	$fp = fopen($ailfile, 'w');
	fwrite($fp, serialize($arr));
	fclose($fp);
	chmod($ailfile, 0444);
}

if(isset($_POST['update-timerwarning'])){
	$arr = array();
	$arr['almostend1_time'] = strip_tags($_POST['almostend1_time']);
	$arr['almostend1_msg'] = strip_tags($_POST['almostend1_msg']);
	$arr['almostend1_bg'] = strip_tags($_POST['almostend1_bg']);
	$arr['almostend1_col'] = strip_tags($_POST['almostend1_col']);
	$arr['almostend2_time'] = strip_tags($_POST['almostend2_time']);
	$arr['almostend2_msg'] = strip_tags($_POST['almostend2_msg']);
	$arr['almostend2_bg'] = strip_tags($_POST['almostend2_bg']);
	$arr['almostend2_col'] = strip_tags($_POST['almostend2_col']);
	
	$arr['lastsec_msg'] = strip_tags($_POST['lastsec_msg']);
	$arr['lastsec_bg'] = strip_tags($_POST['lastsec_bg']);
	$arr['lastsec_col'] = strip_tags($_POST['lastsec_col']);
	
	$twfile = K_PATH_MAIN.'public/config/tmf_timer_warning.json';
	chmod($twfile, 0777);
	
	$fp = fopen($twfile, 'w');
	fwrite($fp, serialize($arr));
	fclose($fp);
	
	chmod($twfile, 0444);
}

if(isset($_POST['update-colorscheme'])){
	$arr = array();
	$arr['enable_ccs'] = $enable_ccs;
	$arr['--link'] = strip_tags($_POST['--link']);
	$arr['--header'] = strip_tags($_POST['--header']);
	$arr['--col-1'] = strip_tags($_POST['--col-1']);
	$arr['--col-1t'] = strip_tags($_POST['--col-1t']);
	$arr['--col-2'] = strip_tags($_POST['--col-2']);
	$arr['--col-2t'] = strip_tags($_POST['--col-2t']);
	$arr['--col-3'] = strip_tags($_POST['--col-3']);
	$arr['--col-3t'] = strip_tags($_POST['--col-3t']);
	$arr['--col-4'] = strip_tags($_POST['--col-4']);
	$arr['--col-4t'] = strip_tags($_POST['--col-4t']);
	$arr['--col-5'] = strip_tags($_POST['--col-5']);
	$arr['--col-5l'] = strip_tags($_POST['--col-5l']);
	$arr['--col-5a'] = strip_tags($_POST['--col-5a']);
	$arr['--col-6'] = strip_tags($_POST['--col-6']);
	$arr['--col-7'] = strip_tags($_POST['--col-7']);
	$arr['--col-7t'] = strip_tags($_POST['--col-7t']);
	$arr['--col-8'] = strip_tags($_POST['--col-8']);
	$arr['--col-9'] = strip_tags($_POST['--col-9']);
	$arr['--col-9t'] = strip_tags($_POST['--col-9t']);
	$arr['--col-10'] = strip_tags($_POST['--col-10']);
	$arr['--col-10t'] = strip_tags($_POST['--col-10t']);
	$arr['--col-11'] = strip_tags($_POST['--col-11']);
	$arr['--col-12'] = strip_tags($_POST['--col-12']);
	$arr['--col-13'] = strip_tags($_POST['--col-13']);
	$arr['--col-14'] = strip_tags($_POST['--col-14']);
	$arr['--col-15'] = strip_tags($_POST['--col-15']);
	$arr['--col-15t'] = strip_tags($_POST['--col-15t']);
	$arr['--bor-1'] = strip_tags($_POST['--bor-1']);
	$arr['--bor-col1'] = strip_tags($_POST['--bor-col1']);
	
	$csfile = K_PATH_MAIN.'public/config/colorscheme.json';
	chmod($csfile, 0777);
	
	$fp = fopen($csfile, 'w');
	fwrite($fp, serialize($arr));
	// fwrite($fp, json_encode($qblock_arr));
	fclose($fp);

	chmod($csfile, 0444);
}


$thispage_title = "General Settings";
$thispage_title_icon = "<i class='pe-7s-settings icon-gradient bg-amy-crisp'></i> ";
$thispage_help = 'Mengatur beberapa aspek umum mengenai situs, data instansi maupun pengaturan umum lainnya.';

require_once('tce_page_header.php');

echo '<link rel="stylesheet" type="text/css" href="../../shared/jscripts/image-picker/image-picker.css" />'.K_NEWLINE;
echo '<style>
	.thumbnail img{width:100px;max-width:100%}
	ul.thumbnails.image_picker_selector{padding-top:2em}
	ul.thumbnails li {margin-right:2em !important}
	div.thumbnail{position:relative;background:#fff}
	
</style>';


echo '<link href="../../shared/jscripts/vendor/dropzonejs/dropzone.css" rel="stylesheet">'.K_NEWLINE;

echo '<style>.dropzone{border: 2px dashed rgba(0, 0, 0, 0.3);border-radius:10px}</style>'.K_NEWLINE;

// require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_form_admin.php');

/**
<script>

	function getImgLogo(){
		$.ajax({
				'url': 'tmf_general_settings.php?imglogo',
				'type': 'GET',
				'beforeSend': function(result){
					$('#logoImg').html('<option>Loading... Please wait!</option>');
				},
				'success': function(result){
					$('#logoImg').html(result);
				}		
		});
	}	


</script>
**/

$jsonGreetings = unserialize(file_get_contents(K_PATH_MAIN.'public/config/tmf_greetings.json'));
$lbam = unserialize(file_get_contents(K_PATH_MAIN.'public/config/tmf_additional_info_login.json'));
$tm = unserialize(file_get_contents(K_PATH_MAIN.'public/config/tmf_timer_warning.json'));
$cscheme = unserialize(file_get_contents(K_PATH_MAIN.'public/config/colorscheme.json'));

function F_settingmenu($title,$color,$icon,$target,$class){
	$res = '<div style="cursor:pointer" onclick="this.parentNode.parentNode.parentNode.style.display = \'none\';document.getElementById(\''.$target.'\').setAttribute(\'class\',\''.$class.'\')" class="card card-body flex-row align-items-center justify-content-between"><h6 class="m-0">'.$title.'</h6><span class="btn btn-'.$color.'"><i class="'.$icon.'"></i></span></div>';
	return $res;
}

echo '<div class="mb-3">'.K_NEWLINE;
echo '<div class="tceformbox">'.K_NEWLINE;

echo '<div id="settingmenu">'.K_NEWLINE;
echo '<div class="row">'.K_NEWLINE;
echo '<div class="col-md-6 p-1">'.F_settingmenu('SITE SETTINGS','primary','fa fa-cog','sitesettings','main-card mb-3 card animated fadeIn').'</div>'.K_NEWLINE;
echo '<div class="col-md-6 p-1">'.F_settingmenu('AFTER LOGIN GREETING','success','fa fa-bullhorn','afterlogingreeting','animated fadeIn').'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div class="row">'.K_NEWLINE;
echo '<div class="col-md-6 p-1">'.F_settingmenu('LOGIN BOX ADDITIONAL MESSAGE','alternate','fa fa-comments','loginboxadditionalmessage','animated fadeIn').'</div>'.K_NEWLINE;
echo '<div class="col-md-6 p-1">'.F_settingmenu('TIMER WARNING','warning','fa fa-history','timerwarning','animated fadeIn').'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<div class="row">'.K_NEWLINE;
echo '<div class="col-md-6 p-1">'.F_settingmenu('CUSTOM COLOR SCHEME FOR PUBLIC','info','fa fa-paint-brush','customcolorschemeforpublic','animated fadeIn').'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="main-card mb-3 card d-none" id="sitesettings">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="POST" id="f_sitesettings">';
echo '<fieldset>';
echo '<div class="card-header text-left justify-content-between px-3"><i class="pe-7s-settings mr-2"></i> Site Settings <span onclick="this.parentNode.parentNode.parentNode.parentNode.setAttribute(\'class\',\'card-header text-left justify-content-between px-3 d-none\');document.getElementById(\'settingmenu\').removeAttribute(\'style\')" class="text-danger"><i class="fa fa-times-circle"></i></span></div>';
echo '<div class="card-body">';
echo getFormRowTextInput('appName', 'App Description', 'Application Description', '', $json['appName'], '', 255, false, false, false,'',true);
echo getFormRowTextInput('appShortName', 'App Short Description', 'Application Short Description', '', $json['appShortName'], '', 255, false, false, false,'',true);
echo getFormRowTextInput('siteName', 'Site Name', 'Site Name', '', urldecode(stripcslashes($json['siteName'])), '', 255, false, false, false,'',true);
echo getFormRowTextInput('siteDesc', 'Site Description', 'Site Description', '', urldecode(stripcslashes($json['siteDesc'])), '', 255, false, false, false,'',true);
echo '<div class="form-row">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('siteAuthor', 'Site Author', 'Site Author', '', urldecode(stripcslashes($json['siteAuthor'])), '', 255, false, false, false,'',true);
echo '</div>';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('siteReplyTo', 'Site Reply-to', 'Site Reply-to', '', urldecode(stripcslashes($json['siteReplyTo'])), '', 255, false, false, false,'',true);
echo '</div>';
echo '</div>';
echo getFormRowTextInput('siteKeyword', 'Site Keyword', 'Site Keyword', '', urldecode(stripcslashes($json['siteKeyword'])), '', 255, false, false, false,'',true);

$timezones = array(
    'America/Adak' => '(GMT-10:00) America/Adak (Hawaii-Aleutian Standard Time)',
	'America/Atka' => '(GMT-10:00) America/Atka (Hawaii-Aleutian Standard Time)',
	'America/Anchorage' => '(GMT-9:00) America/Anchorage (Alaska Standard Time)',
	'America/Juneau' => '(GMT-9:00) America/Juneau (Alaska Standard Time)',
	'America/Nome' => '(GMT-9:00) America/Nome (Alaska Standard Time)',
	'America/Yakutat' => '(GMT-9:00) America/Yakutat (Alaska Standard Time)',
	'America/Dawson' => '(GMT-8:00) America/Dawson (Pacific Standard Time)',
	'America/Ensenada' => '(GMT-8:00) America/Ensenada (Pacific Standard Time)',
	'America/Los_Angeles' => '(GMT-8:00) America/Los_Angeles (Pacific Standard Time)',
	'America/Tijuana' => '(GMT-8:00) America/Tijuana (Pacific Standard Time)',
	'America/Vancouver' => '(GMT-8:00) America/Vancouver (Pacific Standard Time)',
	'America/Whitehorse' => '(GMT-8:00) America/Whitehorse (Pacific Standard Time)',
	'Canada/Pacific' => '(GMT-8:00) Canada/Pacific (Pacific Standard Time)',
	'Canada/Yukon' => '(GMT-8:00) Canada/Yukon (Pacific Standard Time)',
	'Mexico/BajaNorte' => '(GMT-8:00) Mexico/BajaNorte (Pacific Standard Time)',
	'America/Boise' => '(GMT-7:00) America/Boise (Mountain Standard Time)',
	'America/Cambridge_Bay' => '(GMT-7:00) America/Cambridge_Bay (Mountain Standard Time)',
	'America/Chihuahua' => '(GMT-7:00) America/Chihuahua (Mountain Standard Time)',
	'America/Dawson_Creek' => '(GMT-7:00) America/Dawson_Creek (Mountain Standard Time)',
	'America/Denver' => '(GMT-7:00) America/Denver (Mountain Standard Time)',
	'America/Edmonton' => '(GMT-7:00) America/Edmonton (Mountain Standard Time)',
	'America/Hermosillo' => '(GMT-7:00) America/Hermosillo (Mountain Standard Time)',
	'America/Inuvik' => '(GMT-7:00) America/Inuvik (Mountain Standard Time)',
	'America/Mazatlan' => '(GMT-7:00) America/Mazatlan (Mountain Standard Time)',
	'America/Phoenix' => '(GMT-7:00) America/Phoenix (Mountain Standard Time)',
	'America/Shiprock' => '(GMT-7:00) America/Shiprock (Mountain Standard Time)',
	'America/Yellowknife' => '(GMT-7:00) America/Yellowknife (Mountain Standard Time)',
	'Canada/Mountain' => '(GMT-7:00) Canada/Mountain (Mountain Standard Time)',
	'Mexico/BajaSur' => '(GMT-7:00) Mexico/BajaSur (Mountain Standard Time)',
	'America/Belize' => '(GMT-6:00) America/Belize (Central Standard Time)',
	'America/Cancun' => '(GMT-6:00) America/Cancun (Central Standard Time)',
	'America/Chicago' => '(GMT-6:00) America/Chicago (Central Standard Time)',
	'America/Costa_Rica' => '(GMT-6:00) America/Costa_Rica (Central Standard Time)',
	'America/El_Salvador' => '(GMT-6:00) America/El_Salvador (Central Standard Time)',
	'America/Guatemala' => '(GMT-6:00) America/Guatemala (Central Standard Time)',
	'America/Knox_IN' => '(GMT-6:00) America/Knox_IN (Central Standard Time)',
	'America/Managua' => '(GMT-6:00) America/Managua (Central Standard Time)',
	'America/Menominee' => '(GMT-6:00) America/Menominee (Central Standard Time)',
	'America/Merida' => '(GMT-6:00) America/Merida (Central Standard Time)',
	'America/Mexico_City' => '(GMT-6:00) America/Mexico_City (Central Standard Time)',
	'America/Monterrey' => '(GMT-6:00) America/Monterrey (Central Standard Time)',
	'America/Rainy_River' => '(GMT-6:00) America/Rainy_River (Central Standard Time)',
	'America/Rankin_Inlet' => '(GMT-6:00) America/Rankin_Inlet (Central Standard Time)',
	'America/Regina' => '(GMT-6:00) America/Regina (Central Standard Time)',
	'America/Swift_Current' => '(GMT-6:00) America/Swift_Current (Central Standard Time)',
	'America/Tegucigalpa' => '(GMT-6:00) America/Tegucigalpa (Central Standard Time)',
	'America/Winnipeg' => '(GMT-6:00) America/Winnipeg (Central Standard Time)',
	'Canada/Central' => '(GMT-6:00) Canada/Central (Central Standard Time)',
	'Canada/East-Saskatchewan' => '(GMT-6:00) Canada/East-Saskatchewan (Central Standard Time)',
	'Canada/Saskatchewan' => '(GMT-6:00) Canada/Saskatchewan (Central Standard Time)',
	'Chile/EasterIsland' => '(GMT-6:00) Chile/EasterIsland (Easter Is. Time)',
	'Mexico/General' => '(GMT-6:00) Mexico/General (Central Standard Time)',
	'America/Atikokan' => '(GMT-5:00) America/Atikokan (Eastern Standard Time)',
	'America/Bogota' => '(GMT-5:00) America/Bogota (Colombia Time)',
	'America/Cayman' => '(GMT-5:00) America/Cayman (Eastern Standard Time)',
	'America/Coral_Harbour' => '(GMT-5:00) America/Coral_Harbour (Eastern Standard Time)',
	'America/Detroit' => '(GMT-5:00) America/Detroit (Eastern Standard Time)',
	'America/Fort_Wayne' => '(GMT-5:00) America/Fort_Wayne (Eastern Standard Time)',
	'America/Grand_Turk' => '(GMT-5:00) America/Grand_Turk (Eastern Standard Time)',
	'America/Guayaquil' => '(GMT-5:00) America/Guayaquil (Ecuador Time)',
	'America/Havana' => '(GMT-5:00) America/Havana (Cuba Standard Time)',
	'America/Indianapolis' => '(GMT-5:00) America/Indianapolis (Eastern Standard Time)',
	'America/Iqaluit' => '(GMT-5:00) America/Iqaluit (Eastern Standard Time)',
	'America/Jamaica' => '(GMT-5:00) America/Jamaica (Eastern Standard Time)',
	'America/Lima' => '(GMT-5:00) America/Lima (Peru Time)',
	'America/Louisville' => '(GMT-5:00) America/Louisville (Eastern Standard Time)',
	'America/Montreal' => '(GMT-5:00) America/Montreal (Eastern Standard Time)',
	'America/Nassau' => '(GMT-5:00) America/Nassau (Eastern Standard Time)',
	'America/New_York' => '(GMT-5:00) America/New_York (Eastern Standard Time)',
	'America/Nipigon' => '(GMT-5:00) America/Nipigon (Eastern Standard Time)',
	'America/Panama' => '(GMT-5:00) America/Panama (Eastern Standard Time)',
	'America/Pangnirtung' => '(GMT-5:00) America/Pangnirtung (Eastern Standard Time)',
	'America/Port-au-Prince' => '(GMT-5:00) America/Port-au-Prince (Eastern Standard Time)',
	'America/Resolute' => '(GMT-5:00) America/Resolute (Eastern Standard Time)',
	'America/Thunder_Bay' => '(GMT-5:00) America/Thunder_Bay (Eastern Standard Time)',
	'America/Toronto' => '(GMT-5:00) America/Toronto (Eastern Standard Time)',
	'Canada/Eastern' => '(GMT-5:00) Canada/Eastern (Eastern Standard Time)',
	'America/Caracas' => '(GMT-4:-30) America/Caracas (Venezuela Time)',
	'America/Anguilla' => '(GMT-4:00) America/Anguilla (Atlantic Standard Time)',
	'America/Antigua' => '(GMT-4:00) America/Antigua (Atlantic Standard Time)',
	'America/Aruba' => '(GMT-4:00) America/Aruba (Atlantic Standard Time)',
	'America/Asuncion' => '(GMT-4:00) America/Asuncion (Paraguay Time)',
	'America/Barbados' => '(GMT-4:00) America/Barbados (Atlantic Standard Time)',
	'America/Blanc-Sablon' => '(GMT-4:00) America/Blanc-Sablon (Atlantic Standard Time)',
	'America/Boa_Vista' => '(GMT-4:00) America/Boa_Vista (Amazon Time)',
	'America/Campo_Grande' => '(GMT-4:00) America/Campo_Grande (Amazon Time)',
	'America/Cuiaba' => '(GMT-4:00) America/Cuiaba (Amazon Time)',
	'America/Curacao' => '(GMT-4:00) America/Curacao (Atlantic Standard Time)',
	'America/Dominica' => '(GMT-4:00) America/Dominica (Atlantic Standard Time)',
	'America/Eirunepe' => '(GMT-4:00) America/Eirunepe (Amazon Time)',
	'America/Glace_Bay' => '(GMT-4:00) America/Glace_Bay (Atlantic Standard Time)',
	'America/Goose_Bay' => '(GMT-4:00) America/Goose_Bay (Atlantic Standard Time)',
	'America/Grenada' => '(GMT-4:00) America/Grenada (Atlantic Standard Time)',
	'America/Guadeloupe' => '(GMT-4:00) America/Guadeloupe (Atlantic Standard Time)',
	'America/Guyana' => '(GMT-4:00) America/Guyana (Guyana Time)',
	'America/Halifax' => '(GMT-4:00) America/Halifax (Atlantic Standard Time)',
	'America/La_Paz' => '(GMT-4:00) America/La_Paz (Bolivia Time)',
	'America/Manaus' => '(GMT-4:00) America/Manaus (Amazon Time)',
	'America/Marigot' => '(GMT-4:00) America/Marigot (Atlantic Standard Time)',
	'America/Martinique' => '(GMT-4:00) America/Martinique (Atlantic Standard Time)',
	'America/Moncton' => '(GMT-4:00) America/Moncton (Atlantic Standard Time)',
	'America/Montserrat' => '(GMT-4:00) America/Montserrat (Atlantic Standard Time)',
	'America/Port_of_Spain' => '(GMT-4:00) America/Port_of_Spain (Atlantic Standard Time)',
	'America/Porto_Acre' => '(GMT-4:00) America/Porto_Acre (Amazon Time)',
	'America/Porto_Velho' => '(GMT-4:00) America/Porto_Velho (Amazon Time)',
	'America/Puerto_Rico' => '(GMT-4:00) America/Puerto_Rico (Atlantic Standard Time)',
	'America/Rio_Branco' => '(GMT-4:00) America/Rio_Branco (Amazon Time)',
	'America/Santiago' => '(GMT-4:00) America/Santiago (Chile Time)',
	'America/Santo_Domingo' => '(GMT-4:00) America/Santo_Domingo (Atlantic Standard Time)',
	'America/St_Barthelemy' => '(GMT-4:00) America/St_Barthelemy (Atlantic Standard Time)',
	'America/St_Kitts' => '(GMT-4:00) America/St_Kitts (Atlantic Standard Time)',
	'America/St_Lucia' => '(GMT-4:00) America/St_Lucia (Atlantic Standard Time)',
	'America/St_Thomas' => '(GMT-4:00) America/St_Thomas (Atlantic Standard Time)',
	'America/St_Vincent' => '(GMT-4:00) America/St_Vincent (Atlantic Standard Time)',
	'America/Thule' => '(GMT-4:00) America/Thule (Atlantic Standard Time)',
	'America/Tortola' => '(GMT-4:00) America/Tortola (Atlantic Standard Time)',
	'America/Virgin' => '(GMT-4:00) America/Virgin (Atlantic Standard Time)',
	'Antarctica/Palmer' => '(GMT-4:00) Antarctica/Palmer (Chile Time)',
	'Atlantic/Bermuda' => '(GMT-4:00) Atlantic/Bermuda (Atlantic Standard Time)',
	'Atlantic/Stanley' => '(GMT-4:00) Atlantic/Stanley (Falkland Is. Time)',
	'Brazil/Acre' => '(GMT-4:00) Brazil/Acre (Amazon Time)',
	'Brazil/West' => '(GMT-4:00) Brazil/West (Amazon Time)',
	'Canada/Atlantic' => '(GMT-4:00) Canada/Atlantic (Atlantic Standard Time)',
	'Chile/Continental' => '(GMT-4:00) Chile/Continental (Chile Time)',
	'America/St_Johns' => '(GMT-3:-30) America/St_Johns (Newfoundland Standard Time)',
	'Canada/Newfoundland' => '(GMT-3:-30) Canada/Newfoundland (Newfoundland Standard Time)',
	'America/Araguaina' => '(GMT-3:00) America/Araguaina (Brasilia Time)',
	'America/Bahia' => '(GMT-3:00) America/Bahia (Brasilia Time)',
	'America/Belem' => '(GMT-3:00) America/Belem (Brasilia Time)',
	'America/Buenos_Aires' => '(GMT-3:00) America/Buenos_Aires (Argentine Time)',
	'America/Catamarca' => '(GMT-3:00) America/Catamarca (Argentine Time)',
	'America/Cayenne' => '(GMT-3:00) America/Cayenne (French Guiana Time)',
	'America/Cordoba' => '(GMT-3:00) America/Cordoba (Argentine Time)',
	'America/Fortaleza' => '(GMT-3:00) America/Fortaleza (Brasilia Time)',
	'America/Godthab' => '(GMT-3:00) America/Godthab (Western Greenland Time)',
	'America/Jujuy' => '(GMT-3:00) America/Jujuy (Argentine Time)',
	'America/Maceio' => '(GMT-3:00) America/Maceio (Brasilia Time)',
	'America/Mendoza' => '(GMT-3:00) America/Mendoza (Argentine Time)',
	'America/Miquelon' => '(GMT-3:00) America/Miquelon (Pierre & Miquelon Standard Time)',
	'America/Montevideo' => '(GMT-3:00) America/Montevideo (Uruguay Time)',
	'America/Paramaribo' => '(GMT-3:00) America/Paramaribo (Suriname Time)',
	'America/Recife' => '(GMT-3:00) America/Recife (Brasilia Time)',
	'America/Rosario' => '(GMT-3:00) America/Rosario (Argentine Time)',
	'America/Santarem' => '(GMT-3:00) America/Santarem (Brasilia Time)',
	'America/Sao_Paulo' => '(GMT-3:00) America/Sao_Paulo (Brasilia Time)',
	'Antarctica/Rothera' => '(GMT-3:00) Antarctica/Rothera (Rothera Time)',
	'Brazil/East' => '(GMT-3:00) Brazil/East (Brasilia Time)',
	'America/Noronha' => '(GMT-2:00) America/Noronha (Fernando de Noronha Time)',
	'Atlantic/South_Georgia' => '(GMT-2:00) Atlantic/South_Georgia (South Georgia Standard Time)',
	'Brazil/DeNoronha' => '(GMT-2:00) Brazil/DeNoronha (Fernando de Noronha Time)',
	'America/Scoresbysund' => '(GMT-1:00) America/Scoresbysund (Eastern Greenland Time)',
	'Atlantic/Azores' => '(GMT-1:00) Atlantic/Azores (Azores Time)',
	'Atlantic/Cape_Verde' => '(GMT-1:00) Atlantic/Cape_Verde (Cape Verde Time)',
	'Africa/Abidjan' => '(GMT+0:00) Africa/Abidjan (Greenwich Mean Time)',
	'Africa/Accra' => '(GMT+0:00) Africa/Accra (Ghana Mean Time)',
	'Africa/Bamako' => '(GMT+0:00) Africa/Bamako (Greenwich Mean Time)',
	'Africa/Banjul' => '(GMT+0:00) Africa/Banjul (Greenwich Mean Time)',
	'Africa/Bissau' => '(GMT+0:00) Africa/Bissau (Greenwich Mean Time)',
	'Africa/Casablanca' => '(GMT+0:00) Africa/Casablanca (Western European Time)',
	'Africa/Conakry' => '(GMT+0:00) Africa/Conakry (Greenwich Mean Time)',
	'Africa/Dakar' => '(GMT+0:00) Africa/Dakar (Greenwich Mean Time)',
	'Africa/El_Aaiun' => '(GMT+0:00) Africa/El_Aaiun (Western European Time)',
	'Africa/Freetown' => '(GMT+0:00) Africa/Freetown (Greenwich Mean Time)',
	'Africa/Lome' => '(GMT+0:00) Africa/Lome (Greenwich Mean Time)',
	'Africa/Monrovia' => '(GMT+0:00) Africa/Monrovia (Greenwich Mean Time)',
	'Africa/Nouakchott' => '(GMT+0:00) Africa/Nouakchott (Greenwich Mean Time)',
	'Africa/Ouagadougou' => '(GMT+0:00) Africa/Ouagadougou (Greenwich Mean Time)',
	'Africa/Sao_Tome' => '(GMT+0:00) Africa/Sao_Tome (Greenwich Mean Time)',
	'Africa/Timbuktu' => '(GMT+0:00) Africa/Timbuktu (Greenwich Mean Time)',
	'America/Danmarkshavn' => '(GMT+0:00) America/Danmarkshavn (Greenwich Mean Time)',
	'Atlantic/Canary' => '(GMT+0:00) Atlantic/Canary (Western European Time)',
	'Atlantic/Faeroe' => '(GMT+0:00) Atlantic/Faeroe (Western European Time)',
	'Atlantic/Faroe' => '(GMT+0:00) Atlantic/Faroe (Western European Time)',
	'Atlantic/Madeira' => '(GMT+0:00) Atlantic/Madeira (Western European Time)',
	'Atlantic/Reykjavik' => '(GMT+0:00) Atlantic/Reykjavik (Greenwich Mean Time)',
	'Atlantic/St_Helena' => '(GMT+0:00) Atlantic/St_Helena (Greenwich Mean Time)',
	'Europe/Belfast' => '(GMT+0:00) Europe/Belfast (Greenwich Mean Time)',
	'Europe/Dublin' => '(GMT+0:00) Europe/Dublin (Greenwich Mean Time)',
	'Europe/Guernsey' => '(GMT+0:00) Europe/Guernsey (Greenwich Mean Time)',
	'Europe/Isle_of_Man' => '(GMT+0:00) Europe/Isle_of_Man (Greenwich Mean Time)',
	'Europe/Jersey' => '(GMT+0:00) Europe/Jersey (Greenwich Mean Time)',
	'Europe/Lisbon' => '(GMT+0:00) Europe/Lisbon (Western European Time)',
	'Europe/London' => '(GMT+0:00) Europe/London (Greenwich Mean Time)',
	'Africa/Algiers' => '(GMT+1:00) Africa/Algiers (Central European Time)',
	'Africa/Bangui' => '(GMT+1:00) Africa/Bangui (Western African Time)',
	'Africa/Brazzaville' => '(GMT+1:00) Africa/Brazzaville (Western African Time)',
	'Africa/Ceuta' => '(GMT+1:00) Africa/Ceuta (Central European Time)',
	'Africa/Douala' => '(GMT+1:00) Africa/Douala (Western African Time)',
	'Africa/Kinshasa' => '(GMT+1:00) Africa/Kinshasa (Western African Time)',
	'Africa/Lagos' => '(GMT+1:00) Africa/Lagos (Western African Time)',
	'Africa/Libreville' => '(GMT+1:00) Africa/Libreville (Western African Time)',
	'Africa/Luanda' => '(GMT+1:00) Africa/Luanda (Western African Time)',
	'Africa/Malabo' => '(GMT+1:00) Africa/Malabo (Western African Time)',
	'Africa/Ndjamena' => '(GMT+1:00) Africa/Ndjamena (Western African Time)',
	'Africa/Niamey' => '(GMT+1:00) Africa/Niamey (Western African Time)',
	'Africa/Porto-Novo' => '(GMT+1:00) Africa/Porto-Novo (Western African Time)',
	'Africa/Tunis' => '(GMT+1:00) Africa/Tunis (Central European Time)',
	'Africa/Windhoek' => '(GMT+1:00) Africa/Windhoek (Western African Time)',
	'Arctic/Longyearbyen' => '(GMT+1:00) Arctic/Longyearbyen (Central European Time)',
	'Atlantic/Jan_Mayen' => '(GMT+1:00) Atlantic/Jan_Mayen (Central European Time)',
	'Europe/Amsterdam' => '(GMT+1:00) Europe/Amsterdam (Central European Time)',
	'Europe/Andorra' => '(GMT+1:00) Europe/Andorra (Central European Time)',
	'Europe/Belgrade' => '(GMT+1:00) Europe/Belgrade (Central European Time)',
	'Europe/Berlin' => '(GMT+1:00) Europe/Berlin (Central European Time)',
	'Europe/Bratislava' => '(GMT+1:00) Europe/Bratislava (Central European Time)',
	'Europe/Brussels' => '(GMT+1:00) Europe/Brussels (Central European Time)',
	'Europe/Budapest' => '(GMT+1:00) Europe/Budapest (Central European Time)',
	'Europe/Copenhagen' => '(GMT+1:00) Europe/Copenhagen (Central European Time)',
	'Europe/Gibraltar' => '(GMT+1:00) Europe/Gibraltar (Central European Time)',
	'Europe/Ljubljana' => '(GMT+1:00) Europe/Ljubljana (Central European Time)',
	'Europe/Luxembourg' => '(GMT+1:00) Europe/Luxembourg (Central European Time)',
	'Europe/Madrid' => '(GMT+1:00) Europe/Madrid (Central European Time)',
	'Europe/Malta' => '(GMT+1:00) Europe/Malta (Central European Time)',
	'Europe/Monaco' => '(GMT+1:00) Europe/Monaco (Central European Time)',
	'Europe/Oslo' => '(GMT+1:00) Europe/Oslo (Central European Time)',
	'Europe/Paris' => '(GMT+1:00) Europe/Paris (Central European Time)',
	'Europe/Podgorica' => '(GMT+1:00) Europe/Podgorica (Central European Time)',
	'Europe/Prague' => '(GMT+1:00) Europe/Prague (Central European Time)',
	'Europe/Rome' => '(GMT+1:00) Europe/Rome (Central European Time)',
	'Europe/San_Marino' => '(GMT+1:00) Europe/San_Marino (Central European Time)',
	'Europe/Sarajevo' => '(GMT+1:00) Europe/Sarajevo (Central European Time)',
	'Europe/Skopje' => '(GMT+1:00) Europe/Skopje (Central European Time)',
	'Europe/Stockholm' => '(GMT+1:00) Europe/Stockholm (Central European Time)',
	'Europe/Tirane' => '(GMT+1:00) Europe/Tirane (Central European Time)',
	'Europe/Vaduz' => '(GMT+1:00) Europe/Vaduz (Central European Time)',
	'Europe/Vatican' => '(GMT+1:00) Europe/Vatican (Central European Time)',
	'Europe/Vienna' => '(GMT+1:00) Europe/Vienna (Central European Time)',
	'Europe/Warsaw' => '(GMT+1:00) Europe/Warsaw (Central European Time)',
	'Europe/Zagreb' => '(GMT+1:00) Europe/Zagreb (Central European Time)',
	'Europe/Zurich' => '(GMT+1:00) Europe/Zurich (Central European Time)',
	'Africa/Blantyre' => '(GMT+2:00) Africa/Blantyre (Central African Time)',
	'Africa/Bujumbura' => '(GMT+2:00) Africa/Bujumbura (Central African Time)',
	'Africa/Cairo' => '(GMT+2:00) Africa/Cairo (Eastern European Time)',
	'Africa/Gaborone' => '(GMT+2:00) Africa/Gaborone (Central African Time)',
	'Africa/Harare' => '(GMT+2:00) Africa/Harare (Central African Time)',
	'Africa/Johannesburg' => '(GMT+2:00) Africa/Johannesburg (South Africa Standard Time)',
	'Africa/Kigali' => '(GMT+2:00) Africa/Kigali (Central African Time)',
	'Africa/Lubumbashi' => '(GMT+2:00) Africa/Lubumbashi (Central African Time)',
	'Africa/Lusaka' => '(GMT+2:00) Africa/Lusaka (Central African Time)',
	'Africa/Maputo' => '(GMT+2:00) Africa/Maputo (Central African Time)',
	'Africa/Maseru' => '(GMT+2:00) Africa/Maseru (South Africa Standard Time)',
	'Africa/Mbabane' => '(GMT+2:00) Africa/Mbabane (South Africa Standard Time)',
	'Africa/Tripoli' => '(GMT+2:00) Africa/Tripoli (Eastern European Time)',
	'Asia/Amman' => '(GMT+2:00) Asia/Amman (Eastern European Time)',
	'Asia/Beirut' => '(GMT+2:00) Asia/Beirut (Eastern European Time)',
	'Asia/Damascus' => '(GMT+2:00) Asia/Damascus (Eastern European Time)',
	'Asia/Gaza' => '(GMT+2:00) Asia/Gaza (Eastern European Time)',
	'Asia/Istanbul' => '(GMT+2:00) Asia/Istanbul (Eastern European Time)',
	'Asia/Jerusalem' => '(GMT+2:00) Asia/Jerusalem (Israel Standard Time)',
	'Asia/Nicosia' => '(GMT+2:00) Asia/Nicosia (Eastern European Time)',
	'Asia/Tel_Aviv' => '(GMT+2:00) Asia/Tel_Aviv (Israel Standard Time)',
	'Europe/Athens' => '(GMT+2:00) Europe/Athens (Eastern European Time)',
	'Europe/Bucharest' => '(GMT+2:00) Europe/Bucharest (Eastern European Time)',
	'Europe/Chisinau' => '(GMT+2:00) Europe/Chisinau (Eastern European Time)',
	'Europe/Helsinki' => '(GMT+2:00) Europe/Helsinki (Eastern European Time)',
	'Europe/Istanbul' => '(GMT+2:00) Europe/Istanbul (Eastern European Time)',
	'Europe/Kaliningrad' => '(GMT+2:00) Europe/Kaliningrad (Eastern European Time)',
	'Europe/Kiev' => '(GMT+2:00) Europe/Kiev (Eastern European Time)',
	'Europe/Mariehamn' => '(GMT+2:00) Europe/Mariehamn (Eastern European Time)',
	'Europe/Minsk' => '(GMT+2:00) Europe/Minsk (Eastern European Time)',
	'Europe/Nicosia' => '(GMT+2:00) Europe/Nicosia (Eastern European Time)',
	'Europe/Riga' => '(GMT+2:00) Europe/Riga (Eastern European Time)',
	'Europe/Simferopol' => '(GMT+2:00) Europe/Simferopol (Eastern European Time)',
	'Europe/Sofia' => '(GMT+2:00) Europe/Sofia (Eastern European Time)',
	'Europe/Tallinn' => '(GMT+2:00) Europe/Tallinn (Eastern European Time)',
	'Europe/Tiraspol' => '(GMT+2:00) Europe/Tiraspol (Eastern European Time)',
	'Europe/Uzhgorod' => '(GMT+2:00) Europe/Uzhgorod (Eastern European Time)',
	'Europe/Vilnius' => '(GMT+2:00) Europe/Vilnius (Eastern European Time)',
	'Europe/Zaporozhye' => '(GMT+2:00) Europe/Zaporozhye (Eastern European Time)',
	'Africa/Addis_Ababa' => '(GMT+3:00) Africa/Addis_Ababa (Eastern African Time)',
	'Africa/Asmara' => '(GMT+3:00) Africa/Asmara (Eastern African Time)',
	'Africa/Asmera' => '(GMT+3:00) Africa/Asmera (Eastern African Time)',
	'Africa/Dar_es_Salaam' => '(GMT+3:00) Africa/Dar_es_Salaam (Eastern African Time)',
	'Africa/Djibouti' => '(GMT+3:00) Africa/Djibouti (Eastern African Time)',
	'Africa/Kampala' => '(GMT+3:00) Africa/Kampala (Eastern African Time)',
	'Africa/Khartoum' => '(GMT+3:00) Africa/Khartoum (Eastern African Time)',
	'Africa/Mogadishu' => '(GMT+3:00) Africa/Mogadishu (Eastern African Time)',
	'Africa/Nairobi' => '(GMT+3:00) Africa/Nairobi (Eastern African Time)',
	'Antarctica/Syowa' => '(GMT+3:00) Antarctica/Syowa (Syowa Time)',
	'Asia/Aden' => '(GMT+3:00) Asia/Aden (Arabia Standard Time)',
	'Asia/Baghdad' => '(GMT+3:00) Asia/Baghdad (Arabia Standard Time)',
	'Asia/Bahrain' => '(GMT+3:00) Asia/Bahrain (Arabia Standard Time)',
	'Asia/Kuwait' => '(GMT+3:00) Asia/Kuwait (Arabia Standard Time)',
	'Asia/Qatar' => '(GMT+3:00) Asia/Qatar (Arabia Standard Time)',
	'Europe/Moscow' => '(GMT+3:00) Europe/Moscow (Moscow Standard Time)',
	'Europe/Volgograd' => '(GMT+3:00) Europe/Volgograd (Volgograd Time)',
	'Indian/Antananarivo' => '(GMT+3:00) Indian/Antananarivo (Eastern African Time)',
	'Indian/Comoro' => '(GMT+3:00) Indian/Comoro (Eastern African Time)',
	'Indian/Mayotte' => '(GMT+3:00) Indian/Mayotte (Eastern African Time)',
	'Asia/Tehran' => '(GMT+3:30) Asia/Tehran (Iran Standard Time)',
	'Asia/Baku' => '(GMT+4:00) Asia/Baku (Azerbaijan Time)',
	'Asia/Dubai' => '(GMT+4:00) Asia/Dubai (Gulf Standard Time)',
	'Asia/Muscat' => '(GMT+4:00) Asia/Muscat (Gulf Standard Time)',
	'Asia/Tbilisi' => '(GMT+4:00) Asia/Tbilisi (Georgia Time)',
	'Asia/Yerevan' => '(GMT+4:00) Asia/Yerevan (Armenia Time)',
	'Europe/Samara' => '(GMT+4:00) Europe/Samara (Samara Time)',
	'Indian/Mahe' => '(GMT+4:00) Indian/Mahe (Seychelles Time)',
	'Indian/Mauritius' => '(GMT+4:00) Indian/Mauritius (Mauritius Time)',
	'Indian/Reunion' => '(GMT+4:00) Indian/Reunion (Reunion Time)',
	'Asia/Kabul' => '(GMT+4:30) Asia/Kabul (Afghanistan Time)',
	'Asia/Aqtau' => '(GMT+5:00) Asia/Aqtau (Aqtau Time)',
	'Asia/Aqtobe' => '(GMT+5:00) Asia/Aqtobe (Aqtobe Time)',
	'Asia/Ashgabat' => '(GMT+5:00) Asia/Ashgabat (Turkmenistan Time)',
	'Asia/Ashkhabad' => '(GMT+5:00) Asia/Ashkhabad (Turkmenistan Time)',
	'Asia/Dushanbe' => '(GMT+5:00) Asia/Dushanbe (Tajikistan Time)',
	'Asia/Karachi' => '(GMT+5:00) Asia/Karachi (Pakistan Time)',
	'Asia/Oral' => '(GMT+5:00) Asia/Oral (Oral Time)',
	'Asia/Samarkand' => '(GMT+5:00) Asia/Samarkand (Uzbekistan Time)',
	'Asia/Tashkent' => '(GMT+5:00) Asia/Tashkent (Uzbekistan Time)',
	'Asia/Yekaterinburg' => '(GMT+5:00) Asia/Yekaterinburg (Yekaterinburg Time)',
	'Indian/Kerguelen' => '(GMT+5:00) Indian/Kerguelen (French Southern & Antarctic Lands Time)',
	'Indian/Maldives' => '(GMT+5:00) Indian/Maldives (Maldives Time)',
	'Asia/Calcutta' => '(GMT+5:30) Asia/Calcutta (India Standard Time)',
	'Asia/Colombo' => '(GMT+5:30) Asia/Colombo (India Standard Time)',
	'Asia/Kolkata' => '(GMT+5:30) Asia/Kolkata (India Standard Time)',
	'Asia/Katmandu' => '(GMT+5:45) Asia/Katmandu (Nepal Time)',
	'Antarctica/Mawson' => '(GMT+6:00) Antarctica/Mawson (Mawson Time)',
	'Antarctica/Vostok' => '(GMT+6:00) Antarctica/Vostok (Vostok Time)',
	'Asia/Almaty' => '(GMT+6:00) Asia/Almaty (Alma-Ata Time)',
	'Asia/Bishkek' => '(GMT+6:00) Asia/Bishkek (Kirgizstan Time)',
	'Asia/Dacca' => '(GMT+6:00) Asia/Dacca (Bangladesh Time)',
	'Asia/Dhaka' => '(GMT+6:00) Asia/Dhaka (Bangladesh Time)',
	'Asia/Novosibirsk' => '(GMT+6:00) Asia/Novosibirsk (Novosibirsk Time)',
	'Asia/Omsk' => '(GMT+6:00) Asia/Omsk (Omsk Time)',
	'Asia/Qyzylorda' => '(GMT+6:00) Asia/Qyzylorda (Qyzylorda Time)',
	'Asia/Thimbu' => '(GMT+6:00) Asia/Thimbu (Bhutan Time)',
	'Asia/Thimphu' => '(GMT+6:00) Asia/Thimphu (Bhutan Time)',
	'Indian/Chagos' => '(GMT+6:00) Indian/Chagos (Indian Ocean Territory Time)',
	'Asia/Rangoon' => '(GMT+6:30) Asia/Rangoon (Myanmar Time)',
	'Indian/Cocos' => '(GMT+6:30) Indian/Cocos (Cocos Islands Time)',
	'Antarctica/Davis' => '(GMT+7:00) Antarctica/Davis (Davis Time)',
	'Asia/Bangkok' => '(GMT+7:00) Asia/Bangkok (Indochina Time)',
	'Asia/Ho_Chi_Minh' => '(GMT+7:00) Asia/Ho_Chi_Minh (Indochina Time)',
	'Asia/Hovd' => '(GMT+7:00) Asia/Hovd (Hovd Time)',
	'Asia/Jakarta' => '(GMT+7:00) Asia/Jakarta (West Indonesia Time)',
	'Asia/Krasnoyarsk' => '(GMT+7:00) Asia/Krasnoyarsk (Krasnoyarsk Time)',
	'Asia/Phnom_Penh' => '(GMT+7:00) Asia/Phnom_Penh (Indochina Time)',
	'Asia/Pontianak' => '(GMT+7:00) Asia/Pontianak (West Indonesia Time)',
	'Asia/Saigon' => '(GMT+7:00) Asia/Saigon (Indochina Time)',
	'Asia/Vientiane' => '(GMT+7:00) Asia/Vientiane (Indochina Time)',
	'Indian/Christmas' => '(GMT+7:00) Indian/Christmas (Christmas Island Time)',
	'Antarctica/Casey' => '(GMT+8:00) Antarctica/Casey (Western Standard Time (Australia))',
	'Asia/Brunei' => '(GMT+8:00) Asia/Brunei (Brunei Time)',
	'Asia/Choibalsan' => '(GMT+8:00) Asia/Choibalsan (Choibalsan Time)',
	'Asia/Chongqing' => '(GMT+8:00) Asia/Chongqing (China Standard Time)',
	'Asia/Chungking' => '(GMT+8:00) Asia/Chungking (China Standard Time)',
	'Asia/Harbin' => '(GMT+8:00) Asia/Harbin (China Standard Time)',
	'Asia/Hong_Kong' => '(GMT+8:00) Asia/Hong_Kong (Hong Kong Time)',
	'Asia/Irkutsk' => '(GMT+8:00) Asia/Irkutsk (Irkutsk Time)',
	'Asia/Kashgar' => '(GMT+8:00) Asia/Kashgar (China Standard Time)',
	'Asia/Kuala_Lumpur' => '(GMT+8:00) Asia/Kuala_Lumpur (Malaysia Time)',
	'Asia/Kuching' => '(GMT+8:00) Asia/Kuching (Malaysia Time)',
	'Asia/Macao' => '(GMT+8:00) Asia/Macao (China Standard Time)',
	'Asia/Macau' => '(GMT+8:00) Asia/Macau (China Standard Time)',
	'Asia/Makassar' => '(GMT+8:00) Asia/Makassar (Central Indonesia Time)',
	'Asia/Manila' => '(GMT+8:00) Asia/Manila (Philippines Time)',
	'Asia/Shanghai' => '(GMT+8:00) Asia/Shanghai (China Standard Time)',
	'Asia/Singapore' => '(GMT+8:00) Asia/Singapore (Singapore Time)',
	'Asia/Taipei' => '(GMT+8:00) Asia/Taipei (China Standard Time)',
	'Asia/Ujung_Pandang' => '(GMT+8:00) Asia/Ujung_Pandang (Central Indonesia Time)',
	'Asia/Ulaanbaatar' => '(GMT+8:00) Asia/Ulaanbaatar (Ulaanbaatar Time)',
	'Asia/Ulan_Bator' => '(GMT+8:00) Asia/Ulan_Bator (Ulaanbaatar Time)',
	'Asia/Urumqi' => '(GMT+8:00) Asia/Urumqi (China Standard Time)',
	'Australia/Perth' => '(GMT+8:00) Australia/Perth (Western Standard Time (Australia))',
	'Australia/West' => '(GMT+8:00) Australia/West (Western Standard Time (Australia))',
	'Australia/Eucla' => '(GMT+8:45) Australia/Eucla (Central Western Standard Time (Australia))',
	'Asia/Dili' => '(GMT+9:00) Asia/Dili (Timor-Leste Time)',
	'Asia/Jayapura' => '(GMT+9:00) Asia/Jayapura (East Indonesia Time)',
	'Asia/Pyongyang' => '(GMT+9:00) Asia/Pyongyang (Korea Standard Time)',
	'Asia/Seoul' => '(GMT+9:00) Asia/Seoul (Korea Standard Time)',
	'Asia/Tokyo' => '(GMT+9:00) Asia/Tokyo (Japan Standard Time)',
	'Asia/Yakutsk' => '(GMT+9:00) Asia/Yakutsk (Yakutsk Time)',
	'Australia/Adelaide' => '(GMT+9:30) Australia/Adelaide (Central Standard Time (South Australia))',
	'Australia/Broken_Hill' => '(GMT+9:30) Australia/Broken_Hill (Central Standard Time (South Australia/New South Wales))',
	'Australia/Darwin' => '(GMT+9:30) Australia/Darwin (Central Standard Time (Northern Territory))',
	'Australia/North' => '(GMT+9:30) Australia/North (Central Standard Time (Northern Territory))',
	'Australia/South' => '(GMT+9:30) Australia/South (Central Standard Time (South Australia))',
	'Australia/Yancowinna' => '(GMT+9:30) Australia/Yancowinna (Central Standard Time (South Australia/New South Wales))',
	'Antarctica/DumontDUrville' => '(GMT+10:00) Antarctica/DumontDUrville (Dumont-d\'Urville Time)',
	'Asia/Sakhalin' => '(GMT+10:00) Asia/Sakhalin (Sakhalin Time)',
	'Asia/Vladivostok' => '(GMT+10:00) Asia/Vladivostok (Vladivostok Time)',
	'Australia/ACT' => '(GMT+10:00) Australia/ACT (Eastern Standard Time (New South Wales))',
	'Australia/Brisbane' => '(GMT+10:00) Australia/Brisbane (Eastern Standard Time (Queensland))',
	'Australia/Canberra' => '(GMT+10:00) Australia/Canberra (Eastern Standard Time (New South Wales))',
	'Australia/Currie' => '(GMT+10:00) Australia/Currie (Eastern Standard Time (New South Wales))',
	'Australia/Hobart' => '(GMT+10:00) Australia/Hobart (Eastern Standard Time (Tasmania))',
	'Australia/Lindeman' => '(GMT+10:00) Australia/Lindeman (Eastern Standard Time (Queensland))',
	'Australia/Melbourne' => '(GMT+10:00) Australia/Melbourne (Eastern Standard Time (Victoria))',
	'Australia/NSW' => '(GMT+10:00) Australia/NSW (Eastern Standard Time (New South Wales))',
	'Australia/Queensland' => '(GMT+10:00) Australia/Queensland (Eastern Standard Time (Queensland))',
	'Australia/Sydney' => '(GMT+10:00) Australia/Sydney (Eastern Standard Time (New South Wales))',
	'Australia/Tasmania' => '(GMT+10:00) Australia/Tasmania (Eastern Standard Time (Tasmania))',
	'Australia/Victoria' => '(GMT+10:00) Australia/Victoria (Eastern Standard Time (Victoria))',
	'Australia/LHI' => '(GMT+10:30) Australia/LHI (Lord Howe Standard Time)',
	'Australia/Lord_Howe' => '(GMT+10:30) Australia/Lord_Howe (Lord Howe Standard Time)',
	'Asia/Magadan' => '(GMT+11:00) Asia/Magadan (Magadan Time)',
	'Antarctica/McMurdo' => '(GMT+12:00) Antarctica/McMurdo (New Zealand Standard Time)',
	'Antarctica/South_Pole' => '(GMT+12:00) Antarctica/South_Pole (New Zealand Standard Time)',
	'Asia/Anadyr' => '(GMT+12:00) Asia/Anadyr (Anadyr Time)',
	'Asia/Kamchatka' => '(GMT+12:00) Asia/Kamchatka (Petropavlovsk-Kamchatski Time)'
);

//echo getFormRowTextInput('timezone', 'Timezone Setting', 'Timezone Setting', 'Set your own timezone here.<br/>Possible values are listed on:<br/><a href="http://php.net/manual/en/timezones.php">http://php.net/manual/en/timezones.php</a>', $json['timezone'], '', 255, false, false, false);

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo '<div class="position-relative form-group">'.K_NEWLINE;
echo '<label for="timezone">Timezone</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="timezone" id="timezone">'.K_NEWLINE;

foreach($timezones as $key => $value){
	echo '<option value="'.$key.'" ';
	if($key===$json['timezone']){
		echo ' selected="selected"';
	}
	echo '>'.$value.'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

$language = array(
    'ar' => 'Arabian',
    'az' => 'Azerbaijani',
    'bg' => 'Bulgarian',
    'br' => 'Brazilian Portuguese',
    'cn' => 'Chinese',
    'de' => 'German',
    'el' => 'Greek',
    'en' => 'English',
    'es' => 'Spanish',
    'fa' => 'Farsi',
    'fr' => 'French',
    'he' => 'Hebrew',
    'hi' => 'Hindi',
    'hu' => 'Hungarian',
    'id' => 'Indonesian',
    'it' => 'Italian',
    'jp' => 'Japanese',
    'mr' => 'Marathi',
    'ms' => 'Malay (Bahasa Melayu)',
    'nl' => 'Dutch',
    'pl' => 'Polish',
    'ro' => 'Romanian',
    'ru' => 'Russian',
    'tr' => 'Turkish',
    'ur' => 'Urdu',
    'vn' => 'Vietnamese'
);

echo '<div class="col-md-6">'.K_NEWLINE;
echo '<label for="defLang">Default Language</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="defLang" id="defLang" size="0">'.K_NEWLINE;

foreach($language as $key => $value){
	echo '<option value="'.$key.'" ';
	if($key===$json['defLang']){
		echo ' selected="selected"';
	}
	echo '>'.$value.'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowCheckBox('enable_langsel', 'Enable Language Selector', 'If enable, show language selector on top right of the page<br/><i>default value: enable</i>', '<small>If enable, show language selector on top right of the page<br/><i>default value: enable</i></small>', 1, $json['enable_langsel'], false, '');
echo '</div>'.K_NEWLINE;
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowCheckBox('pubPageHelp', 'Public Page Help', 'If enable, display page help on the bottom of the page. default value: disable', '<small>If enable, display page help on the bottom of the page.<br/><i>default value: disable</i></small>', 1, $json['pubPageHelp'], false, '');
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowCheckBox('forgotPass', 'Show Forgot Password Link', 'If enable, show link to reset user password<br/><i>default value: enable</i>', '<small>If enable, show link to reset user password<br/><i>default value: enable</i></small>', 1, $json['forgotPass'], false, '');
echo '</div>'.K_NEWLINE;
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowCheckBox('userReg', 'Enable Self Registration', 'If enable, show self registration link<br/><i>default value: enable</i>', '<small>If enable, show self registration link<br/><i>default value: enable</i></small>', 1, $json['userReg'], false, '');
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowCheckBox('enableMultiLogin', 'Enable Multi Login', 'If disable, User level 1,2,3 are blocked when login twice or more on other device / browser. <br/><i>default value: disable</i>', '<small>If disable, User level 1,2,3 are blocked if login twice or more on other device / browser. <br/><i>default value: disable</i></small>', 1, $json['enableMultiLogin'], false, '');
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<hr/>'.K_NEWLINE;

echo getFormRowTextInput('logoutURL', 'Logout URL', 'Logout URL', '<div>URL to be redirected at logout.<br/>Can be relative or absolute URL.<br/>example:<ol class="mb-0"><li><a href="#">logout.html</a></li><li><a href="#">../../logout.html</a></li><li><a href="https://xamzonelinux.blogspot.com" target="blank">https://xamzonelinux.blogspot.com</a></li></ol>(leave empty for default)</div>', urldecode($json['logoutURL']), '', 255, false, false, false);

echo '<hr/>'.K_NEWLINE;
echo '<div class="mb-2">'.K_NEWLINE;
echo '<label for="defFont">Global Font</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="defFont" id="defFont" size="0">'.K_NEWLINE;
foreach(glob(K_PATH_MAIN.'fonts/external/*') as $filename){
	echo '<option value="'.basename($filename).'" ';
	if(basename($filename)===$json['defFont']){
		echo ' selected="selected"';
	}
	echo '>'.basename($filename).'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '<small>System Default font is less consistent across device, because each user may change default font. For consistent look you can choose non-system default provided here.<br/><br/>If you paste the text from Microsoft Word, it may contain non-websafe font like Symbol or Wingdings. This font may unreadable correctly if the test taker access the test from non-Microsoft platform, like Android. To solve this problem, please provide font Symbol or Wingdings, and put on <b>fonts</b> directory. The Symbol font must be renamed to: <b><u>symbol.ttf</u></b>, and the Wingdings font must be renamed to: <b><u>wingdings.ttf</u></b>.<br/><br/>Sorry, we are not provide this font because of licensing term.</small>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// $field_name, $name, $description = '', $value = '', $disabled = false, $prefix = ''

echo '<hr/>'.K_NEWLINE;
echo '<div class="mb-3">';
echo getFormRowTextBox('jsWarn', 'Javascript Warning if disabled (you can use HTML tag)', 'Javascript Warning', urldecode(stripcslashes($json['jsWarn'])), false, '');
echo '</div>';

echo '<div class="form-row mb-2">';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('clientUA', 'Client User Agent', 'Client User Agent', 'Leave empty to accept all client user agent', $json['clientUA'], '', 255, false, false, false, '', true);
echo '</div>';
echo '<div class="col-md-6">'.K_NEWLINE;
echo getFormRowTextInput('clientVer', 'Client Min. Ver', 'Client Min. Ver', 'Minimum version of client browser.<br/>eg: if you intended your client access the site from Chrome ver. 61 or higher, please type 60 in this form', $json['clientVer'], '', 255, false, false, false, '', true);
echo '</div>';
echo '</div>';

echo '<hr/>'.K_NEWLINE;
echo getFormRowTextBox('clientDisMsg', 'Message if client blocked (you can use HTML tag)', 'Message if client blocked (you can use HTML tag)', urldecode(stripcslashes($json['clientDisMsg'])), false, '');
echo '</fieldset>';




echo '<div class="border rounded m-3 position-relative p-3">';
echo '<span class="badge badge-primary position-absolute" style="top:-1em"><i class="metismenu-icon pe-7s-home"></i> Institution Data</span>';
echo getFormRowTextInput('institutionName', 'Institution Name', 'Institution Name', '', stripcslashes($json['institutionName']), '', 255, false, false, false);
echo getFormRowTextInput('addrLine1', 'Address Line 1', 'Address Line 1', '', $json['addrLine1'], '', 255, false, false, false);
echo getFormRowTextInput('addrLine2', 'Address Line 2', 'Address Line 2', '', $json['addrLine2'], '', 255, false, false, false);
echo getFormRowTextInput('addrLine3', 'Address Line 3', 'Address Line 3', '', $json['addrLine3'], '', 255, false, false, false);


echo '<div class="card border shadow-none">'.K_NEWLINE;
echo '<div class="card-header"><i class="pe-7s-photo"></i>&nbsp;Logo Image</div>'.K_NEWLINE;
echo '<div class="card-body p-2">'.K_NEWLINE;
echo '<div class="form-row">'.K_NEWLINE;

echo '<div class="col-md-6">'.K_NEWLINE;
echo '<div class="p-3 text-center ">'.K_NEWLINE;
echo '<label for="logoImg">Gambar Logo Saat ini</label>'.K_NEWLINE;
echo '<span class="formw" style="display:block">'.K_NEWLINE;
echo '<div id="selected-logo"></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="col-md-6">'.K_NEWLINE;
echo '<div class="ml-3 border rounded p-3 text-center ">'.K_NEWLINE;
echo '<div id="logo-selection-cont" class="brad-5 borderStd p-10 mt-1em bg-white">'.K_NEWLINE;
echo '<span class="btn btn-light btn-block" onclick="$(\'#logoImg\').imagepicker();$(\'#logoImg-cont\').slideToggle();addDelBtn()">Select Logo</span>'.K_NEWLINE;
echo '<div id="logoImg-cont" style="display:none"><select name="logoImg" id="logoImg" size="0" class="image-picker">'.K_NEWLINE;
foreach(glob(K_PATH_CACHE.'logo/*') as $filename){
	echo '<option data-img-src="../../cache/logo/'.basename($filename).'" value="'.basename($filename).'" ';
	if(basename($filename)===$json['logoImg']){
		echo ' selected="selected"';
	}
	echo '>'.basename($filename).'</option>'.K_NEWLINE;
}
echo '</select></div>'.K_NEWLINE;

echo TMF_modal_button('uploadLogo','Upload Logo','btn btn-block btn-alternate mt-3');
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;




echo '<div class="card mt-3 border rounded shadow-none">';
echo '<div class="card-header"><i class="pe-7s-target"></i>&nbsp;Global Test Settings</div>';
echo '<div class="card-body">';
echo getFormRowCheckBox('realtime_grading', 'Realtime Grading', 'If enabled, all answered question directly graded to database. If disabled, answered question have to be graded manually by clicking Regrade Button in Test -> Test result all users. If you want better performance you can try to disabled this option. <i>default value: enable</i>', 'If enabled, all answered question directly graded to database. If disabled, answered question have to be graded manually by clicking Regrade Button in Test -> Test result all users. If disabled, you must also disable "Answer all questions" below. If you want better performance you can try to disabled this option (reduce database activity while exam process is ongoing). <i>default value: enable</i>', 1, $json['realtime_grading'], false, '');
echo getFormRowCheckBox('answer_all_questions', 'Answer all questions', 'If enable all questions must be answered before stopping the test. <i>default value: enable</i>', 'If enable all questions must be answered before stopping the test. <i>default value: enable</i>', 1, $json['answer_all_questions'], false, '');
echo getFormRowCheckBox('show_terminate_when_all_answered', 'Show Terminate button only when all answered', 'If enable, show terminate button only when all question has been marked answered.<br/><i>default value: disable</i>', 'If enable, show terminate button only when all question has been marked answered.<br/><i>default value: disable</i>', 1, $json['show_terminate_when_all_answered'], false, '');

echo '<div class="my-2">';
echo getFormRowTextInput('allow_submit_after', 'Allow Terminate Test After n-persen Time', 'Allow Terminate Test After n-persen Time', 'Ijinkan peserta menghentikan ujian setelah durasi waktu berjalan sekian persen. Isikan dengan angka maksimal 100. Contoh: Jika durasi ujian 100 menit, dan pada kotak di atas Anda mengetikkan 90, maka peserta baru diijinkan menekan tombol hentikan setelah durasi ujian berjalan 90 menit atau lebih. Dengan kata lain peserta hanya diijinkan menghentikan ujian ketika waktu ujian tersisa 10 menit. Jika diisi dengan angka 0, maka peserta dapat menghentikan ujian kapan saja.', $json['allow_submit_after'], '', 255, false, false, false);
echo '</div>';

echo getFormRowCheckBox('show_save_button', 'Show Save Button', 'If enable, show save button below question navigation.<br/><i>default value: disable</i>', 'If enable, show save button below question navigation.<br/><i>default value: disable</i>', 1, $json['show_save_button'], false, '');
echo getFormRowCheckBox('display_test_desc', 'Test Description', 'If enable show test description before executing the test.<br/><i>default value: enable</i>', 'If enable show test description before executing the test.<br/><i>default value: enable</i>', 1, $json['display_test_desc'], false, '');
echo getFormRowCheckBox('hideExpTest', 'Hide Expired Test', 'If enable hide expired test.<br/><i>default value: disable</i>', 'If enable hide expired test.<br/><i>default value: disable</i>', 1, $json['hideExpTest'], false, '');
echo getFormRowCheckBox('PDFResult', 'PDF Result', 'If enable, user can export result test to PDF.<br/><i>default value: enable</i>', 'If enable, user can export result test to PDF.<br/><i>default value: enable</i>', 1, $json['PDFResult'], false, '');
echo getFormRowTextInput('endtest_page', 'Custom page after user stopping test', 'Custom page after user stopping test', 'leave empty to default', $json['endtest_page'], '', 255, false, false, false);

// echo getFormRowCheckBox('fileUpload', 'File Upload', 'If enable, add ability to upload specific file on text question type', 'If enable, add ability to upload specific file on text question type', 1, $json['fileUpload'], false, '');
echo '</div>';
echo '</div>';




echo '<div class="card border rounded mt-3 shadow-none">';
echo '<div class="card-header"><i class="pe-7s-camera"></i>&nbsp;Login Background</div>';
echo '<div class="card-body">';
echo getFormRowTextInput('loginBg', 'Login Background Image', 'Login Background Image', 'Can be path to image or image URL Address. Leave blank to disable.<br/>Example: https://source.unsplash.com/lI1z94nf0RM/1600x900<br/>or ../../images/background.png', $json['loginBg'], '', 255, false, false, false);

// echo getFormRowTextInput('loginBgPosition', 'Position', 'Position', '', $json['loginBgPosition'], '', 255, false, false, false);
echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo '<div class="mt-2">'.K_NEWLINE;
echo '<label for="loginBgPosition">Position</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="loginBgPosition" id="loginBgPosition" size="0">'.K_NEWLINE;
$loginBgPosition = array('bottom','center','left','right','top','revert','unset','inherit','initial');

foreach($loginBgPosition as $key => $value){
	echo '<option value="'.$value.'" ';
	if($value===$json['loginBgPosition']){
		echo ' selected="selected"';
	}
	echo '>'.$value.'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="col-md-4">';
echo '<div class="mt-2">'.K_NEWLINE;
echo '<label for="loginBgSize">Size</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="loginBgSize" id="loginBgSize" size="0">'.K_NEWLINE;
$loginBgSize = array('auto','contain','cover','inherit','initial','revert','unset');
foreach($loginBgSize as $key => $value){
	echo '<option value="'.$value.'" ';
	if($value===$json['loginBgSize']){
		echo ' selected="selected"';
	}
	echo '>'.$value.'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// echo getFormRowTextInput('loginBgBlend', 'Blending Mode', 'Blending Mode', '', $json['loginBgBlend'], '', 255, false, false, false);

echo '<div class="col-md-4">';
echo '<div class="mt-2">'.K_NEWLINE;
echo '<label for="loginBgBlend">Blend Mode</label>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="loginBgBlend" id="loginBgBlend" size="0">'.K_NEWLINE;
$blendMode = array('color','color-burn','color-dodge','darken','difference','exclusion','hard-light','hue','inherit','initial','lighten','luminosity','multiply','normal','overlay','revert','saturation','screen','soft-light','unset');

foreach($blendMode as $key => $value){
	echo '<option value="'.$value.'" ';
	if($value===$json['loginBgBlend']){
		echo ' selected="selected"';
	}
	echo '>'.$value.'</option>'.K_NEWLINE;
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;





echo '<div class="card border rounded shadow-none m-3">';
echo '<div class="card-header"><i class="pe-7s-gleam"></i>&nbsp;Performance</div>';
// SSGenJSON
echo '<div class="card-body">';
echo getFormRowCheckBox('SSGenJSON', 'Create JSON File on Server Side', 'If enable, server generate all question (testlogid) in JSON File on first question load. It also help other features below.<br/><i>default value: enable</i>', 'If enable, server generate all question (testlogid) in JSON File on first question load. It also help other features below.<br/><i>default value: disable</i>', 1, $json['SSGenJSON'], false, '');
echo getFormRowCheckBox('triggerCacheAllFromServer', 'Triggering Cache All From Server', 'Triggering load all cache after generating JSON File from server side<br/><i>default value: disable</i>', 'Triggering load all cache after generating JSON File from server side<br/><i>default value: disable</i>', 1, $json['triggerCacheAllFromServer'], false, '');
echo getFormRowCheckBox('jsonFile', 'Create JSON File', 'If enable, all displayed question will be stored in JSON File for faster loading in the next time. This JSON File triggered from client side when question has been displayed. If the JSON File was created before, then it will cache question block in client device on second visit if Cache Feature below enabled.<br/><i>default value: enable</i>', 'If enable, all displayed question will be stored in JSON File for faster loading in the next time. This JSON File triggered from client side when question has been displayed. If the JSON File was created before, then it will cache question block in client device on second visit if Cache Feature below enabled.<br/><i>default value: disable</i>', 1, $json['jsonFile'], false, '');
echo getFormRowCheckBox('createAllJsonFileOnStartup', 'Create JSON File on Startup (Cache All Question Block)', 'If enable, all question in current test will be stored in JSON File when first question load on client side. If JSON File was created before, then it will cache all question in client device if Cache Feature below enabled. WARNING! This feature will request all testlogid on first load question on client side through AJAX. It will increase client-server network usage.<br/><i>default value: enable</i>', 'If enable, all question in current test will be stored in JSON File when first question load on client side. If JSON File was created before, then it will cache all question in client device if Cache Feature below enabled. WARNING! This feature will request all testlogid on first load question on client side through AJAX. It will increase client-server network usage.<br/><i>default value: disable</i>', 1, $json['createAllJsonFileOnStartup'], false, '');
echo getFormRowCheckBox('cacheFeature', 'Cache Feature', 'If enable, browser will cache the question block, so user can navigate question in offline mode.<br/><i>default value: enable</i>', 'If enable, browser will cache the question block, so user can navigate question in offline mode. Cache Feature may use a lot of user\'s storage depend on the amount of questions size. To use this feature, make sure your site protocol is HTTPS and warn your user to spare diskspace if you enable this feature.<br/><i>default value: disable</i>', 1, $json['cacheFeature'], false, '');
echo getFormRowCheckBox('clearStorageOnLogin', 'Clear Local Storage on Login', 'If enable, local storage and cache storage will be cleared on login screen page.<br/><i>default value: enable</i>', 'If enable, local storage and cache storage will be cleared on login screen page.<br/><i>default value: enable</i>', 1, $json['clearStorageOnLogin'], false, '');
echo getFormRowCheckBox('enable_delay', 'Enable delay before starting test', 'If enable, add some random delay before executing new test.<br/><i>default value: enable</i>', 'If enable, add some random delay before executing new test.<br/><i>default value: enable</i>', 1, $json['enable_delay'], false, '');
echo '</div>';
echo '</div>';





echo '<div class="card border rounded shadow-none m-3">';
echo '<div class="card-header"><i class="pe-7s-comment"></i>&nbsp;Chat Feature (experimental)</div>';
echo '<div class="card-body">';
echo getFormRowCheckBox('chat_feature', 'Chat Feature', 'Chat Feature', '<i>default value: disable</i>', 1, $json['chat_feature'], false, '');
echo '</div>';
echo '</div>';

echo '<div class="px-3 pb-2">';
echo '<span class="mb-2 d-block text-center text-danger">Jika Anda mengubah pengaturan pada <b><i>Site Settings</i></b> di atas silakan tekan tombol Update ini</span>';
F_submit_button('update', $l['w_update'].'" style="width:100%', $l['h_update']);


echo '</div>';
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>';
echo '</div>';

echo '<form id="afterlogingreeting" class="d-none" action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">';
echo '<div class="card mb-3">';
echo '<div class="card-header justify-content-between px-3"><i class="pe-7s-speaker"></i>&nbsp;After Login Greeting <span onclick="this.parentNode.parentNode.parentNode.setAttribute(\'class\',\'d-none\');document.getElementById(\'settingmenu\').removeAttribute(\'style\')" class="text-danger"><i class="fa fa-times-circle"></i></span></div>';
echo '<div class="card-body">';
echo '<div class="mb-3">';
echo getFormRowCheckBox('enable_greeting', 'Enable Greeting', 'Enable Greeting', '<i>default value: disable</i>', 1, $jsonGreetings['enable_greeting'], false, '');
echo '</div>';
echo getFormRowTextInput('greetLine1', 'Greeting Line 1', 'Greeting Line 1', '', $jsonGreetings['greetLine1'], '', 255, false, false, false);
echo getFormRowTextInput('greetLine2', 'Greeting Line 2', 'Greeting Line 2', '', $jsonGreetings['greetLine2'], '', 255, false, false, false);

echo '</div>';
echo '<div class="px-3 pb-2">';
echo '<span class="mb-2 d-block text-center text-danger">Jika Anda mengubah pengaturan pada <b><i>After Login Greeting</i></b> di atas silakan tekan tombol Update ini</span>';
F_submit_button('update-greeting', $l['w_update'].'" style="width:100% ', $l['h_update']);
echo F_getCSRFTokenField().K_NEWLINE;
echo '</div>';
echo '</div>';
echo '</form>';





echo '<form id="loginboxadditionalmessage" class="d-none" action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">';
echo '<div class="card mb-3">';
echo '<div class="card-header justify-content-between px-3"><i class="pe-7s-lock"></i>&nbsp;Login Box Additional Message<span onclick="this.parentNode.parentNode.parentNode.setAttribute(\'class\',\'d-none\');document.getElementById(\'settingmenu\').removeAttribute(\'style\')" class="text-danger"><i class="fa fa-times-circle"></i></span></div>';
echo '<div class="card-body">';
echo getFormRowTextInput('ail_beforefield', 'Message before Login Field', 'Message before Login Field', 'Leave blank to disable', $lbam['ail_beforefield'], '', 255, false, false, false);
echo getFormRowTextInput('ail_afterfield', 'Message after Login Field', 'Message after Login Field', 'Leave blank to disable', $lbam['ail_afterfield'], '', 255, false, false, false);

echo '<div class="p-0">';
echo '<span class="mb-2 d-block text-center text-danger">Jika Anda mengubah pengaturan pada <b><i>Login Box Additional Message</i></b> di atas silakan tekan tombol Update ini</span>';
F_submit_button('update-addinfologin', $l['w_update'].'"  style="width:100%;margin:0!important', $l['h_update']);
echo '</div>';
echo F_getCSRFTokenField().K_NEWLINE;
echo '</div>';
echo '</div>';
echo '</form>';




echo '<form id="timerwarning" class="d-none" action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">';
echo '<div class="card mb-3">';
echo '<div class="card-header justify-content-between px-3"><i class="pe-7s-clock"></i>&nbsp;Timer Warning<span onclick="this.parentNode.parentNode.parentNode.setAttribute(\'class\',\'d-none\');document.getElementById(\'settingmenu\').removeAttribute(\'style\')" class="text-danger"><i class="fa fa-times-circle"></i></span></div>';
echo '<div class="card-body">';


echo '<div class="card shadow-none border mb-3">';
echo '<div class="card-header">First Warning</div>';
echo '<div class="card-body">';
echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend1_time', 'Show first warning on', 'Show first warning on', 'last minute', $tm['almostend1_time'], '', 255, false, false, false);
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend1_bg', 'First warning background color', 'First warning background color', 'Leave blank to disable', $tm['almostend1_bg'], '', 255, false, false, false);
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend1_col', 'First warning text color', 'First warning text color', 'Leave blank to disable', $tm['almostend1_col'], '', 255, false, false, false);
echo '</div>';
echo '</div>';
echo getFormRowTextInput('almostend1_msg', 'First warning message', 'First warning message', 'Leave blank to disable', $tm['almostend1_msg'], '', 255, false, false, false);
echo '</div>';
echo '</div>';


echo '<div class="card shadow-none border mb-3">';
echo '<div class="card-header">Second Warning</div>';
echo '<div class="card-body">';
echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend2_time', 'Show second warning on', 'Show second warning on', 'last minute', $tm['almostend2_time'], '', 255, false, false, false);
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend2_col', 'Second warning text color', 'Second warning text color', 'Leave blank to disable', $tm['almostend2_col'], '', 255, false, false, false);
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('almostend2_bg', 'Second warning background color', 'Second warning background color', 'Leave blank to disable', $tm['almostend2_bg'], '', 255, false, false, false);
echo '</div>';
echo '</div>';
echo getFormRowTextInput('almostend2_msg', 'Second warning message', 'Second warning message', 'Leave blank to disable', $tm['almostend2_msg'], '', 255, false, false, false);
echo '</div>';
echo '</div>';



echo '<div class="card shadow-none border mb-3">';
echo '<div class="card-header">Final Warning</div>';
echo '<div class="card-body">';
echo getFormRowTextInput('lastsec_msg', '10 last second message', '10 last second message', 'Leave blank to disable', $tm['lastsec_msg'], '', 255, false, false, false);
echo '<div class="form-row">';
echo '<div class="col-md-6">';
echo getFormRowTextInput('lastsec_bg', '10 last second background color', '10 last second background color', 'Leave blank to disable', $tm['lastsec_bg'], '', 255, false, false, false);
echo '</div>';
echo '<div class="col-md-6">';
echo getFormRowTextInput('lastsec_col', '10 last second text color', '10 last second text color', 'Leave blank to disable', $tm['lastsec_col'], '', 255, false, false, false);
// echo '</fieldset>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


echo '<div>';
echo '<div class="p-0">';
echo '<span class="mb-2 d-block text-center text-danger">Jika Anda mengubah pengaturan pada <b><i>Timer Warning</i></b> di atas silakan tekan tombol Update ini</span>';
F_submit_button('update-timerwarning', $l['w_update'].'" class="ft-black mb-10" style="width:100%;margin:0!important', $l['h_update']);
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>';







echo '<form id="customcolorschemeforpublic" class="d-none" action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">';
echo '<div class="card">';

echo '<div class="card-header justify-content-between px-3"><i class="pe-7s-paint"></i>&nbsp;Custom Color Scheme for Public<span onclick="this.parentNode.parentNode.parentNode.setAttribute(\'class\',\'d-none\');document.getElementById(\'settingmenu\').removeAttribute(\'style\')" class="text-danger"><i class="fa fa-times-circle"></i></span></div>';
echo '<div class="card-body">';
echo '<div class="mb-3">';
echo getFormRowCheckBox('enable_ccs', 'Enable', 'Enable', '<i>default value: disable</i>', 1, $cscheme['enable_ccs'], false, '');	
echo '</div>';

echo '<div class="form-row">';
echo '<div class="col-md-6">';
echo getFormRowTextInput('--header', 'Header Color', 'Header Color', '', $cscheme['--header'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-6">';
echo getFormRowTextInput('--link', 'Link Color', 'Link Color', '', $cscheme['--link'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';

echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-1', 'Color 1', 'Color 1', 'Primary Color', $cscheme['--col-1'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-2', 'Color 2', 'Color 2', '', $cscheme['--col-2'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-3', 'Color 3', 'Color 3', '', $cscheme['--col-3'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';

echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-4', 'Color 4', 'Color 4', '', $cscheme['--col-4'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-5', 'Color 5', 'Color 5', '', $cscheme['--col-5'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-5l', 'Color 5l', 'Color 5l', '', $cscheme['--col-5l'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';


echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-5a', 'Color 5a', 'Color 5a', '', $cscheme['--col-5a'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-6', 'Color 6', 'Color 6', '', $cscheme['--col-6'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-7', 'Color 7', 'Color 7', '', $cscheme['--col-7'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';


echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-8', 'Color 8', 'Color 8', '', $cscheme['--col-8'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-9', 'Color 9', 'Color 9', '', $cscheme['--col-9'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-10', 'Color 10', 'Color 10', '', $cscheme['--col-10'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';


echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-11', 'Color 11', 'Color 11', '', $cscheme['--col-11'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-12', 'Color 12', 'Color 12', '', $cscheme['--col-12'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-13', 'Color 13', 'Color 13', '', $cscheme['--col-13'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';

echo '<div class="form-row">';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-14', 'Color 14', 'Color 14', '', $cscheme['--col-14'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--col-15', 'Color 15', 'Color 15', '', $cscheme['--col-15'], '', 255, false, false, 'color');
echo '</div>';
echo '<div class="col-md-4">';
echo getFormRowTextInput('--bor-1', 'Border Color', 'Border Color', '', $cscheme['--bor-1'], '', 255, false, false, 'color');
echo '</div>';
echo '</div>';


echo '<input type="hidden" id="--col-1t" name="--col-1t" value="'.$cscheme['--col-1'].'33"/>';
echo '<input type="hidden" id="--col-2t" name="--col-2t" value="'.$cscheme['--col-2'].'33"/>';
echo '<input type="hidden" id="--col-3t" name="--col-3t" value="'.$cscheme['--col-3'].'33"/>';
echo '<input type="hidden" id="--col-4t" name="--col-4t" value="'.$cscheme['--col-4'].'33"/>';
echo '<input type="hidden" id="--col-7t" name="--col-7t" value="'.$cscheme['--col-7'].'33"/>';
echo '<input type="hidden" id="--col-9t" name="--col-9t" value="'.$cscheme['--col-9'].'33"/>';
echo '<input type="hidden" id="--col-10t" name="--col-10t" value="'.$cscheme['--col-10'].'33"/>';
echo '<input type="hidden" id="--col-15t" name="--col-15t" value="'.$cscheme['--col-15'].'33"/>';
echo '<input type="hidden" id="--bor-col1" name="--bor-col1" value="'.$cscheme['--bor-1'].'"/>';

echo '<div class="p-0 m-0">';
echo '<span class="mb-2 d-block text-center text-danger">Jika Anda mengubah pengaturan pada <b><i>Custom Color Scheme for Public</i></b> di atas silakan tekan tombol Update ini</span>';

F_submit_button('update-colorscheme', $l['w_update'].'" style="width:100%;margin:0!important', $l['h_update']);
echo '</div>';
echo '</div>';
echo '</div>';
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>';


echo '</div>';
echo '</div>';

?>


<?php

$uploadModal = '<div><form id="upload_mediafile_form" action="tmf_upload_mediafile_gs.php?path=logo" class="dropzone dz-clickable"><div class="dz-default dz-message"><button class="dz-button" type="button">Drop files here to upload</button></div></form></div>';

require_once('../code/tce_page_footer.php');
echo TMF_modal_info('uploadLogo','Upload Logo', $uploadModal, 'getImg()')
?>
<script>

	$("#timezone").select2();	
	$("#defLang").select2();	
		
	function getImg(){
		$.ajax({
			'url': 'tmf_general_settings.php?imglogo',
			'type': 'GET',
			'success': function(result){$("#logoImg").html(result);$("#logoImg").imagepicker();addDelBtn()}
		})
	}
	
	function delFile(a){
		if(confirm("Are you sure want to delete the file?")){
			$.ajax({
				'url': 'tmf_delete_file.php?path='+a,
				'type': 'GET',
				'success': function(result){alert(result);getImg()}
			})
		}else{
			getImg();
		}
	}
	
	function addDelBtn(){
		let imgSrc = $("div.thumbnail img").attr("src");
		$("div.thumbnail").append("<div style=\"top:-1em;right:-1em\" class=\"delbtn position-absolute border-0 btn btn-transition btn-outline-danger py-0 px-1\" onclick=\"delFile(this.previousSibling.getAttribute(\'src\'))\"><i class=\"pe-7s-close-circle\"></i></div>")
	}
	
	$("#selected-logo").html("<img style=\'max-width:100px\' src=\'"+$("#logoImg option[selected=selected]").attr("data-img-src")+"\' />");
	
	if($("#realtime_grading").prop("checked")==false){
		$("#answer_all_questions").prop("checked",false);
		$("#answer_all_questions").prop("readonly",true);
		$("#answer_all_questions").prop("disabled",true);
	};
	
	$("#realtime_grading").change(function(){
		if($("#realtime_grading").prop("checked")==true){
			$("#answer_all_questions").prop("readonly",false);
			$("#answer_all_questions").prop("disabled",false);
		}else{
			$("#answer_all_questions").prop("checked",false);
			$("#answer_all_questions").prop("readonly",true);
			$("#answer_all_questions").prop("disabled",true);
		}
	});
	
</script>
<?php
echo '<script src="../../shared/jscripts/vendor/dropzonejs/dropzone.js"></script>'.K_NEWLINE;
echo '<script src="../../shared/jscripts/image-picker/image-picker.min.js"></script>'.K_NEWLINE;
?>