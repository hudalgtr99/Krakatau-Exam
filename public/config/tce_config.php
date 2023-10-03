<?php

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../config/tce_auth.php');
require_once('../../shared/config/tce_config.php');

// --- DEFAULT META TAGS -------------------------------------------------------

/**
 * Default site name.
 */
$genset = unserialize(file_get_contents('../../shared/config/tmf_general_settings.json'));

define('K_SITE_TITLE', urldecode($genset['siteName']));

/**
 * Default site description.
 */
define('K_SITE_DESCRIPTION', urldecode($genset['siteDesc']));

/**
 * Default site author.
 */
define('K_SITE_AUTHOR', urldecode($genset['siteAuthor']));

/**
 * Default html reply-to meta tag.
 */
define('K_SITE_REPLY', urldecode($genset['siteReplyTo'])); //

/**
 * Default keywords.
 */
define('K_SITE_KEYWORDS', urldecode($genset['siteKeyword']));

/**
 * Path to default html icon.
 */
define('K_SITE_ICON', K_PATH_HOST.K_PATH_TCEXAM.'a2hs/favicon.ico');

/**
 * Path to JS Plugin Script.
 */
define('K_SITE_PLUGIN_SCRIPT', K_PATH_SHARED_JSCRIPTS.'plugins.ajax-json-cache-api-loadall.js?07042021');

/**
 * Path to Timer Plugin Script.
 */
define('K_SITE_TIMER_SCRIPT', K_PATH_SHARED_JSCRIPTS.'timer.min.js?07042021');

/**
 * Path to public CSS stylesheet.
 */
define('K_SITE_STYLE', K_PATH_STYLE_SHEETS.'default.min.css?07042021');

/**
 * Full path to CSS stylesheet for RTL languages.
 */
define('K_SITE_STYLE_RTL', K_PATH_STYLE_SHEETS.'default_rtl.min.css?18062021130300');

/**
* Specify background image url, position, size, and blend mode on login screen
*/
// if you want disable background image on login screen, just give it blank value like this
// define('LOGIN_BG_IMAGE','');
// define('LOGIN_BG_IMAGE','https://source.unsplash.com/z_qdiCJXVAE/1600x900');
define('LOGIN_BG_IMAGE',$genset['loginBg']);

//reference https://www.w3schools.com/cssref/pr_background-position.asp
define('LOGIN_BG_IMAGE_POSITION',$genset['loginBgPosition']);

// reference https://www.w3schools.com/cssref/css3_pr_background-size.asp
define('LOGIN_BG_IMAGE_SIZE',$genset['loginBgSize']);

// reference https://www.w3schools.com/cssref/pr_background-blend-mode.asp
define('LOGIN_BG_IMAGE_BLEND_MODE',$genset['loginBgBlend']);


// --- OPTIONS / COSTANTS ------------------------------------------------------
/**
* Generate Question Block (testlogid) in JSON File when first question load on server side
*/
define('GENSS_QBLOCK_JSON', $genset['SSGenJSON']);

/**
* Triggering load all cache after generating JSON File from server side
*/
define('TRIGSS_CACHE_ALL', $genset['triggerCacheAllFromServer']);

/**
* Clear local storage on Login
*/
define('CLEAR_LS_ONLOGIN', $genset['clearStorageOnLogin']);

/**
* QUESTION BLOCK (Question Description and Answer Description stored in JSON File after displayed on client side)
*/
define('QBLOCK_JSON', $genset['jsonFile']);

/**
* Load All JSON Files to be cached on question form load
*/
define('LOAD_ALL_JSON', $genset['createAllJsonFileOnStartup']);

/**
* Disable or enable Cache feature on client (Use Javascript Cache API)
*/
define('CACHE_FEATURE', $genset['cacheFeature']);

/**
* Disable or enable delay on first starting test
*/
define('K_ENABLE_DELAY', $genset['enable_delay']);

/**
* Message warning if Javascript disabled
*/
define('K_JSWARN', urldecode($genset['jsWarn']));

/**
* Default Font for public area
*/
define('K_DEFFONT', $genset['defFont']);

/**
* client user agent
*/
define('K_CLIENTUA', $genset['clientUA']);

/**
* client user agent
*/
define('K_CLIENTVER', $genset['clientVer']);

/**
* client blocked message
*/
define('K_CLIENTBLCKMSG', urldecode($genset['clientDisMsg']));

/**
 * Max number of rows to display in tables.
 */
define('K_MAX_ROWS_PER_PAGE', 50);

/**
 * Max file size to be uploaded [bytes].
 */
define('K_MAX_UPLOAD_SIZE', 1000000);

/**
 * Max memory limit for a PHP script.
 */
define('K_MAX_MEMORY_LIMIT', '32M');

/**
 * Main page (homepage).
 */
define('K_MAIN_PAGE', 'index.php');

/**
 * Enable PDF results on public area.
 */
define('K_ENABLE_PUBLIC_PDF', $genset['PDFResult']);

/**
 * Custom page after user stopping the test
 * empty to disable
 */
define('K_ENDTEST_PAGE', $genset['endtest_page']);

/**
 * Show Terminate button only when all answered.
 */
define('K_SHOW_TERMINATE_WHEN_ALL_ANSWERED', $genset['show_terminate_when_all_answered']);

/**
 * Show Terminate button only when all answered.
 */
define('K_ALLOW_SUBMIT_AFTER', $genset['allow_submit_after']);

/**
 * Show Save Button.
 */
define('K_SHOW_SAVE_BUTTON', $genset['show_save_button']);

/**
 * Enable Multi Login.
 */
define('K_ENABLE_MULTI_LOGIN', $genset['enableMultiLogin']);

/**
 * If true hide the expired tests from index table.
 */
define('K_HIDE_EXPIRED_TESTS', $genset['hideExpTest']);

/**
 * If true enable WYSIWYG BBCode editor in Public Area.
 */
define('K_WYSIWYG_BBCODE',true);

/**
 * If true enable file upload feature in textarea on Public Area.
 */
define('K_PUBLIC_FILE_UPLOAD',true);

/**
 * If true show basic score on question list
 */
define('K_SHOW_BASIC_SCORE',false);

/**
 * If true show question description on question list
 */
define('K_SHOW_QDESC',false);

/**
 * If true enable pagehelp on Public Area.
 */
define('K_PUBLIC_PAGEHELP',$genset['pubPageHelp']);

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../../shared/config/tce_db_config.php');
require_once('../../shared/code/tce_db_connect.php');
require_once('../../shared/code/tce_functions_general.php');

// --- PHP SETTINGS ------------------------------------------------------------

ini_set('memory_limit', K_MAX_MEMORY_LIMIT); // set PHP memory limit
ini_set('session.use_trans_sid', 0); // if =1 use PHPSESSID (for clients that do not support cookies)

//============================================================+
// END OF FILE
//============================================================+
