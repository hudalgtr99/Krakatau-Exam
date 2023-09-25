<?php
require_once('../config/tce_config.php');

$pagelevel = K_AUTH_PUBLIC_TEST_EXECUTE;
$thispage_title = $l['t_test_execute'];
$thispage_title_icon = '';
$thispage_description = $l['hp_test_execute'];
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_test.php');


$test_id = 0;


if (isset($_GET['testid']) and ($_GET['testid'] > 0)) {
    $test_id = intval($_GET['testid']);
		$test_name = F_getTestName($test_id);
        $thispage_title .= ': '.F_getTestName($test_id);

       require_once('../code/tce_page_header.php');
echo '<div id="containerWrapper" class="container bg-white brad5 p-1em ta-center">Anda telah menyelesaikan ujian <span class="d-iblock ft-bold">'.$test_name.'</span>';
?>
<style>#footer{display:none}</style>
<div class="row btn-action">
<a href="index.php" class="xmlbutton"><span class="icon-home-outline"></span> Kembali ke beranda</a>
<!--a style="background:var(--col-10);color:var(--col-7)" href="tce_logout.php" class="xmlbutton"><span class="icon-switch"></span> logout</a></div-->
<?php
echo '</div>'.K_NEWLINE; // container

require_once('../code/tce_page_footer.php');
}
//============================================================+
// END OF FILE
//============================================================+
