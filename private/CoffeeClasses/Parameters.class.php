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

    public function getStartDate()
    {
        if (isset($_REQUEST["ds"])) {
            $date = strtotime($_REQUEST["ds"]);
        } else {
            //$paper_meeting_times = get_adjacent_meeting_times("end", true /* Get *only* meeting times where papers will be discussed */);
            //$date = date("Y-m-d H:i", $paper_meeting_times["prev"]);
            $date = time();
        }
        return $date;
    }

    public function getEndDate()
    {
        if (isset($_REQUEST["de"])) {
            $date = strtotime($_REQUEST["de"]);
        } else {
            $date = time();
        }
        return $date;
    }
}
