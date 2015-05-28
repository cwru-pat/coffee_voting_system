<?php

require_once("../private/site.php");
$coffee_conn->setDebug(FALSE);

if($user->isLoggedIn()) {
  print json_encode(array(
    "isLoggedIn" => 1,
  ));
} else {
  print json_encode(array(
    "isLoggedIn" => 0,
  ));
}
