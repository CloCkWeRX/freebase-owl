<?php
require_once 'Base.php';

class USDA_FoodGroup extends USDA_Base {
    public $group_id;
    public $description = "";

    public function getTableName() {
        return 'food_groups';
    }

    public function getPrimaryKey() {
        return 'group_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'group_id';
        $keys[] = 'description';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE food_groups (
            group_id INT(11),
            description TEXT,

            KEY `group_id` (`group_id`)
        )';
    }
}
