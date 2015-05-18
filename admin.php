<?php

$page_id = "page_admin";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

if(!$user->isAdmin()) {
?>
<div class="container">
  <h1>Invalid access.</h1>
</div>
<?php
require_once("private/templates/footer.php");
} 

$dates = "";
$admins = "";

?>
<div class="container">
  <h1>Coffee Discussion Settings</h1>
  <form>
    <div class="form-group">
      <label for="discussion_dates">Discussion Dates</label>
      <input type="text" class="form-control" id="discussion_dates" value="<?php print $dates; ?>" placeholder="Something about dates.">
    </div>
    <div class="form-group">
      <label for="admin_ids">Case IDs of Administrators</label>
      <input type="text" class="form-control" id="admin_ids" value="<?php print $admins; ?>" placeholder="Enter a comma-separated list of admin IDs.">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
<?php

require_once("private/templates/footer.php");
