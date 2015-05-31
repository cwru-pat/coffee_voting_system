<?php
/* @file
 * 
 * This file implements a class for handling form / URL parameters.
 * 
 */
namespace CoffeeClasses;

/*
 * @var Parameters
 * A class used to access / process parameters.
 */
class CSRFToken
{
    private $token;

    public function __construct()
    {
        if (!isset($_SESSION['CSRFToken'])) {
            $_SESSION['CSRFToken'] = md5(microtime());
        }

        $this->token = $_SESSION['CSRFToken'];
    }

    public function getToken()
    {
        return $this->token;
    }

    public function validateToken($token)
    {
        return $token == $this->token;
    }
}
