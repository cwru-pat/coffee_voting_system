<?php

$page_id = "page_admin";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

if(!$user->isAdmin() || !$user->isLoggedIn()) {
  ?>
  <div class="container">
    <h1>Invalid access.</h1>
  </div>
  <?php
  require_once("private/templates/footer.php");
  die();
}
?>
<div class="container">
  <?php
  if($token->validateToken($params->get("CSRFToken"))) {
    set_variable("dates", $params->get("dates"));
    set_variable("admins", $params->get("admins"));
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        Changes successfully made.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <?php
  }

  $dates = get_variable("dates");
  $admins = get_variable("admins");
  ?>

  <?php if(!get_variable("admins")) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        Warning: No administrators are defined yet, so everyone has access to this page.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php } ?>

  <h1>Coffee Discussion Settings</h1>
  <form method="POST">
    <div class="form-group">
      <label for="discussion_dates">Discussion Dates</label>
      <input type="text" class="form-control" id="discussion_dates" name="dates" value="<?php print o($dates); ?>" placeholder="Something about dates.">
    </div>
    <div class="form-group">
      <label for="admin_ids">Case IDs of Administrators</label>
      <input type="text" class="form-control" id="admin_ids" name="admins" value="<?php print o($admins); ?>" placeholder="Enter a comma-separated list of admin IDs.">
    </div>
    <input type="hidden" name="CSRFToken" value="<?php print $token->getToken(); ?>">
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
<?php

require_once("private/templates/footer.php");
