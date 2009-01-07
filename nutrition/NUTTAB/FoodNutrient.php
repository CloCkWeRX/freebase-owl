<?php
require_once 'Base.php';

class NUTTAB_FoodNutrient extends NUTTAB_Base {

    public $food_id;
    public $nutrient_id;
    public $description;
    public $scale;
    public $value;
    public $category;

    public function getTableName() {
        return 'food_nutrients';
    }


    public function getKeys() {
        $keys = array();
        $keys[] = 'food_id';
        $keys[] = 'nutrient_id';
        $keys[] = 'description';
        $keys[] = 'scale';
        $keys[] = 'value';
        $keys[] = 'category';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE food_nutrients (
            food_id CHAR(8),
            nutrient_id CHAR(30),
            description CHAR(30),
            scale CHAR(3),
            `value` DECIMAL(8,3),
            category CHAR(10),

            KEY `food_id` (`food_id`),
            KEY `nutrient_id` (`nutrient_id`)
        )';
    }

    public function load($food_id, $nutrient_id) {
        $sql = "SELECT * FROM food_nutrients WHERE food_id = " . $food_id . " AND nutrient_id = " . $nutrient_id;

        $result = $this->db->query($sql);
        if (MDB2::isError($result)) {
            print_r($result);
            throw new Exception($result->getMessage());
        }
        $row = $result->fetchRow();

        if (empty($row)) {
            return false;
        }

        $this->updateFromArray($row);
    }
}
