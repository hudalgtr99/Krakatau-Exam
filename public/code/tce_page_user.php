<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_PAGE_USER;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['w_user'];
$thispage_title_icon = '<i class="fas fa-user"></i>';
require_once('../code/tce_page_header.php');

echo '<div class="container">'.K_NEWLINE;

// print submenu
echo '<ul>'.K_NEWLINE;
foreach ($menu['tce_page_user.php']['sub'] as $link => $data) {
    echo F_menu_link($link, $data, 1);
}
echo '</ul>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
