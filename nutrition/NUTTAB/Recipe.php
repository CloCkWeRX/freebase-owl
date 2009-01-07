<?php
require_once 'Base.php';

class NUTTAB_Recipe extends NUTTAB_Base {
    public $food_id;
    public $title = "";
    public $weight_change;
    public $ingredient_id; // a food_id
    public $ingredient_title;
    public $ingredient_weight; //grams
    public $retention_factor_id; // retention_factor_id
    
    public function getTableName() {
        return 'recipe';
    }

    public function getPrimaryKey() {
        return 'food_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'food_id';
        $keys[] = 'title';
        $keys[] = 'weight_change';
        $keys[] = 'ingredient_id';
        $keys[] = 'ingredient_title';
        $keys[] = 'ingredient_weight';
        $keys[] = 'retention_factor_id';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE recipe (
            food_id CHAR(8),
            title CHAR(200),
            weight_change DECIMAL(2, 1),
            
            ingredient_id CHAR(8),
            ingredient_title CHAR(200),
            ingredient_weight DECIMAL(8, 3),
            retention_factor_id INT(11),

            KEY `retention_factor_id` (`retention_factor_id`),
            KEY `food_id` (`food_id`)
        )';
    }
}
