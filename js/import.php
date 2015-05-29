<?php
require_once("../private/site.php");
$coffee_conn->setDebug(FALSE);

$reply = array();

if($params->get("import-id")) {

  $errors = array();
  if(!$user->isLoggedIn())
    $errors[] = "You must log in.";
  if(! $title = $params->get("title"))
    $errors[] = "Title not set.";
  if(! $authors = $params->get("authors"))
    $errors[] = "Authors not set.";
  if(! $abstract = $params->get("abstract"))
    $errors[] = "Abstract not set.";
  if(! $section = $params->get("section"))
    $errors[] = "Section not set.";

  $query_title = trim($title) . "%"; // may be too lenient as a check for dupes.
  $duplicates = $coffee_conn->boundQuery(
      "SELECT * FROM papers WHERE title LIKE ? LIMIT 1",
      array('s', &$query_title)
  );
  if(count($duplicates)) {
    if(!isset($duplicates[0]["id"])) {
        $reply = array(
          "errors" => array("Duplicate found but error encountered.")
        );
    } else {
      $reply = array(
        "success" => "Duplicate found.",
        "postId" => $duplicates[0]["id"],
      );
    }
  } elseif(!$errors) {
    // ok to import.

    $coffee_conn->boundCommand(
      "INSERT INTO papers (title, authors, abstract, subject) VALUES (?, ?, ?, ?)",
      array('ssss', &$title, &$authors, &$abstract, &$section)
    );

    $paper = $coffee_conn->boundQuery(
      "SELECT * FROM papers WHERE title = ? LIMIT 1",
      array('s', &$title)
    );

    if(!isset($paper[0]["id"])) {
        $reply = array(
          "errors" => array("Failed importing paper.")
        );
    } else {
      $reply = array(
        "success" => "Imported successfully.",
        "postId" => $paper[0]["id"],
      );
    }
  } else {
    $reply = array(
      "errors" => $errors,
    );
  }
} else {
  $reply = array(
    "errors" => array("No paper to import.")
  );
}

print json_encode($reply);
