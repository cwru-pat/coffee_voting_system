<?php
/* @file
 * 
 * This file contains a class for letting people log in via phpCAS.
 * 
 */
namespace CoffeeClasses;

/*
 * @var User
 *
 * Available methods:
 *  - get($val): returns a stored setting value.
 *  - validateInstall: performs some basic checks seeing whether or not the install is valid.
 *
 */
class User
{
    // For now, data is just an array containing configuration settings.
    protected $id = NULL;

    public function __construct()
    {
        if(isset($_SESSION['id']) && $_SESSION['id']) {
            $this->id = $_SESSION['id'];
        }
    }

    public function authenticate()
    {
        // attempt to authenticate.
        \phpCAS::client(CAS_VERSION_2_0, 'login.case.edu', 443, '/cas');
        \phpCAS::setNoCasServerValidation();
        \phpCAS::forceAuthentication();
        $user = \phpCAS::getUser();

        $_SESSION['id'] = $user;
        $this->id = $user;

        return $this;
    }

    public function deAuthenticate()
    {
        $_SESSION['id'] = NULL;
        $this->id = NULL;

        return $this;
    }

    public function isLoggedIn()
    {
        if($this->id) {
            return true;
        }

        return false;
    }

    public function id()
    {
        return $this->id;
    }
}
