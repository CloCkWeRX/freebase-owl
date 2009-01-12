<?php
require_once 'common.php';

if (php_sapi_name() != 'cli') {
    die("You must run this script from the command line");
}


$sql = "SELECT datasrc_id FROM data_sources WHERE journal IS NOT NULL";

$sources = $db->queryCol($sql);

$max = count($sources);
foreach ($sources as $n => $datasrc_id) {
    print exec('php datasource_resolver.php ' . $datasrc_id) . "\n";
    sleep (1);
}
