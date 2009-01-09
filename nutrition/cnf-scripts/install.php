<?php
require_once 'common.php';


function create_database($db) {
    $food_nutrient = new CNF_FoodNutrient($db);
    $sql[] = $food_nutrient->getCreateStatement();

    $food = new CNF_Food($db);
    $sql[] = $food->getCreateStatement();

    foreach ($sql as $query) {
        $res = $db->query($query);
        if (MDB2::isError($res)) {
            print $query . "\n";
            print $res->getMessage() . "\n\n";
        }
    }
}

function map_line($data, $object) {
    foreach ($data as $n => $item) {
        if ($item == 'Nil') {
            $data[$n] = null;
        }
    }
    $object->updateFromArray($data);

    $object->insert();

    return $object;
}

function map_data($fp, $object, $stdout, $delim = ",") {
    fwrite($stdout, "Inserting\n");

    $data = fgetcsv($fp, 0, $delim); // Skip headers!

    $i = 0;
    while (($data = fgetcsv($fp, 0, $delim)) !== false) {
        map_line($data, $object);
        $i++;
        fwrite($stdout, "Inserted $i record(s) for " . get_class($object) . "\n");
    }

    fwrite($stdout, "Completed $i record(s)\n");
    fclose($fp);
}

if (php_sapi_name() != 'cli') {
    die("Sorry: You want to run this from the command line. See the README");
}


// 1. Connect to sqlite, ensure table structures exist
// CREATE DATABASE cnf
create_database($db);

// 2. Import each file into the relevant tables


$stdout = fopen('php://stdout', 'w');


map_data(fopen($path . '/food file.txt', 'r'), new CNF_Food($db), $stdout, "$");
