<?php

require_once "private/site.php";

$password = $params->get("password");
$guest_pass = get_variable("guest_pass");
if($params->get("login")=="fail") {
    $errPass = "Incorrect Password";
} else {
    $errPass = "&nbsp;";
}


if ($password==$guest_pass) {
        $user->guestAuthenticate();
        header("Location: " . path());
} else {
        $login = "fail";
}

if ($user->isLoggedIn()) {
    
    include_once "private/templates/header.php";
    include_once "private/templates/navbar.php";
    ?>

    <div class="container">
        <h1>You are currently signed in.</h1>
    </div>

    <?php
    include_once "private/templates/footer.php";
} else {
    
    include_once "private/templates/header.php";
    include_once "private/templates/navbar.php";
    ?>
    
    <div class="container">
        <h1>Enter guest password.</h1>
        <form method="post" action="guest?login=<?php echo $login?>">
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <?php 
                     echo "<p class='text-danger'>$errPass</p>"
                ?>
            </div>
            <button type="submit" value="submit1" class="btn btn-primary">Sign In</button>
        </form>
    </div>

    <?php
    include_once "private/templates/footer.php";
}