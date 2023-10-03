<?php

$genset = unserialize(file_get_contents('../../shared/config/tmf_general_settings.json'));
/**
 * If true enable USER REGISTRATION.
 */
define('K_USRREG_ENABLED', $genset['userReg']);

/**
 * If true requires email confirmation.
 */
define('K_USRREG_EMAIL_CONFIRM', true);

/**
 * Default user group ID for registered user.
 */
define('K_USRREG_GROUP', 1);

/**
 * URL of an HTML page containing the registration agreement (i.e.: "http://www.example.com/agreement.html").
 */
define('K_USRREG_AGREEMENT', '');

/**
 * The following email will receive copies of verification messages.
 */
define('K_USRREG_ADMIN_EMAIL', '');

/**
 * Regular expression defining the allowed characters for a password
 */
define('K_USRREG_PASSWORD_RE', '^(.{8,})$');

/**
 * Additional fields to display on registration form.
 * Legal values are:
 * 0 = disabled field;
 * 1 = enabled field;
 * 2 = required field;
 */
$regfields = array(
    'user_email' => 2,
    'user_regnumber' => 1,
    'user_firstname' => 2,
    'user_lastname' => 2,
    'user_birthdate' => 1,
    'user_birthplace' => 1,
    'user_ssn' => 1,
    'user_groups' => 1,
    'user_agreement' => 2
);

//============================================================+
// END OF FILE
//============================================================+
