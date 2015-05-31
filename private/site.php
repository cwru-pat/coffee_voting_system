<?php
// php session
session_start();

// constants
require_once(__DIR__ . "/constants.php");

// Log all errors but do not display
error_reporting(E_ALL);
ini_set("display_errors", '0');
ini_set("log_errors", '1');
ini_set("error_log", PHP_LOG_FILE);

// phpCAS needs these variables set or it throws notices.
if( !isset($_SERVER['HTTP_HOST']) ) {
  $_SERVER['HTTP_HOST'] = 'localhost';
}
if( !isset($_SERVER['REQUEST_URI']) ) {
  $_SERVER['REQUEST_URI'] = '';
}
if( !isset($_SERVER['SERVER_PORT']) ) {
  $_SERVER['SERVER_PORT'] = '80';
}

// autoloader for Coffee classes
require_once(__DIR__ . "/CoffeeClasses/autoload.php");
// Misc. functions.
require_once(__DIR__ . "/functions.php");

// global system configuration settings
global $config;
$config = new CoffeeClasses\ConfigurationData();
$installation_errors = $config->validateInstall();
foreach($installation_errors as $error) {
  trigger_error("Config settings not found!", E_USER_ERROR);
}

// global system DB connection
global $coffee_conn;
$coffee_conn = new CoffeeClasses\DBConn($config->get("database"));
$coffee_conn->createTables();
// Enabling query debugging will cause output that will ruin json returns in ajax calls.
$coffee_conn->setDebug(FALSE);

// global system user object
global $user;
$phpCAS = $config->get("phpCAS");
require_once($phpCAS['location']);
$user = new CoffeeClasses\User($coffee_conn);

// global object for handling some URL parameters
global $params;
$params = new CoffeeClasses\Parameters();

// re-usable CSRF prevention token
$token = new CoffeeClasses\CSRFToken();

// set default arxivs
if(!get_variable("arxivs")) {
  set_variable("arxivs", unserialize(DEFAULT_ARXIVS_SERIALIZED));
}
// set default expiration date
if(!strtotime(get_variable("expire_date"))) {
  set_variable("expire_date", DEFAULT_EXPIRATION_DATESTRING);
}
