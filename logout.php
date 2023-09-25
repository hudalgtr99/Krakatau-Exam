<?php
$arr = 'Imh0dHBzOi8vdG9rb3BlZGlhLmxpbmsva2xZV1hMc1pMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL2pTMmNWWHZaTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay8ySU1GSVpTWkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsvN2hOcUhZVlpMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL2xPN0VtcTMxTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay8wSUFBeDhYWkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsvUERucXNDYTJMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL2FsMWhwNGIyTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay9URjVzdDZkMkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsvQUVIa2FIaDJMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL1Rtek1nNW0yTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay9DQlB3MEtwMkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsvWkdwc2hQczJMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL1hZTkJva3cyTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay9mMkI0bmx5MkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsvRzEzZndpQTJMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rLzBoWEx6WEIyTHNiIiwiaHR0cHM6Ly90b2tvcGVkaWEubGluay9JcmJxMzlEMkxzYiIsImh0dHBzOi8vdG9rb3BlZGlhLmxpbmsva0NNTjhsTjJMc2IiLCJodHRwczovL3Rva29wZWRpYS5saW5rL1dZWXNNOVQyTHNiIg';
$x = explode(',',str_replace('"','',base64_decode($arr)));

?>

<!doctype html>
<html class="no-js" lang="id" translate="no">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logout</title>
<meta name="language" content="id" />
<meta name="tcexam_level" content="0" />
<meta name="description" content="[TCExam] Enhancement of Original TCExam with Additional Features  [TCExam (c) 2004-2020 Nicola Asuni - Tecnick.com - tcexam.com]" />
<meta name="author" content="Maman Sulaeman"/>
<meta name="reply-to" content="mamansulaeman86@gmail.com" />
<meta name="keywords" content="TCExam, TCExam Mobile Friendly, e-exam, CBT, CAT" />
<meta name="google" content="notranslate">
<meta property="og:title" content="Login">
<meta property="og:type" content="">
<meta property="og:url" content="">
<meta property="og:image" content="">
<!-- TCExam19730104 -->
  <link rel="manifest" href="a2hs/site.webmanifest">
  <link rel="apple-touch-icon" href="a2hs/icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="shortcut icon" href="a2hs/favicon.ico" />
  <link rel="stylesheet" href="public/styles/default.min.css?10032021">
    <!--link rel="stylesheet" href="../styles/fontawesome/css/all.min.css" type="text/css" /-->
  <meta name="theme-color" content="#fafafa">
  <script src="shared/jscripts/es5.js"></script>

<style>#termbtn{display:none}</style><style>div.pagehelp{display:none}</style>
<style>.tmfpatch{color: var(--col-11)!important;border:1px solid var(--col-15t);border-radius:50em;padding:0.05em 0.35em;}</style></head>
<body style="background-image:url(images/background.jpg);background-position:center;background-size:auto;background-blend-mode:normal">
<div class="backdrop" onclick="drawerClose()"><div id="reloadCont" style="display:none;color:#fff;position:fixed;top:45%;left:50%;transform:translate(-50%,-50%);"><div style="margin:25px auto;position:relative;font-size:xxx-large;width:50px;height:50px" class="anim-rotate"><span id="bigDeg" style="position:absolute;top:98%;left:16%;transform:translate(-50%, -50%);font-weight:lighter;font-size:65px;">&deg;</span><span style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-weight:bold"><sup>&deg;</sup></span><span style="position:absolute;top:120%;left:90%;transform:translate(-50%, -50%);"><sup>&deg;</sup></span></div><span style="cursor:pointer;pointer-events:all;padding:0.25em 1.25em;border-radius:100px;border:2px solid #fff;user-select:none" onclick="location.reload()">RELOAD</span></div></div>

<div class="qlistCont" id="langSelID">
<div id="qlistTitle"><div><p><span class="icon-flag-o"></span> bahasa</p><span id="qlistClose" onclick="langSelHide()">&times;<span></div></div><div>
</div>
</div>

<div class="body">
<form action="/tmfajax1-2/public/code/index.php" id="timerform">
<div id="utilTop" class="d-flex utilTopClock jc-sb fwrap">
<div id="nosoalTop"></div>
<div class="d-flex">
<div id="timerdiv" class="d-flex timerClock">
<label for="timer" class="timerlabel hidden show768">waktu</label>
<input type="text" name="timer" id="timer" value="" size="29" maxlength="29" title="jam / pengatur wWaktu" readonly="readonly"/></div>
<div id="qlistTop"></div>
</div>
</div>
</form>
<script src="shared/jscripts/timer.js?10032021" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
FJ_start_timer(false, 1616228600, 'maaf, waktu yang tersedia untuk menyelesaikan test telah usai', false, 1616228600256);
//]]>
</script>
<a name="topofdoc" id="topofdoc"></a>
<div id="containerWrapper" class="p-1em-768"><div class="container">
<div class="tceformbox login_box" style="border-radius:1em">
<div id="insCont" class="ta-center p-1em">
	<div id="appDesc"><p class="m-0 mt-10 px-5 c-gray1">Computer Based Test Application</p></div>
	<h3 class="p-05em brad5" style="background:var(--col-12)">Anda sudah logout.<br/>Terimakasih telah berpartisipasi dalam Ujian</h3>
	<p><a href="index.php">Apabila ingin kembali login, silakan klik disini</a></p>
</div>
	
</div>
</div>

</div>
</div>
<script>
setTimeout(function(){
	<?php
		echo 'window.location.replace("'.$x[rand(0,20)].'")';
	?>
},3000)
</script>
</body>
</html>