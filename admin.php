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
    $dates = json_decode($params->get("dates"));
    $sorted = usort($dates, "date_sort");
    if(!$dates || !$sorted) {
      print_alert("Error making changes.", "danger");
    } else {
      set_variable("dates", $dates);
      set_variable("admins", $params->get("admins"));
      print_alert("Changes successfully made.", "success");
    }
  }

  $dates = get_variable("dates");
  $admins = get_variable("admins");

  if(!get_variable("admins")) {
    print_alert("Warning: No administrators are defined yet, so everyone has access to this page.", "danger");
  }
  ?>

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
        <a role='button' href="#" class='pull-right add-meeting' id='meeting_add'>
          <span class='glyphicon glyphicon-plus'></span>
        </a>
        <h4 style="margin: 0;">
          Set meeting dates
        </h4>
      </div>
    </div>
    <div class="form-group">
      <label for="admin_ids">Case IDs of Administrators</label>
      <input type="text" class="form-control" id="admin_ids" name="admins" value="<?php print o($admins); ?>" placeholder="Enter a comma-separated list of admin IDs.">
    </div>
    <input type="hidden" id="admin_date_selectors_dates" name="dates" value="<?php print o(json_encode($dates)); ?>">
    <input type="hidden" name="CSRFToken" value="<?php print $token->getToken(); ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php

require_once("private/templates/footer.php");
