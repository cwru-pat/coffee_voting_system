<?php

require_once("private/site.php");

if($params->get("logout")) {
    $user->deAuthenticate();
} else {
    $user->authenticate();
}

if($user->isLoggedIn()) {
    header("Location: " . path());
} else {
    require_once("private/templates/header.php");
    require_once("private/templates/navbar.php");
    ?>

      <div class="container">
        <h1>You are currently signed out.</h1>
      </div>

    <?php
    require_once("private/templates/footer.php");
}

