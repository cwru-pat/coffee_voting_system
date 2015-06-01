<?php
require_once __dir__."/../private/site.php";
$coffee_conn->setDebug(false);

$reply = array();

if ($params->get("import-id")) {
    $errors = array();
    if (!$user->isLoggedIn()) {
        $errors[] = "You must log in.";
    }
    if (! $title = $params->get("title")) {
        $errors[] = "Title not set.";
    }
    if (! $arxivId = $params->get("arxivId")) {
        $errors[] = "arxivId not set.";
    }
    if (! $authors = $params->get("authors")) {
        $errors[] = "Authors not set.";
    }
    if (! $abstract = $params->get("abstract")) {
        $errors[] = "Abstract not set.";
    }
    if (! $section = $params->get("section")) {
        $errors[] = "Section not set.";
    }

    $duplicates = $coffee_conn->boundQuery(
        "SELECT * FROM papers WHERE arxivId LIKE ?",
        array('s', &$arxivId)
    );
    if (count($duplicates)) {
        if (!isset($duplicates[0]["id"])) {
            $reply = array(
            "errors" => array("Duplicate found but error encountered.")
            );
        } else {
            $reply = array(
            "success" => "Duplicate found.",
            "duplicates" => count($duplicates),
            "postId" => $duplicates[0]["id"],
            "duplicateTitle" => $duplicates[0]["title"],
            );
        }
    } elseif (!$errors) {
        // ok to import.

        $coffee_conn->boundCommand(
            "INSERT INTO papers (title, authors, abstract, subject, arxivId) VALUES (?, ?, ?, ?, ?)",
            array('sssss', &$title, &$authors, &$abstract, &$section, &$arxivId)
        );

        $paper = $coffee_conn->boundQuery(
            "SELECT * FROM papers WHERE title = ? LIMIT 1",
            array('s', &$title)
        );

        if (!isset($paper[0]["id"])) {
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
