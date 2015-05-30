<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// php session
session_start();
// constants
require_once(__DIR__ . "/constants.php");
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
