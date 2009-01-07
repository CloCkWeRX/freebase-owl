<?php
require_once 'NUTTAB/Base.php';

class NUTTAB_Food extends NUTTAB_Base {

    public $food_id;
    public $group_name;
    public $sub_group_name;
    public $description = "";
    public $title = "";
    public $alias = "";

    public $nitrogen_factor = 0.0;
    public $fat_factor = 0.0;

        
    public $edible_description = "";
    public $refuse_description = "";

    public $scientific_name;
    public $derivation;
    public $specific_gravity;
    public $sample_details;

    public $sort_order;

    public function getTableName() {
        return 'foods';
    }

    public function getPrimaryKey() {
        return 'food_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'food_id';
        $keys[] = 'group_name';
        $keys[] = 'sub_group_name';
        $keys[] = 'description';
        $keys[] = 'title';
        $keys[] = 'alias';
        $keys[] = 'nitrogen_factor';
        $keys[] = 'fat_factor';
        $keys[] = 'edible_description';
        $keys[] = 'refuse_description';
        $keys[] = 'scientific_name';
        $keys[] = 'derivation';
        $keys[] = 'specific_gravity';
        $keys[] = 'sample_details';
        $keys[] = 'sort_order';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE foods (
            food_id VARCHAR(8),
            title VARCHAR(200),
            description TEXT,
            alias VARCHAR(30),
            scientific_name VARCHAR(60),
            derivation VARCHAR(20),
            
            
            nitrogen_factor DECIMAL(4,3),
            fat_factor DECIMAL(4,3),
            specific_gravity DECIMAL(4,3),
            sample_details TEXT,
            
            refuse_description VARCHAR(60),
            edible_description VARCHAR(60),

            group_name VARCHAR(50),
            sub_group_name VARCHAR(50),
            sort_order INT(11),

            KEY `food_id` (`food_id`)

        )';
    }
}
