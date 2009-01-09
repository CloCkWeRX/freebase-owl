<?php
require_once 'common.php';


function create_database($db) {
    $footnote = new USDA_Footnote($db);
    $sql[] = $footnote->getCreateStatement();

    $food_nutrient = new USDA_FoodNutrient($db);
    $sql[] = $food_nutrient->getCreateStatement();

    $weight = new USDA_Weight($db);
    $sql[] = $weight->getCreateStatement();

    $food = new USDA_Food($db);
    $sql[] = $food->getCreateStatement();

    $food_group = new USDA_FoodGroup($db);
    $sql[] = $food_group->getCreateStatement();

    $nutrient = new USDA_Nutrient($db);
    $sql[] = $nutrient->getCreateStatement();

    $source = new USDA_Source($db);
    $sql[] = $source->getCreateStatement();

    $link = new USDA_DataLink($db);
    $sql[] = $link->getCreateStatement();

    $source = new USDA_DataSource($db);
    $sql[] = $source->getCreateStatement();

    foreach ($sql as $query) {
        $res = $db->query($query);
        if (MDB2::isError($res)) {
            print $query . "\n";
            print $res->getMessage() . "\n\n";
        }
    }
}

function map_line($data, $object) {
    $object->updateFromArray($data);

     $object->insert();

    return $object;
}

function map_data($fp, $object, $stdout) {
    fwrite($stdout, "Inserting\n");

    $i = 0;
    while (($data = fgetcsv($fp, 0, "^", "~")) !== false) {
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
// CREATE DATABASE usda
create_database($db);

// 2. Import each file into the relevant tables


$stdout = fopen('php://stdout', 'w');


map_data(fopen($path . '/FOOD_DES.txt', 'r'), new USDA_Food($db), $stdout);
map_data(fopen($path . '/FD_GROUP.txt', 'r'), new USDA_FoodGroup($db), $stdout);
map_data(fopen($path . '/NUT_DATA.txt', 'r'), new USDA_FoodNutrient($db), $stdout);
map_data(fopen($path . '/NUTR_DEF.txt', 'r'), new USDA_Nutrient($db), $stdout);
map_data(fopen($path . '/SRC_CD.txt', 'r'), new USDA_Source($db), $stdout);

map_data(fopen($path . '/WEIGHT.txt', 'r'), new USDA_Weight($db), $stdout);
map_data(fopen($path . '/FOOTNOTE.txt', 'r'), new USDA_Footnote($db), $stdout);

map_data(fopen($path . '/DATSRCLN.txt', 'r'), new USDA_DataLink($db), $stdout);
map_data(fopen($path . '/DATA_SRC.txt', 'r'), new USDA_DataSource($db), $stdout);

