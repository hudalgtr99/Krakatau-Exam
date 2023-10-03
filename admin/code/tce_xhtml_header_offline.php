<?php

//if necessary load default values
if (!isset($pagelevel) or empty($pagelevel)) {
    $pagelevel = 0;
}
if (!isset($thispage_title) or empty($thispage_title)) {
    $thispage_title = K_TCEXAM_TITLE;
}
if (!isset($thispage_title_alt) or empty($thispage_title_alt)) {
    $thispage_title_alt = "<span class='spicoheader'><i class='fas fa-home'></i></span><span class='splblheader'>Beranda</span>";
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
if(f_sc_name('tmf_show_offline_sheet.php')){
	$thispage_icon='';
}else{
	if (!isset($thispage_icon) or empty($thispage_icon)) {
	    $thispage_icon = K_TCEXAM_ICON;
	}
}

if (!isset($thispage_style) or empty($thispage_style)) {
    if (strcasecmp($l['a_meta_dir'], 'rtl') == 0) {
        $thispage_style = K_TCEXAM_STYLE_RTL;
    } else {
        $thispage_style = K_TCEXAM_STYLE;
    }
}

if(isset($_COOKIE['test_id'])){
	setcookie("test_id", "", time()-3600, "/");
}

echo '<!DOCTYPE html>'.K_NEWLINE;
echo '<html lang="en">'.K_NEWLINE;
echo '<head>'.K_NEWLINE;
echo '<meta charset="UTF-8">'.K_NEWLINE;
echo '<meta http-equiv="Content-Type" content="text/html; charset='.$l['a_meta_charset'].'" />'.K_NEWLINE;
echo '<meta name="viewport" content="width=device-width, initial-scale=1">'.K_NEWLINE;
echo '<title>'.strtoupper(htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset'])).'</title>'.K_NEWLINE;

if(f_sc_name('tmf_show_offline_sheet.php')){
	echo '<style>';

	echo '@font-face{font-family:\'Symbol\';src:url(\'data:application/octet-stream;base64,';
	echo file_get_contents('offline_assets/sym.base64');
	echo '\') format(\'truetype\')}';

	echo '@font-face{font-family:\'Wingdings\';src:url(\'data:application/octet-stream;base64,';
	echo file_get_contents('offline_assets/wgds.base64');
	echo '\') format(\'truetype\')}';

	echo file_get_contents('offline_assets/normalize.min.css');
	echo file_get_contents('offline_assets/default.css');
	echo '</style>';
}else{
echo '<link rel="stylesheet" href="'.$thispage_style.'" type="text/css" />'.K_NEWLINE;
echo '<link rel="stylesheet" href="'.K_PATH_HOST.K_PATH_TCEXAM.'public/styles/fontawesome/css/all.min.css" type="text/css" />'.K_NEWLINE;
echo '<link rel="stylesheet" href="'.K_PATH_HOST.K_PATH_TCEXAM.'admin/styles/selectize.css">'.K_NEWLINE;
}
$ua=$_SERVER['HTTP_USER_AGENT'];
if(strpos($ua, 'Chrome') !== false ){
	$jqmathcss='';
	$jqmathjs='';
}else{
	$jqmathcss='';
	$jqmathjs='';
}
echo $jqmathcss;
if(!f_sc_name("tmf_show_offline_sheet.php")){
	echo '<link rel="shortcut icon" href="'.$thispage_icon.'" />'.K_NEWLINE;
}
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
if(f_sc_name('tmf_show_offline_sheet.php')){
	echo '<script>';
	echo file_get_contents('offline_assets/jquery.min.js').K_NEWLINE;
	echo file_get_contents('offline_assets/jquery-scrolltofixed-min.js');
	echo file_get_contents('offline_assets/bcrypt.min.js');
	echo file_get_contents('offline_assets/FileSaver.min.js');
	echo 'import { saveAs } from \'file-saver\';';

	echo '</script>';
}else{
echo '<script type="text/javascript" src="../../shared/jscripts/jquery.min.js"></script>';
echo '<script src="'.K_PATH_HOST.K_PATH_TCEXAM.'shared/jscripts/selectize.min.js"></script>'.K_NEWLINE;
}

echo $jqmathjs;

if(f_sc_name('tmf_show_offline_sheet.php')){
	echo '<!-- no js editor -->';
}else{
	if(f_sc_name("tmf_word_import.php")){
		echo '<script type="text/javascript" src="../../shared/jscripts/ckeditor/ckeditor.js"></script>';
	}else{
		echo '<script type="text/javascript" src="../../shared/jscripts/tinymce/tinymce.min.js"></script>';
	}
}

?>

<?php
if(f_sc_name('tmf_show_offline_sheet.php')){
?>

<style>
.app-header__logo,.app-header__mobile-menu,.app-header__menu,.scrollbar-sidebar,.app-main__inner > div > h1:first-child{display:none}
</style>

<script>
var blockedCount = 2;
var resetPass = "tmf5758";

function resetAction(){
	var resetInput = prompt("Masukkan password reset");
	if(resetInput==resetPass){
		localStorage.clear();
		location.reload();
	}else{
		alert("PASSWORD RESET TIDAK VALID! Coba ulang kembali.");
	}
}

function display_c(){
	var refresh=500; // Refresh rate in milli seconds
	mytime=setTimeout('display_msg()',refresh)
}

function display_msg(){
	if(localStorage.getItem("logged_in")=="1"){
		if ( (document.hasFocus() && localStorage.getItem("lagiunduh")==null) || (document.hasFocus() && localStorage.getItem("testFinished")==null) ) {
			var terkunci = parseInt(localStorage.getItem("terkunci"));
			if(terkunci!=blockedCount){
				terkunci = terkunci+1;
				localStorage.setItem("terkunci",terkunci);
				document.getElementById("blocked").style.display = "flex";
				if(terkunci>2){
					document.getElementById("blocked").innerHTML = "<div>Halaman Terkunci<br><span class='ft-sm'>Tunggu hingga "+blockedCount+" hitungan</span><br>"+terkunci+"</div>";
				}else{
					document.getElementById("blocked").innerHTML = "<div>Halaman Terkunci<br><span class='ft-sm'>Tunggu hingga "+blockedCount+" hitungan</span><br>"+terkunci+"<br/><span class='ft-sm'>Apabila hitungan tidak berjalan normal, kemungkinan Anda membuka lebih dari satu halaman soal.</span><br/><span onclick='window.close()' class='bd-green ft-hijau p-5 brad-100 c-pointer ft-sm'>Tutup Soal</span></div>";
				}
				
			}else{
				document.getElementById("blocked").style.display = "none";
			}
		}else{
			localStorage.setItem("terkunci",0);
			document.getElementById("blocked").style.display = "flex";
			document.getElementById("blocked").innerHTML = "Halaman Terkunci";
		}
		display_c();
	}
}

window.onload=display_c;

	function myTimerx() {
		var tbeginx = new Date(localStorage.getItem("testBeginTime"));	
		var todayx = new Date();

		var tsTodayx = todayx.getTime();
		var tsBeginTx = tbeginx.getTime();
		if(tsTodayx>=tsBeginTx){
			$("#password").removeAttr("readonly");
			$("#password").removeAttr("style");
			$("#infoPass").hide();
		}
	}
	
	setTimeout(myTimerx, 1000);
	setTimeout(myTimerx, 2000);
	setTimeout(myTimerx, 3000);
	setTimeout(myTimerx, 4000);
	setTimeout(myTimerx, 5000);
	
$(document).ready(function(){

if(localStorage.getItem("curNo")==null && localStorage.getItem("unduh")){
	localStorage.clear();
}
	
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
if(urlParams.has('reset')){
	if(urlParams.get('reset')==resetPass){
		localStorage.clear();
		window.location.href = location.protocol + '//' + location.host + location.pathname;
	}
}

	var blockedDiv = document.createElement("div");
	blockedDiv.id = "blocked";
	blockedDiv.style.cssText = "text-align:center;color:#ffffff;justify-content:center;align-items:center;font-size: xx-large;display:none;position:fixed;width:100%;height:100%;z-index:999999;background:#000;top:0";
	document.body.appendChild(blockedDiv);
	
	if(localStorage.getItem("testFinished")==$("#idTUID").text()){
		$("#clearLS").hide();
	}

	var tuid = $("span#test-user-id").text();
	var tbegin = $("input#test_begin_time").val();
	var tend = $("input#test_end_time").val();
	var tdur = $("input#test_duration_time").val();
	localStorage.setItem("testUserID", tuid);
	localStorage.setItem("testBeginTime", tbegin);
	
	var today = new Date();
	var tendTime = new Date(tend);
	
	let tEndTimeInfo = "1";
	
	function myTimer(){
		// console.log("aaa");
		var tend = $("input#test_end_time").val();
		var today = new Date();
		var tendTime = new Date(tend);
	
		var testDurationTodayToEnd = tendTime.getTime() - today.getTime();
		var testDurationMS = 5000 + (tdur * 60 * 1000);
		var testEndTime;
		if(testDurationTodayToEnd > testDurationMS){
			testEndTime = new Date(today.getTime() + testDurationMS);
			if(localStorage.getItem("logged_in")==null){
				localStorage.setItem("testEndTime", testEndTime);
				
				if(tEndTimeInfo.length<2){
					tEndTimeInfo = chDateF(testEndTime);
					$("#endDateInfo").html(tEndTimeInfo);
				}				
			}
		}else{
			localStorage.setItem("testEndTime", tend);
		}
	}
	
	if(localStorage.getItem("logged_in")==null){
		setInterval(myTimer, 1000);
	}

	localStorage.setItem("testDurTime", tdur);

	var tBeginT = new Date(localStorage.getItem("testBeginTime"));
	var tEndT = new Date(localStorage.getItem("testEndTime"));
	var tDurT = new Date(localStorage.getItem("testDurTime"));

	var tsToday = today.getTime();
	var tsBeginT = tBeginT.getTime();
	var tsEndT = tEndT.getTime();
	var tsDurT = tDurT.getTime();

	function clrLSWhenTUIDfalse(){
		if(loggedInTUID !== tuid){
			localStorage.clear();
			location.reload();
		}
	}

	function chDateF(ccc){
		var tbtDate = ccc.getDate();

		var tbtMonth = ccc.getMonth();
		switch(tbtMonth){case 0: var tbtMonth = "Jan";break;case 1: var tbtMonth = "Feb";break;case 2: var tbtMonth = "Mar";break;case 3: var tbtMonth = "April";break;case 4: var tbtMonth = "Mei";break;case 5: var tbtMonth = "Juni";break;case 6: var tbtMonth = "Juli";break;case 7: var tbtMonth = "Agt";break;case 8: var tbtMonth = "Sept";break;case 9: var tbtMonth = "Okt";break;case 10: var tbtMonth = "Nov";break;case 11: var tbtMonth = "Des";break;}
		var tbtYear = ccc.getFullYear();

		var tbtJam = ''+ccc.getHours();
		if(tbtJam.length < 2){
			tbtJam = '0'+tbtJam;
		}

		var tbtMenit = ''+ccc.getMinutes();
		if(tbtMenit.length < 2){
			tbtMenit = '0'+tbtMenit;
		}

		var tbtDetik = ''+ccc.getSeconds();
		if(tbtDetik.length < 2){
			tbtDetik = '0'+tbtDetik;
		}

		var tbtFull = tbtDate+" "+tbtMonth+" "+tbtYear+"<span id=\"endTimeInfo\" class=\"bg-white ft-black p-2 ml-5 brad-100\">"+tbtJam+":"+tbtMenit+":"+tbtDetik+"</span>";
		return tbtFull;
	}


	if(tsToday >= tsEndT){
		$("div.tceformbox").addClass("hidden");
	}


	localStorage.setItem("namaUjian", $("span#namaUjian").text());
	var namaUjian = localStorage.getItem("namaUjian");

	var infoUjian = "<div class=\"p-10 m-10 bg-white brad-5 boxshd-lt\"><div style=\"display:flex;justify-content:center;align-items:center\" class=\"mb-5\"><span class=\"d-block txt-right w-100\">Ujian</span><span class=\"bg-biru ml-5 d-block w-p100 p-5 ft-white ft-bold bdl-5-blue2 brad-5\">"+namaUjian+"</span></div><div style=\"display:flex;justify-content:center;align-items:center;margin-bottom:5px\"><span class=\"d-block txt-right w-100\">Waktu Mulai</span><span class=\"bg-hijau ml-5 d-block w-p100 p-5 ft-bold ft-white bdl-5-green brad-5\">"+chDateF(tBeginT)+"</span></div><div style=\"display:flex;justify-content:center;align-items:center;margin-bottom:5px\"><span class=\"d-block txt-right w-100\">Waktu berakhir</span><span id=\"endDateInfo\" class=\"d-block ml-5 w-p100 p-5 bg-merah ft-bold ft-white bdl-5-red2 brad-5\">"+chDateF(tEndT)+"</span></div></div>"
	
	$("div#loginBlock").prepend(infoUjian);
	
	$("#idNama").text($("span#nmPes").text());
	$("#idJurusan").text($("span#jurPes").text());
	$("#idKelas").text($("span#kelPes").text());

	var loggedIn = localStorage.getItem("logged_in");
	var loggedInTUID = localStorage.getItem("logged_in_TUID");

	if(loggedIn!==null | loggedIn===1){
		clrLSWhenTUIDfalse();

		if(tsToday >= tsBeginT){
			$("div.tceformbox").removeClass("hidden");
			$("div#loginBlock").addClass("hidden");
			$("div#timerDiv").removeClass("hidden");
			$("div#boxJawaban").removeClass("hidden");
		}else{
			$("div#loginBlock").html(infoUjian+"\
<div class=\"bd-gray1 m-10 p-10\">\
<div>\
	<p>Ujian belum dimulai, silakan tunggu sesuai jadwal dan tekan tombol Reload di bawah apabila jadwal ujian telah dimulai</p>\
</div>\
<div>\
	<span class=\"pwrap bg-hijau ft-white ft-bold d-block txt-center\" onclick=\"location.reload()\">RELOAD</span>\
</div>\
</div>\
<div class=\"bg-merah\">\
	<div class=\"pwrap ft-white p-10\">\
	Apabila pertama kali membuka soal, silakan klik tombol CLEAR di bawah ini\
	</div>\
	<div class=\"p-10\">\
		<span class=\"pwrap bg-yellow ft-black ft-bold d-block txt-center ft-lg\" onclick=\"localStorage.clear();location.reload()\">CLEAR</span>\
	</div>\
</div>");
		}
	}


	$("span#masuk").click(function(){
		
		
		
		var bcrypt = dcodeIO.bcrypt;
		
		localStorage.setItem("curNo",1);
		
		var pagas = $("input#pagas").val();
		var pass = $("input#password").val();
		
		pagas = pagas.replace(/^\$2y(.+)$/i, '$2a$1');		
		
		var token = $("input#token").val();
		var inputtoken = $("input#inputtoken").val();
		
		if(token.length>0){
			token = token.replace(/^\$2y(.+)$/i, '$2a$1');
		}
	
		bcrypt.compare(pass, pagas, function(err, res){
			//console.log(res);
			if(res===true){
				if(token.length>0){
					bcrypt.compare(inputtoken, token, function(errToken, resToken){
						if(resToken===true){
							if(tsToday >= tsBeginT){
								localStorage.setItem("terkunci",blockedCount);
								// alert(cekLoginTime);
								// window.clearInterval(cekLoginTime);
								// cekLoginTime = -1;
								window.scrollTo(0,0);
								$("div#loginBlock").addClass("hidden");
								localStorage.setItem("logged_in_TUID", tuid);
								localStorage.setItem("logged_in","1");
								$("div#timerDiv").removeClass("hidden");
								$("div#boxJawaban").removeClass("hidden");
							}else{
								$("div#loginBlock").html("<div class=\"pwrap\"><div>Ujian belum dimulai, silakan tunggu dan tekan tombol Reload di bawah apabila jadwal ujian telah dimulai</div><div><span class=\"pwrap bg-hijau ft-white ft-bold d-block txt-center\" onclick=\"location.reload()\">RELOAD</span></div></div>");
								location.reload();
							}
							window.scrollTo(0,0);
							localStorage.setItem("logged_in","1");
							localStorage.setItem("logged_in_TUID", tuid);
							location.reload();
						}else{
							alert("TOKEN TIDAK VALID!");
						}
					})
				}else{
					if(tsToday >= tsBeginT){
						localStorage.setItem("terkunci",blockedCount);
						// alert(cekLoginTime);
						// window.clearInterval(cekLoginTime);
						// cekLoginTime = -1;
						window.scrollTo(0,0);
						$("div#loginBlock").addClass("hidden");
						localStorage.setItem("logged_in_TUID", tuid);
						localStorage.setItem("logged_in","1");
						$("div#timerDiv").removeClass("hidden");
						$("div#boxJawaban").removeClass("hidden");
					}else{
						$("div#loginBlock").html("<div class=\"pwrap\"><div>Ujian belum dimulai, silakan tunggu dan tekan tombol Reload di bawah apabila jadwal ujian telah dimulai</div><div><span class=\"pwrap bg-hijau ft-white ft-bold d-block txt-center\" onclick=\"location.reload()\">RELOAD</span></div></div>");
						location.reload();
					}
					window.scrollTo(0,0);
					localStorage.setItem("logged_in","1");
					localStorage.setItem("logged_in_TUID", tuid);
					location.reload();
				}
			}else{
				alert("Password yang Anda masukkan TIDAK VALID");
			}
		});
	})

	var curNo = parseInt(localStorage.getItem("curNo"));
	$("ol.question > li:nth-child("+curNo+")").toggleClass("hidden");

	$("div#next").click(function(){
		var curNo = parseInt(localStorage.getItem("curNo"));
		var nextNo = parseInt(curNo)+parseInt(1);
		if(parseInt(jmlBtrSoal)!==curNo){
			localStorage.setItem("curNo",nextNo);
			$("ol.question > li:nth-child("+curNo+")").toggleClass("hidden");
			$("ol.question > li:nth-child("+nextNo+")").toggleClass("hidden");
			window.scrollTo(0,0);
		}
	})

	$("div#prev").click(function(){
		var curNo = parseInt(localStorage.getItem("curNo"));
		var prevNo = parseInt(curNo)-parseInt(1);
		if(curNo!==1){
			localStorage.setItem("curNo",prevNo);
			$("ol.question > li:nth-child("+curNo+")").toggleClass("hidden");
			$("ol.question > li:nth-child("+prevNo+")").toggleClass("hidden");
			window.scrollTo(0,0);
		}
	})



	var isTestFinished = localStorage.getItem("testFinished");
	var lsTestUserID = localStorage.getItem("testUserID");
	if(isTestFinished==lsTestUserID){
		$("div#loginBlock").html("<h3 class=\"txt-center\">Ujian telah berakhir</h3>");
		$("div#timerDiv").addClass("hidden");
		localStorage.removeItem("logged_in");
		$("div#boxJawaban").removeClass("hidden");
	}

	var jmlBtrSoal = $("ol.question > li").length;
	var jmlSoal = $("ol.question > li").length + 1;

	var i;
	var o;
	var p='';
	for(i=1; i < jmlSoal; i++){
		o = localStorage.getItem(i);
		if(o===null){
			o = 0;
		}
		$("ol.question li:nth-child("+i+") ol.answer li:nth-child("+o+")").addClass("answered");
		$("div#listSoal").append("<span class=\"c-pointer bd-gray1 ft-bold brad-3 p-5 h-20 w-20 d-flex jc-se m-3\" id=\""+i+"\">"+i+"</span>");
		if(o!==0){
			$("#"+i).addClass("ansOLS");
		}
	}

	$("ol.answer li").click(function(){
		localStorage.setItem("is_mengerjakan","1");
		var liClass = $(this).attr("class");
		if(liClass!=="answered"){
			var opsi = $(this).index();
			var iOpsi = opsi + 1;
			switch(iOpsi){case 1: var iOpsi = 'A';break;case 2: var iOpsi = 'B';break;case 3: var iOpsi = 'C';break;case 4: var iOpsi = 'D';break;case 5: var iOpsi = 'E';break;case 6: var iOpsi = 'F';break;case 7: var iOpsi = 'G';break;case 8: var iOpsi = 'H';break;case 9: var iOpsi = 'I';break;case 10: var iOpsi = 'J';break;case 11: var iOpsi = 'K';break;case 12: var iOpsi = 'L';break;case 13: var iOpsi = 'M';break;case 14: var iOpsi = 'N';break;case 15: var iOpsi = 'O';break;case 16: var iOpsi = 'P';break;case 17: var iOpsi = 'Q';break;case 18: var iOpsi = 'R';break;case 19: var iOpsi = 'S';break;case 20: var iOpsi = 'T';break;}
			var parentIndex = $(this).parents("li").index();
			var iNomor = parentIndex + 1;
				localStorage.setItem("NO_"+iNomor, iNomor+"."+iOpsi);
				localStorage.setItem(iNomor, opsi+1);
				$(this).addClass("answered");
				$(this).siblings().removeClass("answered");
			$("span#"+iNomor).addClass("ansOLS");
		}
	})


	$("span#simpanJawaban").click(function(){
		var nmUjian = $("span#namaUjian").text().replace(/'/g, '').replace(/(?:\r\n|\r|\n)/g, '');
		var nmPeserta = $("span#nmPes").text().replace(/'/g, '').replace(/(?:\r\n|\r|\n)/g, '');
		var kelPeserta = $("span#kelPes").text().replace(/'/g, '').replace(/(?:\r\n|\r|\n)/g, '');
				
		var jmlSoalTerjawab = $("li.answered").length;
		var sisaSoal = jmlBtrSoal - jmlSoalTerjawab;
		if(((jmlSoalTerjawab == jmlBtrSoal) || localStorage.getItem("testFinished")===loggedInTUID) && localStorage.getItem("is_mengerjakan")==="1"){
			p = '';
			for(i=1; i < jmlSoal; i++){
				p += localStorage.getItem("NO_"+i)+"\r\n";
				if(p===null){p = '';}
			}
			$("textarea#dataJawaban").val("<"+nmPeserta+" | "+nmUjian+" | "+kelPeserta+">"+btoa(tuid+"\n"+p));

			var lsTestFinished = localStorage.getItem("testFinished");
			var lsTestUserID = localStorage.getItem("testUserID");

			if(lsTestFinished===null){
				var conf = confirm("Anda masih diperkenankan untuk memeriksa kembali Jawaban Anda. \n\nApabila sudah yakin tekan Oke. Apabila ingin mengubah jawaban tekan Batal");
			}else{
				var conf = true;
			}
			if(conf){
				localStorage.setItem("lagiunduh","1");
				var asd = new Blob(["<"+nmPeserta+" | "+nmUjian+" | "+kelPeserta+">"+btoa(tuid+"\r\n"+p)], {type: "text/plain;charset=utf-8"});

				saveAs(asd, "jwbn_"+nmPeserta+"_"+nmUjian+"_"+kelPeserta+".txt");
				alert("Jawaban Anda akan disalin / diunduh");
				
				$("textarea#dataJawaban").select();
				document.execCommand('copy');
				$("textarea#dataJawaban").blur();
				

				$("#infoDataJawaban").show();

				$("span#keluarTes").show();
				localStorage.setItem("unduh","1");
				localStorage.removeItem("lagiunduh");
			}
		}else{
			if(localStorage.getItem("is_mengerjakan")===null){
				alert("Anda tidak mengerjakan Ujian. Tidak ada jawaban yang disalin");
			}else{
				alert("Ada "+sisaSoal+" soal yang belum terjawab. Silakan periksa kembali jawaban Anda.");
			}
		}
	})

	if(tuid!=lsTestUserID){
		localStorage.clear();
	}

var countDownDate = new Date(tsEndT);

var x = setInterval(function() {

  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  days = ''+days;
  hours = ''+hours;
  minutes = ''+minutes;
  seconds = ''+seconds;

  if(days == 0){
	var hidedays = "style='display:none'";
	if(hours == 0){
		var hidehours = "style='display:none'";
		if(minutes == 0){
			var hidemin = "style='display:none'";
		}
	}
  }


  // Display the result in the element with id="demo"
  if(hours.length<2){hours = '0'+hours;}
  if(minutes.length<2){minutes = '0'+minutes;}
  if(seconds.length<2){seconds = '0'+seconds;}


  $("#demo").html("<span class='kondon hari' "+hidedays+">"+ days + " hr&nbsp;</span><span "+hidehours+">" + hours + "</span>:<span class='kondon menit' "+hidemin+">"
  + minutes + "</span>:<span class='kondon detik'>" + seconds + "</span>");
  
  if(localStorage.getItem('testUserID')==localStorage.getItem('testFinished')){
	  distance = -1;
	  localStorage.clear();
	}
	
  // If the count down is finished, write some text
  if (distance < 0){
    clearInterval(x);
    $(".pageTitleDesc").append("<span class='d-block bg-merah ft-white p-10'>Waktu mengerjakan Ujian telah selesai</span>");
    localStorage.setItem("testFinished",loggedInTUID);
    $("div.tceformbox").addClass("hidden");
	$(".pageTitleDesc").append("<span id='btnReset' onclick='resetAction()' class='d-block bg-ungu ft-white p-10'>RESET</span>");
  }
}, 1000);

$("#bInfoUjian").click(function(){
	$("div#detailTes").toggleClass("hidden");
})

$("#bListSoal").click(function(){
	$("div#listSoal").toggle();
})

$("div#listSoal span").click(function(){
	$(this).addClass("bd-biru");
	$(this).siblings().removeClass("bd-biru");

	var curNo = localStorage.getItem("curNo");
	var targetNo = $(this).attr("id");
	if(curNo!==targetNo){
		$("ol.question > li:nth-child("+curNo+")").toggleClass("hidden");
		$("ol.question > li:nth-child("+targetNo+")").toggleClass("hidden");
		localStorage.setItem("curNo",targetNo);
		window.scrollTo(0,0);

	}
})

$("div#utilBar").scrollToFixed(function(){
	$(this).css({padding:"10px 0"});
});

})
</script>
<?php
}
?>

<script>
$(document).ready(function(){
if(window.localStorage===null){
	alert("Beberapa fitur pada Web Browser Anda tidak aktif. Ganti web browser dengan yang disarankan oleh Panitia.");
	exit();
}
<?php
if(!f_sc_name('tmf_show_offline_sheet.php')){
?>
$('#user_groups,#subject_id[multiple],#test_id[multiple]').selectize({
	plugins: ['remove_button']
});

$('.sel-edit-test,select#display_mode,select#omrdir').selectize({
	create: true,
	sortField: 'text',
	onFocus: function (){
    var value = ' ';
    if (value.length > 0) {
        this.clear(true);
        this.$control_input.val(value);
        }
    }
});
<?php
}
?>


	$("input[type=radio]#checkall1").click(function(){
		$("td#checkbox input[type=checkbox]").prop("checked", $(this).prop("checked"));
	});

	$("input[type=radio]#checkall0").click(function(){
		$("td#checkbox input[type=checkbox]").prop("checked", false);
	});


	$("div#logout").click(function(){
		window.open("tce_logout.php");
	});

	var wdWidth = $(window).width();
	var mnWidth = $("div#scrollayer-mod").width();
	var divBodyWd = wdWidth - mnWidth;

	$("li ul.fa-ul li a").click(function(){
		$("div#mamanSFL").show();
	});

	if(window.matchMedia('(max-width:600px)').matches){
		$("#menuHide").css("position","absolute");
		$("#menuHide").css("left","-100px");
		$("span#menuShow").show();
		$("div.body").css("width","100%");

		$("#menuHide").click(function(){
			$("div#scrollayer-mod").css("whiteSpace","nowrap");

			$("div#scrollayer-mod").css("left","-300px");

			$("div.body").css("width","100%");
			$(this).css("left","-100px");
			$("span#menuShow").show();
		});

		$("#menuShow").click(function(){
			$("#menuHide").css("left","267px");
			$("div#scrollayer-mod").css("whiteSpace","nowrap");
			$("div#scrollayer-mod").css("left", "0px");
			$("div.body").css("width","100%");
			$(this).hide();
		});

	}

	if(window.matchMedia('(min-width:601px)').matches){
		
		$(window).on("resize", function(){
			var wdWidth = $(window).width();
			var mnWidth = $("div#scrollayer-mod").width();
			var divBodyWd = wdWidth - mnWidth;
			$("div.body").css({width: divBodyWd+'px'});
		})

		$("div.body").css("width",divBodyWd+"px");

		$("#menuHide").click(function(){
			$("div#scrollayer-mod").css("whiteSpace","nowrap");
			$("div.body").css("width","100%");
			$("div#scrollayer-mod").css("left","-300px");
			$(this).hide();
			$("span#menuShow").show();
		});

		$("#menuShow").click(function(){
			var wdWidth = $(window).width();
			var mnWidth = $("div#scrollayer-mod").width();
			var divBodyWd = wdWidth - mnWidth;
			$("div#scrollayer-mod").css("whiteSpace","nowrap");

			$("div.body").css('width', divBodyWd+'px');
			$("div#scrollayer-mod").css("left","0px");
			$(this).hide();
			$("span#menuHide").show();
		});
	}

	var divBodyHg = $("div.body").css("height");
	if(parseInt(divBodyHg) < 500){
		var divBodyHg = "700px";
	}
	$("div#scrollayer-mod").css("height",divBodyHg);
	
	$(window).on("resize", function(){

		divBodyHg = $("div.body").css("height");
		if(parseInt(divBodyHg) < 500){
			var divBodyHg = "700px";
		}
		$("div#scrollayer-mod").css("height",divBodyHg);
	})

	$("span.active").parents().eq(1).show();
	$("ul.menu-mod li").click(function(){
		$(this).children("ul").slideToggle();
		$("ul.menu-mod li").not(this).children("ul").slideUp();
	})
	$("input#new_test_password").attr("type","text");
	$("acronym.okbox").html("&check;");
	var colspan = $("td#berhasil").attr("colspan");
	var statistik = $("th#statistik").attr("colspan");
	$("input#waktu_mulai_input").change(function(){
		var checked = $(this).is(":checked");
         if(checked) {
		$("th#time_begin").show();
			$("td#time_begin").show();
			colspan = colspan + 1;
			statistik = statistik + 1;
			$("td#berhasil").attr("colspan",colspan);
			$("th#statistik").attr("colspan",statistik);
            } else {
		$("th#time_begin").hide();
			$("td#time_begin").hide();
			colspan = colspan - 1;
			statistik = statistik - 1;
			$("td#berhasil").attr("colspan",colspan);
			$("th#statistik").attr("colspan",statistik);
            }
	});

	$("input#durasi_input").change(function(){
		var checked = $(this).is(":checked");

         if(checked) {
                $("th#test_time").show();
			$("td#test_time").show();
			colspan = colspan + 1;
			statistik = statistik + 1;
			$("td#berhasil").attr("colspan",colspan);
			$("th#statistik").attr("colspan",statistik);
            } else {
                $("th#test_time").hide();
			$("td#test_time").hide();
			colspan = colspan - 1;
			statistik = statistik - 1;
			$("td#berhasil").attr("colspan",colspan);
			$("th#statistik").attr("colspan",statistik);
            }
	});

	$("input#sisa_durasi_input").change(function(){
		var checked = $(this).is(":checked");

        if(checked) {
                $("th#sisa_durasi").show();
			$("td#sisa_durasi").show();
			colspan = colspan + 1;
			$("td#berhasil").attr("colspan",colspan);
            } else {
	            $("th#sisa_durasi").hide();
			$("td#sisa_durasi").hide();
			colspan = colspan - 1;
			$("td#berhasil").attr("colspan",colspan);
            }
	});

	$("input#delete, ul.usrsel_act li button, ul.usrsel_act li input").click(function(){
		var btnTitle = $(this).attr("title");
		return confirm('Apakah yakin ingin '+btnTitle+'?');
	});

	$("#exportPDF").mouseup(function(){
		hidemenuPrint();
	})

	function prepExcelExp() {
		$("th#checkbox").hide();
		$("td#checkbox").hide();
		$("th#sisa_durasi").css("width","1px");
		$("td#sisa_durasi").css("width","1px");
		$("table.userselect tr").css("height","25px");

		var thNum = $("table#userselect > thead > tr:first > th").length;

		$("td#berhasil").attr("colspan",thNum);
		$("th#statistik").attr("colspan","8");
		$("td.sisa_durasi_bawah").attr("colspan","1");
		$("td#checkbox input[type='checkbox']").remove();
		var item_html = "<html><head><style>body{background:none !important}table thead th{vertical-align:middle; font-weight:bold; background:#ccc}td{vertical-align:top}h1{font-size:20px}#header_cetak{text-align:center;border-bottom:3px solid #999;background:url('<?php echo K_PATH_HOST; ?>/cbt/cache/logo/<?php echo K_INSTITUTION_LOGO; ?>');background-repeat:no-repeat;background-size:130px;background-position:30px 0}th,td{padding:7px}a{text-decoration:none; color:#000}th#checkbox, td#checkbox{width:1px; padding:0px}input{display:none}th, td{border:.5pt solid black !important; background:#fff}</style></head><body><div id='header_cetak'>" + $('div#header_cetak').html() + "</div>" + $('#tabel_hasil_test').html();

		var fileURL = 'data:application/vnd.ms-excel,' + encodeURIComponent(item_html);
		var test_name = $("select#test_id option[selected='selected']").text();
		var group_name = $("select#group_id option[selected='selected']").text();
		if(test_name.length < 4){
			test_name = "Semua Ujian"
		}
		if(group_name.length < 4){
			group_name = "Semua Kelas"
		}
		$("a#export_excel").attr("href", fileURL);
		$("a#export_excel").attr("download", test_name + "_" + group_name + ".xls");
	}


	$("a#export_excel").click(function(){
		prepExcelExp();
		location.reload();
	})
<?php if(f_sc_name("tce_show_result_allusers.php")){ ?>
	var selected_test = $("select#test_id option:selected").html();
	if (selected_test != "&nbsp;-&nbsp;") {
		//alert("terpilih");
		$("a[title='test, ujian']").parent().hide();
		$("td#nm_ujian").hide();
		var nm_ujian = selected_test.substring(11);
		$("p#nm_ujian").html("<span style='font-weight:bold;width:50px;display:inline-block'>Ujian </span><span>: "+nm_ujian+"</span>");
		colspan = colspan - 1;
		statistik = statistik - 1;
		//alert(statistik);
		$("td#berhasil").attr("colspan",colspan);
		$("th#statistik").attr("colspan",statistik);
	}
<?php } ?>

	var selected_group = $("select#group_id option:selected").html();
	if (selected_group != "&nbsp;-&nbsp;") {
		$("a[title='kelas']").parent().hide();
		$("td#kelas").hide();
		$("p#kelas").html("<span style='font-weight:bold;width:50px;display:inline-block'>Kelas </span><span>: "+selected_group+"</span>");
		colspan = colspan - 1;
		statistik = statistik - 1;

		$("td#berhasil").attr("colspan",colspan);
		$("th#statistik").attr("colspan",statistik);
	}

});
function hidemenuPrint(){
	$("#menuHide").trigger("click");
	var menuPos = $("#scrollayer-mod").css("left");
	if(menuPos=="-300px"){
		window.print();
	}
	$("#menuShow").trigger("click");
}

</script>

<style>
<?php
if(f_sc_name('tmf_show_offline_sheet.php')){
?>
	a,span#menuShow{display:none !important}
	div.header, #footer, .rowexp, span[dir=ltr],input[type=checkbox],select#menu_action,select#new_subject_id,label[for=hide_answers],input#update{display:none}
	#scrollayer-mod{left:-500px;width:0;z-index:-999999999}
	input[type=submit], div.rowl hr, div.rowl h2, span#menuHide {display:none}
	div.body{width:100% !important}

	div#qDesc {overflow:auto}
	#demo {display:flex;justify-contents:center;align-items:center}
	
	textarea#dataJawaban {
		user-select: all;
		-webkit-user-select: all;
	}

/*	.kondon {padding:2px 5px;text-align:center;line-height:1;background:#d84315;color:#ffffff;border-radius:3px;font-size:1.1em}
	.kondon:nth-child(2),.kondon:nth-child(3),.kondon:nth-child(4){margin-left:3px}*/

<?php
}

if(f_sc_name("tce_show_result_allusers.php")){
?>
            @media print {

		#minduration, #addduration, #aatime, #regrade, #a_regradewap, #footer, h1.pageTitle, div#printMe input, a#export_excel, div#exportPDF input, div#table_field_select{
			display:none
		}

               .header, .scrollmenu, div.row, span[dir="ltr"], input[type="submit"], input[type="checkbox"], div.message {
                  display: none;
               }
            }

		@media screen {
		div#header_cetak, div#footer_cetak {
			display:none;
			}
		}

		formw select, select {
			text-transform: none !important
		}
<?php
}
?>
        </style>
<?php
echo '</head>'.K_NEWLINE;

echo '<body>'.K_NEWLINE;
	echo '<noscript>';
	echo '<h3 class="txt-center ft-lg">Nampaknya halaman sedang bermasalah. Silakan aktifkan Javascript pada Browser.</h3>';
	echo '<div class="pwrap bg-merah ft-white m-10 boxshd"><p class="txt-center ft-lg">Apabila file ini berada di <span class="ft-sm pwrap bg-white ft-black boxshd brad-100">Google Drive</span> sebaiknya unduh terlebih dahulu, lalu dibuka kembali file yang diunduh menggunakan Web Browser Anda.</p></div>';
	echo '<style>div.content{display:none}</style>';
	echo '</noscript>';

if(!f_sc_name('tmf_show_offline_sheet.php')){
	echo '<div class="hidden" id="mamanSFL">'.K_NEWLINE;
	echo '<img id="imgSFL" src="../../images/loader/loading6.gif" /><br/><p onclick="location.reload()" id="loadText" style="cursor:pointer; line-height:17px;color:#fff;background:#689cc5;padding:7px 22px; border-radius:50px; display:inline-block;margin:0px;font-size:0.85em;font-weight:"><b>r e l o a d</b></p><!--p><span style="font-size:small; line-height:2">Apabila loading lebih dari 60 detik tekan tombol reload.<br/><a href="#" onclick="location.reload()" style="text-decoration:none; background:green; border-radius:50px; color:#fff; padding:7px 14px">RELOAD</a></span></p-->'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
}
if(f_sc_name("tce_show_result_allusers.php")){
?>
<div id="header_cetak" style="text-align:center;border-bottom:3px solid #999;background:url('../../cache/logo/<?php echo K_INSTITUTION_LOGO; ?>');background-repeat:no-repeat;background-size:100px;background-position:30px 0">
<?php
//include('../../cache/print/header.php');
echo "<h1>".K_TEST_EVENT."<br/>".K_INSTITUTION_NAME." ".K_INSTITUTION_ADDRESS2."<br/>".K_INSTITUTION_ADDRESS1."<br/>".K_INSTITUTION_ADDRESS3."<br/>".K_ACADEMIC_LABEL."</h1>";
echo "<br/>";
//echo $_SESSION["session_user_firstname"];
?>
</div>
<?php
}
global $login_error;
if (isset($login_error) and $login_error) {
    F_print_error('WARNING', $l['m_login_wrong']);
}

//============================================================+
// END OF FILE
//============================================================+