<?php
/* @file
 * 
 * This file contains a class which can be used for accessing configuration settings.
 * 
 */
namespace CoffeeClasses;

/*
 * @var configurationData
 *
 * Available methods:
 *  - get($val): returns a stored setting value.
 *  - validateInstall: performs some basic checks seeing whether or not the install is valid.
 *
 */
class ConfigurationData
{
    // For now, data is just an array containing configuration settings.
    protected $data = null;

    public function __construct()
    {
        // up a directory... no trailing slash here.
        $includes_directory = dirname(__file__) . "/..";
        // expect an associated .config.php file
        include_once $includes_directory . "/.config.php";

        if (!isset($config) || empty($config)) {
            trigger_error("Config settings not found!", E_USER_ERROR);
        }
        $config["includes_directory"] = $includes_directory;

        // append trailing slash to paths if needed
        if (substr($config["includes_directory"], -1) != "/") {
            $config["includes_directory"] .= "/";
        }

        $this->data = $config;
    }

    public function get($value)
    {
        if (isset($this->data[$value])) {
            return $this->data[$value];
        }
        trigger_error("Config setting not found!", E_USER_WARNING);
    }

    public function validateInstall()
    {
        // Perform some validation of system installation here.
        $includes_directory = $this->data["includes_directory"];
        $errors = array();

        // check for .htaccess protection
        if (!file_exists($includes_directory . '.htaccess')) {
            $errors[] = ".htaccess protection of admin section missing!";
        }

        return $errors;
    }
}
