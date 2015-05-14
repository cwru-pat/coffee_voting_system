<?php

require_once("private/site.php");

$sub_arxivs = $config->get("arxivs");
$url = "http://export.arxiv.org/rss/";

function xml2assoc(&$xml)
{

    $allowed = array(
        "item" => "item",
        "title" => "title",
        "description" => "description",
        "dc:creator" => "dc:creator",
        "rdf:RDF" => "rdf:RDF"
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
    print "Importing " . $full_url . " ...\n";

    $xml = new XMLReader();
    if($xml->open($full_url)) {

        $assoc = xml2assoc($xml);
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
                        "INSERT INTO papers (title, authors, abstract, subject) VALUES (?, ?, ?, ?)",
                        array('ssss', &$title, &$authors, &$abstract, &$arxiv)
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

print "\n";
print "Imported " . count($success) . " artricles.\n";
print "Did not import " . count($duplicates) . " duplicate articles.\n";
print "Failed to import " . count($missing) . " artricles missing data.\n";

// var_dump($messages);
