<?php
/**
 * Sample configuration file for Anax webroot.
 *
 */


/**
 * Define essential Anax paths, end with /
 *
 */
define('ANAX_INSTALL_PATH', realpath(__DIR__ . '/../../Anax-MVC/') . '/');
define('ANAX_APP_PATH', realpath(__DIR__ . '/../') . '/app/');

//define('ANAX_APP_PATH', ANAX_INSTALL_PATH . '../kmom04/app/');


/**
 * Include autoloader.
 *
 */
include(ANAX_APP_PATH . 'config/autoloader.php');



/**
 * Include global functions.
 *
 */
include(ANAX_INSTALL_PATH . 'src/functions.php');
