<?php

/**
 * If true enable CAS
 */
define('K_CAS_ENABLED', false);

/**
 * Version of CAS protocol to use.
 * Defaults to CAS_VERSION_2_0
 */
define('K_CAS_VERSION', '2.0');

/**
 * CAS server hostname.
 */
define('K_CAS_HOST', '');

/**
 * The port to connect to.
 * Defaults to 443
 */
define('K_CAS_PORT', 443);

/**
 * The location on the webserver where the CAS application is hosted.
 * Some setups don't place the CAS application in the webserver's root
 * directory and we can specify where to find the CAS application.
 * Default is ''.
 */
define('K_CAS_PATH', '/cas');

/**
 * Default user level
 */
define('K_CAS_USER_LEVEL', 1);

/**
 * Default user group ID
 * This is the TCExam group ID to which the CAS accounts belongs.
 * You can also set 0 for all available groups or a string containing a comma-separated list of group IDs.
 */
define('K_CAS_USER_GROUP_ID', 1);

//============================================================+
// END OF FILE
//============================================================+
