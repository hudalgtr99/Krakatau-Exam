<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_PUBLIC_TEST_INFO;
$thispage_title = $l['t_test_info'];
$thispage_description = $l['hp_test_info'];
require_once('../../shared/code/tce_authorization.php');

require_once('../code/tce_page_header_popup.php');

echo '<div class="popupcontainer">'.K_NEWLINE;
if (isset($_REQUEST['testid']) and ($_REQUEST['testid'] > 0)) {
    require_once('../../shared/code/tce_functions_test.php');
    echo F_printTestInfo(intval($_REQUEST['testid']), false);
}

echo '<div class="row">'.K_NEWLINE;
require_once('../../shared/code/tce_functions_form.php');
echo F_close_button();
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer_popup.php');

//============================================================+
// END OF FILE
//============================================================+
