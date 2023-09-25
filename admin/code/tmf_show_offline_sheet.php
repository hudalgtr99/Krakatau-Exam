<?php
ob_start();

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
require_once('../../shared/code/tce_authorization.php');

if(isset($_GET['testname'])){
	$testname = str_replace("'", " ", $_GET['testname']);
}
if(isset($_GET['username'])){
	$username = $_GET['username'];
}
if(isset($_GET['firstname'])){
	$firstname = str_replace("'", " ", $_GET['firstname']);;
}
if(isset($_GET['groupid'])){
	$groupid = $_GET['groupid'];
}
if(isset($_GET['groupname'])){
	$groupname = str_replace("'", " ", $_GET['groupname']);;
}
if(isset($_GET['reset'])){
	$reset = 1;
}

$enable_download = true;
$offline_sheets = true;
$static_test_lists = false;

if($enable_download){
// send headers
header('Content-Description: HTML File Transfer');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
// force download dialog
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream', false);
header('Content-Type: application/download', false);
header('Content-Type: text/html', false);
// use the Content-Disposition header to supply a recommended filename
// $filehtml = K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/'.stripcslashes($groupname).'/'.stripcslashes($firstname).'_Soal_'.stripcslashes($testname).'_'.stripcslashes($groupname).'_'.$username;
header('Content-Disposition: attachment; filename='.$firstname.'_Soal_'.$testname.'_'.$groupname.'_'.$username.'.html;');
header('Content-Transfer-Encoding: binary');
}

// F_show_offline_sheet();

// function F_show_offline_sheet(){
// $thispage_title = "LEMBAR SOAL OFFLINE";
$thispage_title = $firstname.'_Soal_'.$testname.'_'.$groupname.'_'.$username;
$thispage_title_icon = '<i class="fas fa-edit"></i> ';

// $thispage_title = "Aplikasi Penilaian Berbasis Digital";
// $thispage_title_alt = "<span class='spicoheader'><i class='fas fa-question'></i></span><span class='splblheader'>LEMBAR SOAL OFFLINE</span>";
require_once('tce_page_header.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../../shared/code/tmf_functions_test_stats_offline.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('tce_functions_user_select.php');

$filter = '';

if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied']);
        exit;
    }
    $filter .= '&amp;test_id='.$test_id.'';
} else {
    $test_id = 0;
}
if (isset($_REQUEST['testuser_id'])) {
    $testuser_id = intval($_REQUEST['testuser_id']);
    $filter .= '&amp;testuser_id='.$testuser_id;
} else {
    $testuser_id = 0;
}
if (isset($_REQUEST['user_id'])) {
    $user_id = intval($_REQUEST['user_id']);
    //if (!F_isAuthorizedEditorForUser($user_id)) {
    //	F_print_error('ERROR', $l['m_authorization_denied']);
    //	exit;
    //}
    $filter .= '&amp;user_id='.$user_id;
} else {
    $user_id = 0;
}
if (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
}

if (isset($_POST['lock'])) {
    $menu_mode = 'lock';
} elseif (isset($_POST['unlock'])) {
    $menu_mode = 'unlock';
} elseif (isset($_POST['extendtime'])) {
    $menu_mode = 'extendtime';
}
?>
<style>
*{user-select:none;-webkit-user-select:none;-moz-user-select:none;-o-user-select:none;}
body,div.body,div.content,div.tceformbox{background:#f0f2f5}
h1.pageTitleDesc span.splblheader{display:none !important}
img{max-width:100%}
div.tceformbox{padding:0}
div.content h1{margin-bottom:0}
input,textarea{user-select:text;-webkit-user-select:text;-moz-user-select:text;-o-user-select:text;}
ol.answer li {display:flow-root !important}
acronym.nobox, acronym.onbox, acronym.offbox {display:unset}
ol.answer li p {display:inline}
input#extendtime{padding:5px 9px;font-size:smaller;margin:0 0 0 7px}
h1.pageTitleDesc{background:#ffffff !important}
.vlabel {padding:3px 10px; border-radius:7px; font-weight:bold}
.merah {background:#f44336; color:#fff}
.orange {background:#ff9800; color:#fff}
.hijau {background:#4caf50; color:#fff}
.biru {background:#2196f3; color:#fff}
.ungu {background:#9c27b0; color:#fff}
div.rowl{padding:0}
div.row span.label {width:77px !important}
ol.question {padding-inline-start:0px;list-style-type:none;margin:0}
ol.question li:first-child div#prev,ol.question li:last-child div#next{display:none}
ol.answer {padding-inline-start:0px !important; display: grid !important;margin-bottom:5px}
ol.answer li {padding:10px; border-bottom:1px solid #eaeaea;border-radius:5px}
.answered{background:#ffffff;padding:5px}
.ansOLS{background:#333333;color:#ffffff;font-weight:bold;border:1px solid #000}
.answered:before{background:#2196f3;color:#2196f3}
.p-3-7{padding:3px 7px !important}
</style>
<?php
switch ($menu_mode) {
    case 'delete':{
        F_stripslashes_formfields();
        // ask confirmation
        F_print_error('WARNING', $l['m_delete_confirm']);
        echo '<div class="confirmbox">'.K_NEWLINE;
        echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_delete">'.K_NEWLINE;
        echo '<div>'.K_NEWLINE;
        echo '<input type="hidden" name="testuser_id" id="testuser_id" value="'.$testuser_id.'" />'.K_NEWLINE;
        F_submit_button('forcedelete', $l['w_delete'], $l['h_delete']);
        F_submit_button('cancel', $l['w_cancel'], $l['h_cancel']);
        echo '</div>'.K_NEWLINE;
        echo '</form>'.K_NEWLINE;
        echo '</div>'.K_NEWLINE;
        break;
    }

    case 'forcedelete':{
        F_stripslashes_formfields(); // Delete
        if ($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
                $sql = 'DELETE FROM '.K_TABLE_TEST_USER.'
					WHERE testuser_id='.$testuser_id.'';
            if (!$r = F_db_query($sql, $db)) {
                F_display_db_error();
            } else {
                $testuser_id = false;
                F_print_error('MESSAGE', $l['m_deleted']);
            }
        }
        break;
    }

    case 'extendtime':{
        // extend the test time by 5 minutes
        // this time extension is obtained moving forward the test starting time
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_creation_time=\''.date(K_TIMESTAMP_FORMAT, F_getTestStartTime($testuser_id) + (K_EXTEND_TIME_MINUTES * K_SECONDS_IN_MINUTE)).'\'
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'lock':{
        // update test mode to 4 = test locked
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_status=4
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    case 'unlock':{
        // update test mode to 1 = test unlocked
        $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
			SET testuser_status=1
			WHERE testuser_id='.$testuser_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
        } else {
            F_print_error('MESSAGE', $l['m_updated']);
        }
        break;
    }

    default: {
        break;
    }
} //end of switch

// --- Initialize variables

if (($test_id == 0) and ($testuser_id == 0)) {
    // select default test ID
    $sql = F_select_executed_tests_sql().' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $test_id = $m['test_id'];
        }
    } else {
        F_display_db_error();
    }
}

if ($formstatus) {
    if ((isset($changecategory) and ($changecategory > 0)) or empty($testuser_id)) {
            $sql = 'SELECT testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status, SUM(testlog_score) AS test_score, MAX(testlog_change_time) AS test_end_time
				FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
				WHERE testlog_testuser_id=testuser_id
					AND testuser_test_id='.$test_id.'
					AND testuser_status>0
				GROUP BY testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status
				ORDER BY testuser_test_id
				LIMIT 1';
    } else {
        $sql = 'SELECT testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status, MAX(testlog_change_time) AS test_end_time
			FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
			WHERE testlog_testuser_id=testuser_id
				AND testuser_id='.$testuser_id.'
				AND testuser_status>0
			GROUP BY testuser_id, testuser_test_id, testuser_user_id, testuser_creation_time, testuser_status
			LIMIT 1';
    }
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $testuser_id = $m['testuser_id'];
            $test_id = $m['testuser_test_id'];
            $user_id = $m['testuser_user_id'];
            $test_start_time = $m['testuser_creation_time'];
            $testuser_status = $m['testuser_status'];
            $teststat = F_getTestStat($test_id, 0, $user_id, 0, 0, $testuser_id);
            $test_end_time = $m['test_end_time'];
        } else {
            $testuser_id = '';
            $test_id = '';
            $user_id = '';
            $test_start_time = '';
            $test_end_time = '';
            $testuser_status = 0;
        }
    } else {
        F_display_db_error();
    }
}

// get test basic score
$test_basic_score = 1;
$sql = 'SELECT * FROM '.K_TABLE_TESTS.' WHERE test_id='.intval($test_id).'';
if ($r = F_db_query($sql, $db)) {
    if ($m = F_db_fetch_array($r)) {
        $test_basic_score = $m['test_score_right'];
        $test_duration_time = $m['test_duration_time'];
	$test_begin_time = $m['test_begin_time'];
	$test_end_time = $m['test_end_time'];
	$test_duration_time = $m['test_duration_time'];
	$test_password = $m['test_password'];
    }
} else {
    F_display_db_error();
}

echo '<div class="container">'.K_NEWLINE;
echo '<div id="loginBlock" class="txt-center">
	<div class="p-5 m-10 brad-5 bg-white boxshd-lt"><div class="pwrap w-p100 txt-center" style="box-sizing:border-box">
<span class="mb-10" id="idPes">
	<h3 class="m-1 mb-10">IDENTITAS PESERTA</h3>
<div style="display:flex;justify-contents:center;align-items:center" class="mb-5">
<span class="w-100 d-block txt-right">Test User ID</span><span class="ft-bold w-p100 p-5 bdl-5-blue bg-fb ml-5 d-block brad-5" id="idTUID">'.$test_id.'-'.$user_id.'</span>
</div>

<div style="display:flex;justify-contents:center;align-items:center" class="mb-5">
<span class="w-100 d-block txt-right">User</span><span class="w-p100 p-5 bg-fb brad-5 bdl-5-blue ml-5 d-block" id="idNama"></span>
</div>

<!--div style="display:flex;justify-contents:center;align-items:center" class="mb-5">
<span class="w-100 d-block txt-right">Jurusan</span><span class="ft-bold w-p100 p-5 bg-fb brad-5 bdl-5-blue ml-5 d-block" id="idJurusan"></span>
</div-->

<div style="display:flex;justify-contents:center;align-items:center" class="mb-5">
<span class="w-100 d-block txt-right">Grup</span><span class="ft-bold w-p100 bg-fb brad-5 p-5 bdl-5-blue ml-5 d-block" id="idKelas"></span>
</div>

</span></div></div>

	<div class="p-5 m-10 brad-5 bg-white boxshd-lt">

<div class="pwrap" style="display:flex;justify-content:center;align-items:center" id="loginForm">
<span class="d-block txt-right w-100">Password &nbsp; &nbsp;</span><input type="text" id="password" readonly="readonly" class="w-p100 p-5 bg-fb boxshd-inset-lt" style="width:0;height:0;padding:0!important" />&nbsp;<span id="infoPass">Tekan Reload jika kotak Password tidak muncul saat Ujian dimulai&nbsp;<span onclick="location.reload()" class="pwrap orange py-17  txt-center p-10 ft-bold boxshd-inset-solid">Reload</span></span></div>';

if(strlen($test_password)==0){
	$hide_token = 'display:none';
}else{
	$hide_token = 'display:flex';
}

// if(strlen($test_password)>0){
	echo '<div class="pwrap" style="'.$hide_token.';justify-content:center;align-items:center">
	<input type="hidden" id="token" value="'.$test_password.'"/>
	<span class="d-block txt-right w-100">Token &nbsp; &nbsp;</span><input type="text" id="inputtoken" class="w-p100 p-5 bg-fb boxshd-inset-lt" />&nbsp;
	</div>';
// }

echo '<div class="pwrap w-p100 txt-center" style="box-sizing:border-box">
<span style="box-sizing:border-box" class="pwrap hijau py-17 w-p100 txt-center p-10 ft-bold boxshd-inset-solid" id="masuk">MASUK</span>';

if(isset($reset) and ($reset==1)){
	echo '<span style="box-sizing:border-box" class="pwrap merah py-17 w-p100 txt-center p-10 ft-bold boxshd-inset-solid" id="clearLS" onclick="if(confirm(\'Apakah Anda yakin ingin mereset halaman?\')){localStorage.clear();localStorage.setItem(\'resetTUID\',document.getElementById(\'idTUID\').textContent);document.getElementById(\'loginBlock\').innerHTML = \'Harap tunggu sebentar\';setTimeout(function(){location.assign(location.href)},3000)};">RESET</span>';
	
}

echo '<span class="d-block mt-10 ft-gray6">* Masukkan <i>password</i> Anda ke dalam kotak di atas, kemudian tekan tombol <strong>MASUK</strong>.</span>

</div>


	</div>

</div>'.K_NEWLINE;
echo '<div class="tceformbox hidden">'.K_NEWLINE;
echo '<div class="d-flex jc-sb bg-white boxshd-lt p-10" id="utilBar">';
echo '<span id="bInfoUjian" class="bd-green ft-hijau p-5 brad-100 c-pointer">Info Ujian</span>';
echo '<div id="timerDiv" style="box-sizing:border-box" class="d-flex p-5 bd-merah brad-100 hidden">';
echo '<label for="timer" class="timerlabel ft-black">Sisa Waktu</label>&nbsp;&nbsp;';
echo '<span id="demo" class="ft-bold"></span>';
echo '</div>';
echo '<span id="bListSoal" class="bd-biru ft-biru p-5 brad-100 c-pointer">Daftar Soal</span>';
echo '</div>';
echo '<div id="listSoal" class="d-flex w-p100 p-10 brad-5 bg-white boxshd-lt jc-c" style="box-sizing:border-box;display:none;flex-wrap:wrap">';
//echo 'xxxxxxxxxo';
echo '</div>';
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_resultuser">'.K_NEWLINE;
echo '<div id="detailTes" class="hidden p-10 brad-5 bg-white boxshd-lt">';
echo '<div class="row">'.K_NEWLINE;
echo '<input type="hidden" id="test_begin_time" value="'.$test_begin_time.'" />';


/* $max_test_duration = strtotime($test_end_time) - strtotime($test_begin_time);
$test_duration_today_to_end = strtotime($test_end_time) - time();
$test_duration_seconds = $test_duration_time*60;

if($test_duration_today_to_end > $test_duration_seconds){
	$test_end_time = date('Y-m-d H:i:s', time()+$test_duration_seconds);
} */

echo '<input type="hidden" id="test_end_time" value="'.$test_end_time.'" />';
echo '<input type="hidden" id="test_duration_time" value="'.$test_duration_time.'" />';
echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_id">'.$l['w_test'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span id="namaUjian" class="formw vlabel merah">'.K_NEWLINE;
echo '<input type="hidden" name="testuser_id" id="testuser_id" value="'.$testuser_id.'" />'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
//echo '<select name="test_id" id="test_id" size="0" onchange="document.getElementById(\'form_resultuser\').changecategory.value=1;document.getElementById(\'form_resultuser\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
$sql = F_select_executed_tests_sql();
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        if ($m['test_id'] == $test_id) {
		$namaTest = $m['test_name'];
		echo $m['test_name']."<br/>";
		if( $m['test_random_questions_select']==1 or $m['test_random_questions_order']==1 or $m['test_random_answers_select']==1 or $m['test_random_answers_order']==1){
			$random_in_test=1;
		}else{
			$random_in_test=0;
		}
        }
    }
} else {
    F_display_db_error();
}

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

$sql = 'SELECT testuser_id, user_lastname, user_firstname, user_name, user_password, testuser_creation_time FROM '.K_TABLE_TEST_USER.', '.K_TABLE_USERS.' WHERE testuser_user_id=user_id AND testuser_test_id='.intval($test_id).'';
$sql .= ' ORDER BY user_lastname, user_firstname, user_name, testuser_creation_time DESC';
if ($r = F_db_query($sql, $db)) {
    while ($m = F_db_fetch_array($r)) {
        if ($m['testuser_id'] == $testuser_id) {
		if($random_in_test==1){

			$namaLengkap = $m['user_firstname'];

			echo '<div class="row">'.K_NEWLINE;
			echo '<span class="label">'.K_NEWLINE;
			echo '<label for="testuser_id">'.$l['w_user'].'</label>'.K_NEWLINE;
			echo '</span>'.K_NEWLINE;
			echo '<span class="formw vlabel orange" id="nmPes">'.K_NEWLINE;

			echo $m['user_name'].' ('.$m['user_firstname'].')';
			// echo '<input id="pagas" type="hidden" value="'.base64_encode($m['user_password']).'">';
			echo '<input id="pagas" type="hidden" value="'.$m['user_password'].'">';

			echo '</span>'.K_NEWLINE;
			echo '</div>'.K_NEWLINE;

			/*echo '<div class="row">'.K_NEWLINE;
			echo '<span class="label">'.K_NEWLINE;
			echo '<label for="testuser_id">Jurusan</label>'.K_NEWLINE;
			echo '</span>'.K_NEWLINE;
			echo '<span class="formw vlabel hijau" id="jurPes">'.K_NEWLINE;

			// $jurusan = $m['jurusan'];
			// echo $m['jurusan'];

			echo '</span>'.K_NEWLINE;
			echo '</div>'.K_NEWLINE;*/

			echo '<div class="row">'.K_NEWLINE;
			// echo date('Y-M-d H:i:s', 1620580264293);
			echo '<span class="label">'.K_NEWLINE;
			echo '<label for="testuser_id">Grup</label>'.K_NEWLINE;
			echo '</span>'.K_NEWLINE;
			echo '<span class="formw vlabel biru" id="kelPes">'.K_NEWLINE;

			// $kelas = $m['kelas'];
			// echo $m['kelas'];
			$grp = '';
			$sqlg = 'SELECT *
				FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
				WHERE usrgrp_group_id=group_id
					AND usrgrp_user_id='.$_GET['user_id'].'
				ORDER BY group_name';
			if ($rg = F_db_query($sqlg, $db)) {
				while ($mg = F_db_fetch_array($rg)) {
					$grp .= $mg['group_name'].' - ';
				}
			} else {
				F_display_db_error();
			}

			$grp = rtrim($grp, ' - ');
			echo $grp;

			echo '</span>'.K_NEWLINE;
			echo '</div>'.K_NEWLINE;
		}


        }
    }
} else {
    F_display_db_error();
}

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="testhash">Test User ID</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span id="test-user-id" class="formw vlabel ungu" style="font-family:monospace; font-size:large">';
if ($random_in_test==1){
	echo $test_id."-".$user_id;
}else{
	echo "menyesuaikan";
}
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>';

if (isset($teststat) and !empty($teststat)) {
    $teststat['testinfo'] = F_getUserTestStat($test_id, $user_id, $testuser_id);

    if (isset($testuser_id) and !empty($testuser_id) and !empty($teststat)) {
        echo '<div class="rowl">'.K_NEWLINE;
        echo F_printUserOfflineSheet($testuser_id);
        echo '</div>'.K_NEWLINE;

    }

}

echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
//////////////////

    echo '<div class="p-10 bg-white brad-5 m-10 boxshd-lt hidden" id="boxJawaban">';
	echo '<span onclick="if(confirm(\'Pastikan sebelumnya Anda telah menyalin Jawaban atau mengunduh Jawaban.\n\nApakah yakin ingin keluar?\')){localStorage.setItem(\'testFinished\',localStorage.getItem(\'logged_in_TUID\'));function locReload(){location.assign(location.href)};document.getElementById(\'boxJawaban\').textContent = \'Halaman akan dialihkan, harap tunggu\';setTimeout(locReload, 3000)}" id="keluarTes" name="keluarTes" class="mb-10 d-block pwrap vlabel merah p-10 c-pointer us-none" style="display:none">KELUAR</span>';
	echo '<span id="simpanJawaban" name="simpanJawaban" class="mb-10 d-block pwrap vlabel hijau p-10 c-pointer us-none">SALIN DAN UNDUH JAWABAN</span>';
	echo '<span id="infoDataJawaban" style="display:none" class="mb-10 d-block pwrap biru p-10">Di bawah ini adalah data Jawaban Anda.<br/>Sistem juga telah mengunduhkan Data Jawaban Anda dalam bentuk file .txt, silakan periksa di folder Unduhan Anda.<br/>Pastikan Anda mengamankan Data Jawaban yang berupa teks di bawah ini, atau file .txt yang berada di Unduhan Anda.<br/>Anda dapat mengirimkan <u>SALAH SATU</u> Data Jawaban yang berupa teks atau file .txt ke Admin atau Panitia Ujian.</span>';
	echo '<textarea onclick="this.select()" readonly="readonly" id="dataJawaban" style="width:100% !important;height:400px;box-sizing:border-box"></textarea>';
    echo '</div>';

echo '<div class="pagehelp">'.$l['hp_result_user'].'</div>'.K_NEWLINE;
//echo $namaTest;
//echo $jurusan;
//echo $kelas;
//echo $namaLengkap;
//echo $test_id;
//echo $user_id;
echo '</div>'.K_NEWLINE;
require_once('../code/tce_page_footer_offline.php');

//file_put_contents('../../cache/offline-sheets/soal-offline_'.$jurusan.'_'.$kelas.'_'.$namaLengkap.'_( '.$test_id.'-'.$user_id.' ).html', ob_get_contents());
// file_put_contents('../../cache/offline-sheets/SoalOffline-'.$username.'_'.$firstname.'_'.$groupname.'_'.$testname.'.html', ob_get_contents());

/* */

if($offline_sheets){
	if (!file_exists(K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname))) {
		mkdir(K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname), 0777, true);
		copy(K_PATH_CACHE.'offline-sheets/index.php', K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/index.php');
	}
	if (!file_exists(K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/'.stripcslashes($groupname))) {
		mkdir(K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/'.stripcslashes($groupname), 0777, true);
		copy(K_PATH_CACHE.'offline-sheets/index.php', K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/'.stripcslashes($groupname).'/index.php');
	}

	$filehtml = K_PATH_CACHE.'offline-sheets/'.stripcslashes($testname).'/'.stripcslashes($groupname).'/'.stripcslashes($firstname).'_Soal_'.stripcslashes($testname).'_'.stripcslashes($groupname).'_'.$username;
}
///////////////////////////////////////////////////////
// static test lists
if($static_test_lists){
	$ngroupname = preg_replace('/\s+/', '_', stripcslashes($groupname));
	$ntestname = preg_replace('/\s+/', '_', stripcslashes($testname));
	$nfirstname = preg_replace('/\s+/', '_', stripcslashes($firstname));
	if (!file_exists(K_PATH_CACHE.'static-test-lists/'.$ngroupname)){
		mkdir(K_PATH_CACHE.'static-test-lists/'.$ngroupname, 0777, true);
		copy(K_PATH_CACHE.'static-test-lists/index.php', K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/index.php');
	}

	$swjs = 'self.addEventListener("install", async event => {  console.log("install event")});self.addEventListener("fetch", async event => { console.log("fetch event")});const cacheName = "modeDarurat";const staticAssets = [  "./",  "./Soal_'.$ntestname.'.html"];self.addEventListener("install", async event => {  const cache = await caches.open(cacheName); await cache.addAll(staticAssets); }); self.addEventListener("fetch", event => {  const req = event.request;
	  event.respondWith(cacheFirst(req));}); async function cacheFirst(req) { const cache = await caches.open(cacheName); const cachedResponse = await cache.match(req); return cachedResponse || fetch(req);}';

	$filehtmltest = K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/'.$nfirstname.'/Soal_'.$ntestname;
	$fileswjs = K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/'.$nfirstname.'/sw.js';

	if (!file_exists(K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/'.$nfirstname)){
		mkdir(K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/'.$nfirstname, 0777, true);
		copy(K_PATH_CACHE.'static-test-lists/index.php', K_PATH_CACHE.'static-test-lists/'.$ngroupname.'/'.$nfirstname.'/index.php');
	}

	file_put_contents($fileswjs, $swjs);
}
// static test lists
///////////////////////////////////////////////////////////

// $usr_dir = $root_dir;
/* */

// $filehtml = K_PATH_CACHE.'offline-sheets/Soal_'.stripcslashes($testname).'_'.stripcslashes($groupname).'_'.$username.'_'.stripcslashes($firstname);

/* if(!isset($_GET['ext'])){
	$ext = 'html';
} */
if(isset($_GET['ext']) && $_GET['ext']=='html'){
	$ext = 'html';
}
if(isset($_GET['ext']) && $_GET['ext']=='zip'){
	$ext = 'zip';
}

if($offline_sheets){
	if(!file_exists($filehtml.'.'.$ext) or isset($_GET['timpa'])){
		file_put_contents($filehtml.'.html', ob_get_contents());
		if($ext=='zip'){
			$zip = new ZipArchive;
			if ($zip->open($filehtml.'.zip', ZipArchive::CREATE) === TRUE)
			{
				$zip->addFile($filehtml.'.html', basename($filehtml.'.html'));
				$zip->close();
			}
			unlink($filehtml.'.html');
		}
	}
}

//static test lists
if($static_test_lists){
	if(!file_exists($filehtmltest.'.'.$ext) or isset($_GET['timpa'])){
		file_put_contents($filehtmltest.'.html', ob_get_contents());
		if($ext=='zip'){
			$zip = new ZipArchive;
			if ($zip->open($filehtmltest.'.zip', ZipArchive::CREATE) === TRUE)
			{
				$zip->addFile($filehtmltest.'.html', basename($filehtmltest.'.html'));
				$zip->close();
			}
			unlink($filehtmltest.'.html');
		}
	}
}
ob_end_flush();
// }
//============================================================+
// END OF FILE
//============================================================+