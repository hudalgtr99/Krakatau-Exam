<?php
//============================================================+
// Description : Define access levels for each public page
//               Note:
//                0 = Anonymous user (uregistered user)
//                1 = registered user
//                5 = supervisor user
//                6 = teacher user
//               10 = System Administrator
// ************************************************************
// SECURITY WARNING :
// SET THIS FILE AS READ ONLY AFTER MODIFICATIONS
// ************************************************************


/**
 * Required user's level to access index page.
 */
define('K_AUTH_PUBLIC_INDEX', 1);

/**
 * Required user's level to execute a test
 */
define('K_AUTH_PUBLIC_TEST_EXECUTE', 1);

/**
 * Required user's level to view test general information
 */
define('K_AUTH_PUBLIC_TEST_INFO', 1);

/**
 * Required user's level to view test results
 */
define('K_AUTH_PUBLIC_TEST_RESULTS', 1);

/**
 * Required user's level to access user page submenu
 */
define('K_AUTH_PAGE_USER', 1);

/**
 * Required user's level to change email
 */
define('K_AUTH_USER_CHANGE_EMAIL', 1);

/**
 * Required user's level to change password
 */
define('K_AUTH_USER_CHANGE_PASSWORD', 1);

/**
 * Required user's level to display a link for administration area
 */
define('K_ADMIN_LINK', 5);

/**
 * Minimum page level for which a valid client SSL certificate is required.
 * Use false or a level above 10 to disable the control.
 * Use 0 to enable for all area.
 * Use 10 to enable just for the ADMIN pages.
 */
define('K_AUTH_SSL_LEVEL', false);

/**
 * Comma separated lit of SSL certificates IDs required to
 * access pages with K_AUTH_SSL_LEVEL level or more.
 */
define('K_AUTH_SSLIDS', '');

//============================================================+
// END OF FILE
//============================================================+
