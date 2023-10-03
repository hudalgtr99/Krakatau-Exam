<?php

require_once('../config/tce_config.php');

$pagelevel = 5;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('tce_functions_filemanager.php');

$thispage_title = 'MS Word to XML Converter';
$thispage_title_icon = '<i class="fas fa-file-word icon-gradient bg-sunny-morning"></i> ';

require_once('../code/tce_page_header.php');

echo '<div class="mb-3">'.K_NEWLINE;

echo '<div class="card">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;
?>

<div class="alert alert-info"><h5>Menu ini sedang dalam pengembangan</h5><p>Menu ini saat ini belum dapat diakses dikarenakan sedang dalam masa pengembangan oleh developer. Mohon tunggu sampai update berikutnya, terima kasih.</p></div>
<?php

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
