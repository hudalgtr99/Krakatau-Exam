<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_ONLINE_USERS;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_online_users'];
$thispage_title_icon = '<i class="pe-7s-signal icon-gradient bg-happy-itmeo"></i> ';
$thispage_help = $l['hp_online_users'];

require_once('../code/tce_page_header.php');
require_once('tce_functions_users_online.php');

// set default values
if (!isset($order_field)) {
    $order_field='cpsession_expiry';
}
if (!isset($orderdir)) {
    $orderdir=0;
}
if (!isset($firstrow)) {
    $firstrow=0;
}
if (!isset($rowsperpage)) {
    $rowsperpage=K_MAX_ROWS_PER_PAGE;
}

F_show_online_users('', $order_field, $orderdir, $firstrow, $rowsperpage);

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
