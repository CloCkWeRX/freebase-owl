<?php
require_once 'common.php';

if (php_sapi_name() != 'cli') {
    die("You must run this script from the command line");
}

$limit  = false;
$offset = false;

if (isset($_SERVER['argv'][1])) {
    if (!isset($_SERVER['argv'][2])) {
        die('Usage: php generate-all.php [limit] [offset] or php generate-all.php');
    }

    $limit = $_SERVER['argv'][1];
    $offset = $_SERVER['argv'][2];
}

$output_dir = $path . '/rdf';

if (!file_exists($output_dir) && !mkdir($output_dir)) {
    die('You must either make it yourself or run this script with privileges to create ' . $output_dir);
}
if (!is_writeable($output_dir)) {
    die('Cant write to ' . $output_dir);
}

$sql = "SELECT food_id FROM foods";
if (($offset !== false) && ($limit !== false)) {
    $sql .= " LIMIT " . $offset . ", " . $limit;
}

$foods = $db->queryCol($sql);

$max = count($foods);
foreach ($foods as $n => $food_id) {
    $write_path = $output_dir . '/' . $food_id . '.rdf';
    exec('php rdfizer.php ' . $food_id . ' > ' . $write_path);
    print "Wrote " . $write_path . "\t(" . ($n +1) . " of " . $max . ")" . "\n";
}
