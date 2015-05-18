<?php

$page_id = "page_home";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");
require_once("private/templates/jumbotron.php");

?>
<div class="container">
  <div class="row">

    <div class="col-sm-3">

      <div class="sidebar-module sidebar-module-inset">
        <?php require_once("private/templates/calendar.php"); ?>
      </div>

      <div class="sidebar-module sidebar-module-inset">
        <?php require_once("private/templates/togglelist.php"); ?>
      </div>

    </div>

    <div class="col-sm-9">
      <?php require_once("private/templates/feed.php"); ?>
    </div>

  </div>
</div>


<?php
require_once("private/templates/footer.php");
