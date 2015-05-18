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
    protected $conn = NULL;

    public function __construct($conn)
    {
        if(isset($_SESSION['id']) && $_SESSION['id']) {
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

    public function isUser($id)
    {
        if($id && $id == $this->id) {
            return true;
        }

        return false;
    }

    public function isAdmin()
    {
        $admins = $this->conn->dbQuery("SELECT * FROM variables WHERE name='admins'");

        // Let anyone admin if there are none set
        if(!$admins) {
            return true;
        }

        // anyone is an admin if there is malformed db data
        $admins = unserialize($admins[0]);
        if(!$admins) {
            return true;
        }

        // otherwise, restrict admins
        if(isset($admins[$this->id])) {
            return true;
        }

        return false;
    }

    public function id()
    {
        return $this->id;
    }
}
