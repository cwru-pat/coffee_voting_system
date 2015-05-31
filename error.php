<?php
header("HTTP/1.0 404 Not Found");

require_once("private/site.php");
require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

?>

<div class="jumbotron">
  <div class="container">
    <h1 class="text-center">
      <br>
      Page not found.<br><br>
      <i class='fa fa-coffee'></i>
    </h1>
  </div>
</div>

<?php
require_once("private/templates/footer.php");
