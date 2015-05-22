<?php

require_once("../private/site.php");
$coffee_conn->setDebug(FALSE);

// only want to return one short message.
$message = array();

// don't really care about CSRF here.
if($user->isLoggedIn()) {
  $paperId = intval($params->get("paperId"));
  $userId = $user->id();
  $value = intval($params->get("value"));

  // make sure the paper exists
  $statement = "SELECT * FROM papers WHERE id = ? LIMIT 1";
  $result = $coffee_conn->boundQuery($statement, array('i', &$paperId));
  if(!count($result)) {
    $message["error"] = "Uh-oh, something went wrong. Please try later.";
  } else {
    $statement = "SELECT * FROM votes WHERE paperId = ? AND userId = ?";
    $result = $coffee_conn->boundQuery($statement, array('is', &$paperId, &$userId));
    if(count($result)) {
      // Already voted; update vote.
      $old_value = $result[0]["value"];
      $new_value = $old_value + $value;
      if($new_value == 0) {
        // completely remove
        $statement = "DELETE FROM votes WHERE paperId = ? AND userId = ?";
        $coffee_conn->boundCommand($statement, array('is', &$paperId, &$userId));
        $message["success"] = "Vote removed.";
        $message["value"] = NULL;
      } else {
        // update.
        $statement = "UPDATE votes SET value = ? WHERE paperId = ? AND userId = ?";
        $coffee_conn->boundCommand($statement, array('iis', &$new_value, &$paperId, &$userId));
        $message["success"] = "Vote updated.";
        $message["value"] = $new_value;
      }
    } else {
      // New vote.
      $statement = "INSERT INTO votes (paperId, userId, value) VALUES(?, ?, ?)";
      $coffee_conn->boundCommand($statement, array('isi', &$paperId, &$userId, &$value));
      $message["success"] = "Vote logged.";
      $message["value"] = $value;
    }
  }
} else {
  $message["error"] = "You must <a href='" . path() . "login.php'>sign in</a> to vote!";
  $message['login'] = false;
}

print json_encode($message);
