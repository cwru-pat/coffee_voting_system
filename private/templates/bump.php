<?php
require_once("../private/site.php");
$coffee_conn->setDebug(FALSE);

// only want to return one short message.
$message = array();

// don't really care about CSRF here.

$paperId = intval($params->get("paperId"));
$bump = intval($params->get("bump"));

// make sure the paper exists
$statement = "SELECT * FROM papers WHERE id = ? LIMIT 1";
$result = $coffee_conn->boundQuery($statement, array('i', &$paperId));
if(!count($result)) {
  $message["error"] = "Uh-oh, something went wrong. Please try later.";
} else {
  $statement = "SELECT id FROM votes WHERE paperId = ? AND userId = 'bump'";
  $result = $coffee_conn->boundQuery($statement, array('i', &$paperId));
  if(count($result)&&$bump) {
      $voteid = $result[0]['id']; 
      $statement = "UPDATE votes SET date= ? WHERE id = ?";
      $coffee_conn->boundCommand($statement, array('i', &$voteId));
      $message["success"] = "Paper bumped to next meeting.";
  } elseif ($bump) {
// New bump.
    $statement = "INSERT INTO votes (paperId, userId, value) VALUES(?, 'bump', 0)";
    $coffee_conn->boundCommand($statement, array('i', &$paperId));
    $message["success"] = "Paper bumped to next meeting.";
  } else
    $voteId = $result[0]['id'];
    $statement = "DELETE FROM votes WHERE id = ?";
      $coffee_conn->boundCommand($statement, array('i', &$voteId));
      $message["success"] = "Paper no longer bumped.";
}

  print json_encode($message);
