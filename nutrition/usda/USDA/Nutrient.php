<?php
require_once 'Base.php';

class USDA_Nutrient extends USDA_Base {
    public $nutrient_id;
    public $units;
    public $title;
    public $description;
    public $decimals;
    public $order;

    public function getTableName() {
        return 'nutrients';
    }

    public function getPrimaryKey() {
        return 'nutrient_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'nutrient_id';
        $keys[] = 'units';
        $keys[] = 'title';
        $keys[] = 'description';
        $keys[] = 'decimals';
        $keys[] = 'order';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE nutrients (
            nutrient_id INT(11),
            units VARCHAR(7),
            title VARCHAR(20),
            description VARCHAR(60),
            decimals INT(1),
            `order` INT(6),

            KEY `nutrient_id` (`nutrient_id`)
        )';
    }
}
