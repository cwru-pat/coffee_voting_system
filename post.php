<?php

$page_id = "page_admin";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

$postId = $params->get("paper-id");

if($params->get("import-id")) {
  // TODO: import posts
  print "<div class='container'>
          <div class='alert alert-danger' role='alert'>
            Your post wasn't imported because no code exists to import it yet.
          </div>
        </div>";
  // reset $postId at the end to the newly imported post?

}

$post = $coffee_conn->boundQuery("SELECT * FROM papers WHERE id = ?", array('i', &$postId));
if(count($post) == 0) { 
  kill_script("Post not found.");
} else {
  ?>
  <div class="container">
    <!-- <div class="row"> -->
      <?php
        $paper = $post[0];
        require_once('private/templates/paper.php');
      ?>
    <!-- </div> -->
  </div>
  <?php
}

require_once("private/templates/footer.php");
