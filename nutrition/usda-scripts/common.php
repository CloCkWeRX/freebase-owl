<?php
if (file_exists('config.php')) {
    include 'config.php';
} else {
    $dsn = 'mysql://user:password@localhost/usda';
    $path = dirname(__FILE__);
}

function render_food($food) {
    ob_start();
    include dirname(dirname(__FILE__)) . '/templates/Food.php';
    return ob_get_clean();
}

require_once 'MDB2.php';
require_once 'USDA/Base.php';
require_once 'USDA/DataLink.php';
require_once 'USDA/DataSource.php';
require_once 'USDA/FoodGroup.php';
require_once 'USDA/FoodNutrient.php';
require_once 'USDA/Food.php';
require_once 'USDA/Nutrient.php';
require_once 'USDA/Source.php';
require_once 'USDA/Weight.php';
require_once 'XML/Beautifier.php';
require_once 'Validate/US.php';

$db = MDB2::connect($dsn);
