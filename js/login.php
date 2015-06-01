<?php

require_once __dir__."/../private/site.php";
$coffee_conn->setDebug(false);

if ($user->isLoggedIn()) {
    print json_encode(
        array(
        "isLoggedIn" => 1,
        )
    );
} else {
    print json_encode(
        array(
        "isLoggedIn" => 0,
        )
    );
}
