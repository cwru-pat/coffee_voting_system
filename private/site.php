<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// php session
session_start();
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
$coffee_conn->setDebug(TRUE);
// To create tables, uncomment:
// $coffee_conn->createTables();
// $result = $coffee_conn->dbQuery("SHOW TABLES");
// var_dump($result);

// global system user object
global $user;
$phpCAS = $config->get("phpCAS");
require_once($phpCAS['location']);
$user = new CoffeeClasses\User();

// global object for handling some URL parameters
global $params;
$params = new CoffeeClasses\Parameters();
