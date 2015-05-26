<?php

$page_id = "page_admin";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");

if(!$user->isLoggedIn()) {
  kill_script("Please log in to access this page.");
}

// default to $params vals (what is in $_REQUEST)
$post_title = $params->get("post-title");
$post_body = $params->get("post-body");

// if someone is trying to edit a post, check permissions, and provide different defaults.
if($params->get("post-id")) {

  $post_id = $params->get("post-id");
  $post_details = $coffee_conn->boundQuery(
    "SELECT * FROM papers WHERE id = ?",
    array('i', &$post_id)
  );

  if(count($post_details) == 0) {
    kill_script("Post not found.");
  }

  // they can only edit if they are an admin or if it is their post.
  $post_details = $post_details[0];
  $is_user_post = $user->id() == $post_details["authors"];
  if(!$user->isAdmin() && !$is_user_post) {
    kill_script("Sorry, you don't have access here.");
  }

  // different defaults if they aren't submitting
  if(!$params->get("submitted")) {
    $post_title = $post_details["title"];
    $post_body = $post_details["abstract"];
  }
}

?>
<div class="container">
<?php

$errors = array();
if($params->get("submitted")) {
  if(!$post_title) {
    $errors[] = "Please include a post title.";
  }
  if(!$post_body) {
    $errors[] = "Please include a post body.";
  }

  if(!$errors) {

    if($params->get("post-id")) {
      // permissions checked earlier.

      $post_id = $params->get("post-id");
      $coffee_conn->boundCommand(
        "UPDATE papers SET date = date, title = ?, abstract = ? WHERE id = ?",
        array('ssi', &$post_title, &$post_body, &$post_id)
      );

      print_alert("Post updated. <a href='post.php?id=" . $post_id . "'>View post</a>.", "success");

    } else { // add post

      $subject = "custom";
      $author = $user->id();
      // new "post"
      $coffee_conn->boundCommand(
        "INSERT INTO papers (title, authors, abstract, subject) VALUES (?, ?, ?, ?)",
        array('ssss', &$post_title, &$author, &$post_body, &$subject)
      );

      // post details
      $post_details = $coffee_conn->boundQuery(
        "SELECT * FROM papers WHERE title = ? AND authors = ? AND abstract = ? AND subject = ?",
        array('ssss', &$post_title, &$author, &$post_body, &$subject)
      ); // technically this could be a duplicate?

      if(count($post_details) == 0) {
        print_alert("Error creating post!", "danger");
      } else {
        $post_link = "<ul>";
        foreach($post_details as $details) {
          $post_link .= '<li><a href="post.php?id=' . $details['id'] . '">' . o($details["title"]) . '</a></li>';
        }
        $post_link .= "</ul>";

        if(count($post_details) > 1) {
          print_alert("Your post was created, but may be a duplicate. The following posts have identical content:<br>"
            . $post_link, "warning");
        } else {
          print_alert("New post created. Please visit your post to vote on it: <br>"
            . $post_link, "success");
        }

        // reset these to try to prevent accidents.
        $post_title = "";
        $post_body = "";
      }
    } // end add post

  } else {
    print_errors($errors);
  }
}

if($params->get("post-id")) {
  print "<h1>Edit Content</h1>";
} else {
  print "<h1>Add New Content</h1>";
}

?>
  <p>Fill out the fields below to create a new post.</p>
  <form class="form-horizontal" method="POST">
    <div class="form-group">
      <label for="post-title" class="col-sm-2 control-label">Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="post-title" id="post-title" placeholder="Post Title" value="<?php print o($post_title); ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="post-body" class="col-sm-2 control-label">Post Text:</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="10" name="post-body" id="post-body"><?php print o($post_body); ?></textarea>
      </div>
    </div>
    <div class="col-sm-offset-2 col-sm-10">
      <?php if($params->get("post-id")) { ?>
        <input type="hidden" name="post-id" value="<?php print o($params->get("post-id")); ?>">
      <?php } ?>
      <input type="hidden" name="submitted" value="add">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>

<?php

require_once("private/templates/footer.php");
