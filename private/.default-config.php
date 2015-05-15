<?php

/*
 * Copy this file to .config.php and edit.
 */

// path to base dir of website.
$config['web']['path'] = "/coffee_stuff";

// arxivs to pull from & display
$config['arxivs'] = array(
    "astro-ph.CO",
    "astro-ph.HE",
    "astro-ph.GA",
    "astro-ph.IM",
    "gr-qc",
    "hep-ph",
    "hep-th"
);

// settings for connecting to the database.
$config['database']['host'] = 'localhost';
$config['database']['user'] = 'coffee';
$config['database']['pass'] = 'coffee';
$config['database']['name'] = 'coffee';

$config['phpCAS']['location'] = '/usr/share/php/CAS.php';

// Schema used by the DBConn class to create tables.
// Don't use a field name "id"; this is created by DBConn.
// $config['database']['tables']['table_name'] = array(
//    "column_name" => "column_type"
// );

$config['database']['tables']['papers'] = array(
    "title" => "BLOB",
    "authors" => "BLOB",
    "abstract" => "BLOB",
    "subject" => "VARCHAR(12)",
    "date" => "TIMESTAMP"
  );

$config['database']['tables']['votes'] = array(
    "paperId" => "INT",
    "userId" => "VARCHAR(10)",
    "value" => "INT",
    "date" => "TIMESTAMP"
  );
