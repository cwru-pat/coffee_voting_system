<?php
require_once __dir__."/../private/site.php";

$coffee_conn->setDebug(false);

// only want to return one short message.
$message = array();

// don't really care about CSRF here.
$query = "SELECT DISTINCT DATE(date) as 'date' FROM papers";
$result = $coffee_conn->dbQuery($query);

$dates = array();
foreach ($result as $date) {
    $dates[] = $date->date;
}
print json_encode($dates);
