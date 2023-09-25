<?php
//============================================================+
// File name   : tce_page_footer.php
// Begin       : 2001-09-02
// Last Update : 2009-09-30
//
// Description : Outputs default XHTML page footer.
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
//    Copyright (C) 2004-2010  Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Outputs default XHTML page footer.
 * @package com.tecnick.tcexam.public
 * @author Nicola Asuni
 * @since 2001-09-02
 */

/**
 */

echo K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div ContainerWrapper
echo '</div>'.K_NEWLINE; //close div.body
echo '<div id="footer"';
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1 and strlen(LOGIN_BG_IMAGE)>0){
	echo ' style="background:var(--col-7t)"';
}
echo '>'.K_NEWLINE;
include('../../shared/code/tce_page_userbar.php'); // display user bar
echo '</div>'.K_NEWLINE; //close div#footer
echo '<!-- '.base64_decode(K_KEY_SECURITY).' -->'.K_NEWLINE;


//echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'main.js"></script>'.K_NEWLINE;
// echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'plugins.min.js"></script>'.K_NEWLINE;
echo '<script src="'.K_SITE_PLUGIN_SCRIPT.'"></script>'.K_NEWLINE;
?>
<script>
	//Start - Script Anti Iframe
	if (top.location != self.location) {
	  top.location = self.location
	}
	
	//atau gunakan di bawah ini
	//if (parent.frames.length > 0) { parent.location.href = location.href; }
	//source: http://kolom-tutorial.blogspot.com/2010/04/script-anti-iframe.html
	//End - Script Anti Iframe
</script>
<?php
if(isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1){
if(strlen(K_CLIENTUA)>0){	
?>
	  <script>
		const browser = bowser.getParser(window.navigator.userAgent);
		const isValidBrowser = browser.satisfies({<?php echo K_CLIENTUA; ?>:"><?php echo K_CLIENTVER; ?>"});
		if(!isValidBrowser){
			document.querySelector(".login_box").setAttribute("style","border-left:5px solid var(--col-10);padding:1em!important");
			// document.querySelector(".login_box").innerHTML = "<center><img src='../../images/chrome-logo.png' /><br/>Anda harus menggunakan dan memperbarui <b>Chrome</b> untuk mengakses aplikasi Ujian.<br/><br/>Silakan install <b>Chrome</b> terbaru terlebih dahulu melalui toko aplikasi sistem operasi Anda masing-masing.</center>";
			document.querySelector(".login_box").innerHTML = "<?php echo K_CLIENTBLCKMSG; ?>";
		}
		</script>
	  <?php
}
}

if(CLEAR_LS_ONLOGIN and isset($_SESSION['session_user_level']) and $_SESSION['session_user_level']<1){
	echo '<script>'.K_NEWLINE;
	echo '	clearStorage();'.K_NEWLINE;
	echo '</script>'.K_NEWLINE;
}
echo '<!-- </body></html> -->'.K_NEWLINE;
echo '</body>'.K_NEWLINE;
echo '</html>';

//============================================================+
// END OF FILE
//============================================================+
