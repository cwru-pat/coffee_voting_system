<?php

$page_id = "page_admin";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

if(!$user->isLoggedIn()) {
  ?>
  <div class="container">
    <h1>Invalid access.</h1>
  </div>
  <?php
  require_once("private/templates/footer.php");
  die();
}

$title = "";
$body = "";
$subject = "Custom";

?>
<div class="container">
  <h1>Add New Content</h1>

</div>
<?php

require_once("private/templates/footer.php");
