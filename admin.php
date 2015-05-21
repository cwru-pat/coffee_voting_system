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
        <a role="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>
    </div>
    <?php
  }

  $dates = get_variable("dates");
  $admins = get_variable("admins");
  ?>

  <?php if(!get_variable("admins")) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        Warning: No administrators are defined yet, so everyone has access to this page.
        <a role="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>
    </div>
  <?php } ?>

  <h1>Coffee Discussion Settings</h1>
  <h2>Administrative Tasks</h2>
  <p>
    <?php 
      $num_papers = $coffee_conn->dbQuery("SELECT count(*) as num FROM papers");
      $num_votes = $coffee_conn->dbQuery("SELECT count(*) as num FROM votes");
      $num_users = $coffee_conn->dbQuery("SELECT count(DISTINCT userId) as num FROM votes");
    ?>
    Currently storing <strong><?php print $num_papers[0]->num; ?></strong> paper abstracts.
    Tracking <strong><?php print $num_votes[0]->num; ?></strong> votes from
    <strong><?php print $num_users[0]->num; ?></strong> users.
  </p>
  <form method="POST" action="cron.php">
    <button type="submit" class="btn btn-default">
      <span class="glyphicon glyphicon-import" aria-hidden="true"></span>
      Import &amp; Expire Papers
    </button>
  </form>
  <h2>Settings</h2>
  <form method="POST">
    <div class="list-group" id="admin_date_selectors">
      <div class="list-group-item list-group-item-info">
        <a role='button' class='pull-right' id='meeting_add'>
          <span class='glyphicon glyphicon-plus text-success'></span>
        </a>
        <h4 style="margin: 0;">
          Set meeting dates
          <span role="button" class="close meeting-btn" id="meeting_add"></span>
        </h4>
      </div>
    </div>
    <div class="form-group">
      <label for="admin_ids">Case IDs of Administrators</label>
      <input type="text" class="form-control" id="admin_ids" name="admins" value="<?php print o($admins); ?>" placeholder="Enter a comma-separated list of admin IDs.">
    </div>
    <input type="hidden" id="admin_date_selectors_dates" name="dates" value="<?php print o($dates); ?>">
    <input type="hidden" name="CSRFToken" value="<?php print $token->getToken(); ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php

require_once("private/templates/footer.php");
