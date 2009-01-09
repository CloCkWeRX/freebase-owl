<?php
require_once 'Base.php';

class NUTTAB_Retention extends NUTTAB_Base {
    public $retention_factor_id;
    public $title = "";
    public $nutrient_id;
    public $nutrient_description;
    public $nutrient_scale;
    public $retention_factor;
    
    public function getTableName() {
        return 'retention_factor';
    }

    public function getPrimaryKey() {
        return 'retention_factor_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'retention_factor_id';
        $keys[] = 'title';
        $keys[] = 'nutrient_id';
        $keys[] = 'nutrient_description';
        $keys[] = 'nutrient_scale';
        $keys[] = 'retention_factor';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE retention_factor (
            retention_factor_id INT(11),
            title CHAR(60),
            nutrient_id CHAR(30),
            nutrient_description CHAR(60),
            nutrient_scale CHAR(3),
            retention_factor INT(2),

            KEY `retention_factor_id` (`retention_factor_id`),
            KEY `nutrient_id` (`nutrient_id`)
        )';
    }
}
