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
    private $debug = FALSE;
    private $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function setDebug($val)
    {
        $this->debug = $val ? TRUE : FALSE;
        return $this;
    }

    public function get($value)
    {
        if(isset($this->request[$value])) {
            return $this->request[$value] === "" ? NULL : $this->request[$value];
        } else {
            return NULL;
        }
    }

    public function getDate()
    {
        if(isset($_REQUEST["d"])) {
            $date = strtotime($_REQUEST["d"]);
        } else {
            $date = time();
        }
        
        return $date;
    }    
}
