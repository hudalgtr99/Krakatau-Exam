<?php

require_once('../../shared/code/tce_functions_svg_graph.php');

// points to graph (values between 0 and 100)
if (isset($_REQUEST['p'])) {
    $p = $_REQUEST['p'];
} else {
    exit;
}
// graph width
if (isset($_REQUEST['w'])) {
    $w = intval($_REQUEST['w']);
} else {
    $w = '';
}
// graph height
if (isset($_REQUEST['h'])) {
    $h = intval($_REQUEST['h']);
} else {
    $h = '';
}

F_getSVGGraph($p, $w, $h);

//============================================================+
// END OF FILE
//============================================================+
