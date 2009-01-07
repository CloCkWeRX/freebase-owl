<?php
require_once 'common.php';

if (php_sapi_name() != 'cli') {
    die("You must run this script from the command line");
}

$output_dir = $path . '/rdf';

if (!file_exists($output_dir) && !mkdir($output_dir)) {
    die('You must either make it yourself or run this script with privileges to create ' . $output_dir);
}
if (!is_writeable($output_dir)) {
    die('Cant write to ' . $output_dir);
}

$sql = "SELECT nbd_id FROM foods";

$foods = $db->queryCol($sql);
foreach ($foods as $nbd_id) {
    $write_path = $output_dir . '/' . $nbd_id . '.rdf';
    exec('php rdfizer.php ' . $nbd_id . ' > ' . $write_path);
    print "Wrote " . $write_path . "\n";
}
