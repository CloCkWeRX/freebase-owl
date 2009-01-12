<?php
require_once 'common.php';

if (php_sapi_name() == 'cli') {
    // php rdfizer.php 1001
    $datasrc_id = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : 'D1066';
} else {
    $datasrc_id = isset($_GET['nbd_id']) ? $_GET['nbd_id'] : 'D1066';
}

//getBioGUIDLink

$datasrc = new USDA_DataSource($db);
$datasrc->load($datasrc_id);
print "Resolving " . $datasrc->getID() . ": " . $datasrc->resolve() . "\n";

