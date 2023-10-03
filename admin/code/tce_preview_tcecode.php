<?php

require_once('../config/tce_config.php');
$pagelevel = K_AUTH_ADMIN_TCECODE;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = '';

require_once('../code/tce_page_header_popup.php');

require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_form.php');
$tcexamcode = str_replace('+', '~#PLUS#~', $_REQUEST['tcexamcode']);
$tcexamcode = stripslashes(urldecode($tcexamcode));
$tcexamcode = str_replace('~#PLUS#~', '+', $tcexamcode);
echo F_decode_tcecode($tcexamcode);

echo '<hr />'.K_NEWLINE;

echo F_close_button();

require_once('../code/tce_page_footer_popup.php');

//============================================================+
// END OF FILE
//============================================================+
