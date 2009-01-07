<?php
require_once 'Base.php';

class USDA_FoodNutrient extends USDA_Base {

    public $nbd_id;
    public $nutrient_id;
    public $nutrient_amount;
    public $samples;
    public $std_error;
    public $source_id;
    public $derivation_id;
    public $missing_item_nbd_id;
    public $total_studies;
    public $minimum;
    public $maximum;
    public $degress_of_freedom;
    public $error_bound_lower;
    public $error_bound_upper;
    public $statistical_comment;
    public $confidence_id;

    public function getTableName() {
        return 'food_nutrients';
    }

    public function __construct(MDB2_Driver_Common $db) {
        parent::__construct($db);
        
        $this->nutrient = new USDA_Nutrient($db);
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'nbd_id';
        $keys[] = 'nutrient_id';
        $keys[] = 'nutrient_amount';
        $keys[] = 'samples';
        $keys[] = 'std_error';
        $keys[] = 'source_id';
        $keys[] = 'derivation_id';
        $keys[] = 'missing_item_nbd_id';
        $keys[] = 'total_studies';
        $keys[] = 'minimum';
        $keys[] = 'maximum';
        $keys[] = 'degress_of_freedom';
        $keys[] = 'error_bound_lower';
        $keys[] = 'error_bound_upper';
        $keys[] = 'statistical_comment';
        $keys[] = 'confidence_id';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE food_nutrients (
            nbd_id INT(11),
            nutrient_id INT(11),
            nutrient_amount DECIMAL(10, 3),
            samples DECIMAL(5,2),
            std_error DECIMAL(8,3),
            source_id INT(11),
            derivation_id INT(11),
            missing_item_nbd_id INT(5),
            added_nutrient_ndb_id INT(5),
            total_studies INT(2),
            minimum DECIMAL(10,3),
            maximum DECIMAL(10,3),
            degress_of_freedom INT(2),
            error_bound_lower DECIMAL(10,3),
            error_bound_upper DECIMAL(10,3),
            statistical_comment VARCHAR(10),
            confidence_id INT(1),

            KEY `nbd_id` (`nbd_id`),
            KEY `nutrient_id` (`nutrient_id`)
        )';
    }

    public function load($nbd_id, $nutrient_id) {
        $sql = "SELECT * FROM food_nutrients WHERE nbd_id = " . $nbd_id . " AND nutrient_id = " . $nutrient_id;

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

        $this->nutrient->load($this->nutrient_id);
    }
}
