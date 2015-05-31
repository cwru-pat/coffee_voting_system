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
    protected $id = null;
    protected $conn = null;

    public function __construct($conn)
    {
        if (isset($_SESSION['id']) && $_SESSION['id']) {
            $this->id = $_SESSION['id'];
        }

        $this->conn = $conn;
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
        $_SESSION['id'] = null;
        $this->id = null;

        return $this;
    }

    public function isLoggedIn()
    {
        if ($this->id) {
            return true;
        }

        return false;
    }

    public function isUser($id)
    {
        if ($id && $id == $this->id) {
            return true;
        }

        return false;
    }

    public function isAdmin()
    {
        $admins = get_variable("admins");

        // Let anyone admin if there are none set
        if (!$admins) {
            return true;
        }

        // separate CSV list
        $admins = explode(",", $admins);
        // trim any whitespace around ids
        $admins = array_map("trim", $admins);
        // set IDs as array keys
        $admins = array_fill_keys($admins, true);

        // otherwise, restrict admins
        if (isset($admins[$this->id])) {
            return true;
        }

        return false;
    }

    public function id()
    {
        return $this->id;
    }
}
