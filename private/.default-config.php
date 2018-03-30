<?php
/*
 * Copy this file to .config.php and edit it appropriately.
 */

// (public) path to base dir of website.
$config['web']['path'] = "/coffee_stuff/";

// settings for connecting to the database.
$config['database']['host'] = 'localhost';
$config['database']['user'] = 'travis';
$config['database']['pass'] = '';
$config['database']['name'] = 'coffee';

$config['phpCAS']['location'] = __DIR__ . '/../../CAS/CAS.php';

// Schema used by the DBConn class to create tables.
// Don't use a field name "id"; this is created by DBConn.
// $config['database']['tables']['table_name'] = array(
//    "column_name" => "column_type"
// );

$config['database']['tables']['papers'] = array(
    "title" => "BLOB",
    "authors" => "BLOB",
    "abstract" => "BLOB",
    "subject" => "VARCHAR(20)",
    "arxivId" => "VARCHAR(20)",
    "date" => "TIMESTAMP"
  );

$config['database']['tables']['votes'] = array(
    "paperId" => "INT",
    "userId" => "VARCHAR(10)",
    "value" => "INT",
    "date" => "TIMESTAMP"
  );

$config['database']['tables']['variables'] = array(
    "name" => "VARCHAR(20)",
    "value" => "BLOB"
  );
