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
 * output default XHTML page footer
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2001-09-02
 */

/**
 */

$static_test_lists = false;

echo K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div.content
echo '</div>'.K_NEWLINE; //close div.body

//include('../../shared/code/tce_page_userbar.php'); // display user bar
//echo '<!-- '.base64_decode(K_KEY_SECURITY).' -->'.K_NEWLINE;
if(f_sc_name("tce_show_result_allusers.php")){
echo '<div id="footer_cetak" style="text-align:right">';
echo "......................................., ".date("d M Y");
echo "<br/><br/><br/><br/><br/>".F_getFirstName($_SESSION["session_user_firstname"]);
}
if($static_test_lists){
?>

<!--script>
 window.addEventListener('load', e => {
  // new PWAConfApp();
  registerSW(); 
});

async function registerSW(){
  if ('serviceWorker' in navigator) { 
    try {
      await navigator.serviceWorker.register('./sw.js'); 
    } catch (e) {
      console.log('ServiceWorker gagal ditambahkan.'); 
    }
  } else {
    console.log('Browser Anda TIDAK mendukung ServiceWorker'); 
  }
}

// let url = location.href;
// let filename = url.split('/').pop();
// localStorage.setItem('fn',filename);	
// console.log(location.href);

 </script-->
<?php
}

echo '</body>'.K_NEWLINE;
echo '</div>';
echo '<div id="footer"><p><a class="ft-fuchsia" href="https://www.tcexam.org">TCExam</a> ver 13.3.0 - Copyright &copy; 2004-2016 Nicola Asuni - <a class="ft-fuchsia" href="https://www.tecnick.com">Tecnick.com LTD</a></p></div>'.K_NEWLINE;
/**
?>
<script>
var divBodyHgT = parseInt($("div#scrollayer-mod").css("height"));
var bodyHgT = divBodyHgT+125;
$("body").css("height",bodyHgT+"px");
$(window).on("resize", function(){
	var divBodyHgT = parseInt($("div#scrollayer-mod").css("height"));
	var bodyHgT = divBodyHgT+125;
	$("body").css("height",bodyHgT+"px");
})
</script>
<?php
**/
echo '</html>';

//============================================================+
// END OF FILE
//============================================================+