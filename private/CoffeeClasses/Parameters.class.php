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
class Parameters
{
    private $debug = false;
    private $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function setDebug($val)
    {
        $this->debug = $val ? true : false;
        return $this;
    }

    public function get($value)
    {
        if (isset($this->request[$value])) {
            return $this->request[$value] === "" ? null : $this->request[$value];
        } else {
            return null;
        }
    }

    public function getWithDefault($value, $default = null)
    {
        if (isset($this->request[$value])) {
            return $this->get($value);
        } else {
            return $default;
        }
    }

    public function getDate()
    {
        if (isset($_REQUEST["d"])) {
            $date = strtotime($_REQUEST["d"]);
        } else {
            $date = time();
        }
        
        return $date;
    }
}
