<?php
if (file_exists('config.php')) {
    include 'config.php';
} else {
    $dsn = 'mysql://user:password@localhost/nuttab';
    $path = dirname(__FILE__);
}

require_once 'MDB2.php';
require_once 'NUTTAB/Base.php';
require_once 'NUTTAB/FoodNutrient.php';
require_once 'NUTTAB/Food.php';
require_once 'NUTTAB/Recipe.php';
require_once 'NUTTAB/Retention.php';
require_once 'XML/Beautifier.php';

function render_food($food) {
    ob_start();
    include dirname(dirname(__FILE__)) . '/templates/Food.php';
    return ob_get_clean();
}

$db = MDB2::connect($dsn);
if (MDB2::isError($db)) {
    print $db;
    die();
}
