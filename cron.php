<?php
require_once("private/site.php");

$sub_arxivs = $config->get("arxivs");
$url = "http://export.arxiv.org/rss/";


/* ***************** *
 * Import new papers *
 * ***************** */

function xml2assoc(&$xml)
{

    $allowed = array(
        "item" => "item",
        "title" => "title",
        "description" => "description",
        "dc:creator" => "dc:creator",
        "rdf:RDF" => "rdf:RDF",
        "dc:date" => "dc:date",
        "channel" => "channel",
    );

    // convert XML to associative array
    $assoc = NULL;
    while($xml->read()){
        if($xml->nodeType == XMLReader::END_ELEMENT) break;

        if($xml->nodeType == XMLReader::ELEMENT and !$xml->isEmptyElement) {
            $name = $xml->name;
            if(isset($allowed[$name])) {
                if($name == "item") {
                    $assoc["items"][] = xml2assoc($xml);
                } else {
                    $assoc[$name] = xml2assoc($xml);
                }
            } else {
                // keep processing but don't actually store
                xml2assoc($xml);
            }
        } else if($xml->nodeType == XMLReader::TEXT) {
            $assoc = $xml->value;
        }
    }

    return $assoc;
}

$success = array();
$missing = array();
$duplicates = array();
$messages = array();

foreach($sub_arxivs as $arxiv) {
    $full_url = $url . $arxiv;
    $messages[] = "Importing " . $full_url . " ...";

    $xml = new XMLReader();
    if($xml->open($full_url)) {

        $assoc = xml2assoc($xml);
        $date = strtotime($assoc["rdf:RDF"]["channel"]["dc:date"]);
        $system_date = strtotime("Tomorrow", $date);
        $mysql_date = date("Y-m-d H:i:s", $system_date);
        $messages[] = "Date of RSS feed: " . date("Y-m-d H:i", $date) . "; importing to " . date("Y-m-d H:i", $system_date);
        $items = $assoc["rdf:RDF"]["items"];
        foreach($items as $article) {
            if(isset($article["title"]) && isset($article["description"]) && isset($article["dc:creator"])) {
                $title = trim($article["title"]);
                $abstract = trim($article["description"]);
                $authors = trim($article["dc:creator"]);

                $duplicate_papers = $coffee_conn->boundQuery(
                        "SELECT title FROM papers WHERE title = ? LIMIT 1",
                        array('s', &$title)
                    );
                if(count($duplicate_papers) > 0) {
                    $duplicates[] = "Paper already exists: `" . $title . "`";
                } else {
                    $coffee_conn->boundCommand(
                        "INSERT INTO papers (title, authors, abstract, subject, date) VALUES (?, ?, ?, ?, ?)",
                        array('sssss', &$title, &$authors, &$abstract, &$arxiv, &$mysql_date)
                    );
                    $success[] = "Imported paper: " . $title;
                }
            } else {
                $missing[] = "Item missing data in " . $arxiv . ": " . serialize($article);
            }
        }
    } else {
        $messages[] = "Failed to read RSS feed for " . $arxiv . ".";
    }
    $xml->close();
}

print "<pre>";
foreach($messages as $message) {
  print $message . "\n";
}
print "\n";
print "Imported " . count($success) . " artricles.\n";
print "Did not import " . count($duplicates) . " duplicate articles.\n";
print "Failed to import " . count($missing) . " artricles missing data.\n";

print "</pre>";


/* ***************** *
 * Remove old papers *
 * ***************** */

$expire_date = $config->get("expire_date");
if(!$expire_date) {
  $expire_date = date("Y-m-d", strtotime("-3 months"));
}

$select_statement = "SELECT * FROM papers WHERE papers.date < ? AND papers.id NOT IN (SELECT votes.paperId FROM votes LEFT JOIN papers ON votes.paperId = papers.id)";
$delete_statement = "SELECT * FROM papers WHERE papers.date < ? AND papers.id NOT IN (SELECT votes.paperId FROM votes LEFT JOIN papers ON votes.paperId = papers.id)";
$papers = $coffee_conn->boundQuery($select_statement, array('s', &$expire_date));
$coffee_conn->boundCommand($select_statement, array('s', &$expire_date));

print "<pre>";
print count($papers) . " papers from before " . $expire_date . " that have NOT been voted on have been removed.";
print "</pre>";

print "<a href='".path()."admin.php'>Visit the admin page</a>.";
