<?php

require_once('../config/tce_config.php');

$pagelevel = 1;
require_once('../../shared/code/tce_authorization.php');

echo '<'.'?xml version="1.0" encoding="'.$l['a_meta_charset'].'"?'.'>'.K_NEWLINE;
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.K_NEWLINE;
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$l['a_meta_language'].'" lang="'.$l['a_meta_language'].'" dir="'.$l['a_meta_dir'].'">'.K_NEWLINE;
echo '<head>'.K_NEWLINE;
echo '<title>LOGIN</title>'.K_NEWLINE;
echo '<meta http-equiv="refresh" content="0;url=index.php" />'.K_NEWLINE; //reload page
echo '</head>'.K_NEWLINE;
echo '<body>'.K_NEWLINE;
echo '<a href="index.php">LOGIN...</a>'.K_NEWLINE;
echo '</body>'.K_NEWLINE;
echo '</html>'.K_NEWLINE;

//============================================================+
// END OF FILE
//============================================================+
