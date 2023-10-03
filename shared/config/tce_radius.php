<?php

/**
 * If true enable RADIUS.
 */
define('K_RADIUS_ENABLED', false);

/**
 * IP address of the radius server (e.g.: "127.0.0.1").
 */
define('K_RADIUS_SERVER_IP', 'localhost');

/**
 * Shared secret with the radius server.
 */
define('K_RADIUS_SHARED_SECRET', 'WinRadius');

/**
 * Radius domain name suffix (e.g.: "@mydomain.com").
 */
define('K_RADIUS_SUFFIX', '');

/**
 * Radius UDP timeout (e.g.: 5).
 */
define('K_RADIUS_UDP_TIMEOUT', 5);

/**
 * Radius authentication port (e.g.: 1812).
 */
define('K_RADIUS_AUTHENTICATION_PORT', 1812);

/**
 * Radius accounting port (e.g.: 1813).
 */
define('K_RADIUS_ACCOUNTING_PORT', 1813);

/**
 * Set to true if RADIUS uses UTF-8 encoding.
 */
define('K_RADIUS_UTF8', true);

/**
 * Default user level.
 */
define('K_RADIUS_USER_LEVEL', 1);

/**
 * Default user group ID.
 * This is the TCExam group id to which the radius accounts belongs.
 * You can also set 0 for all available groups or a string containing a comma-separated list of group IDs.
 */
define('K_RADIUS_USER_GROUP_ID', 1);

//============================================================+
// END OF FILE
//============================================================+
