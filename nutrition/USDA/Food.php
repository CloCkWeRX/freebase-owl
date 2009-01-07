<?php
require_once 'USDA/Base.php';
require_once 'USDA/Footnote.php';
require_once 'USDA/FoodGroup.php';
require_once 'USDA/Weight.php';

class USDA_Food extends USDA_Base {
    public $nbd_id;
    public $group_id;
    public $description = "";
    public $title = "";
    public $alias = "";
    public $company = "";
    public $survey = false;
    public $refuse_description = "";
    public $refuse = 0;
    public $scientific_name = "";
    public $nitrogen_factor = 0.0;
    public $protein_factor = 0.0;
    public $fat_factor = 0.0;
    public $carbohydrate_factor = 0.0;

    public $nutrients = array();
    public $weights = array();
    public $footnotes = array();
    public $group;

    public function __construct(MDB2_Driver_Common $db) {
        parent::__construct($db);
        $this->group = new USDA_FoodGroup($db);
    }

    public function getTableName() {
        return 'foods';
    }

    public function getPrimaryKey() {
        return 'nbd_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'nbd_id';
        $keys[] = 'group_id';
        $keys[] = 'description';
        $keys[] = 'title';
        $keys[] = 'alias';
        $keys[] = 'company';
        $keys[] = 'survey';
        $keys[] = 'refuse_description';
        $keys[] = 'refuse';
        $keys[] = 'scientific_name';
        $keys[] = 'nitrogen_factor';
        $keys[] = 'protein_factor';
        $keys[] = 'fat_factor';
        $keys[] = 'carbohydrate_factor';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE foods (
            nbd_id INT(11),
            group_id INT(11),
            description TEXT,
            title VARCHAR(60),
            alias VARCHAR(100),
            company VARCHAR(65),
            survey BOOLEAN,
            refuse_description VARCHAR(135),
            refuse INT(2),
            scientific_name VARCHAR(65),
            nitrogen_factor DECIMAL(4,2),
            protein_factor DECIMAL(4,2),
            fat_factor DECIMAL(4,2),
            carbohydrate_factor DECIMAL(4,2),

            KEY `nbd_id` (`nbd_id`),
            KEY `group_id` (`group_id`)

        )';
    }

    public function load($id) {
        $result = parent::load($id);

        if (empty($result)) {
            return $result;
        }

        $sql = "SELECT nutrient_id FROM food_nutrients WHERE nbd_id = " . $this->nbd_id;
        $nutrients = $this->db->queryCol($sql);

        $this->nutrients = array();
        foreach ($nutrients as $nutrient_id) {
            $nutrient = new USDA_FoodNutrient($this->db);
            $nutrient->load($this->nbd_id, $nutrient_id);

            $this->nutrients[] = $nutrient;
        }

        $sql = "SELECT sequence FROM weights WHERE nbd_id = " . $this->nbd_id;
        $weights = $this->db->queryCol($sql);
        foreach ($weights as $sequence) {
            $weight = new USDA_Weight($this->db);
            $weight->load($this->nbd_id, $sequence);

            $this->weights[] = $weight;
        }

        $sql = "SELECT footnote_id FROM footnotes WHERE nbd_id = " . $this->nbd_id;
        $footnotes = $this->db->queryCol($sql);
        foreach ($footnotes as $footnote_id) {
            $footnote = new USDA_Footnote($this->db);
            $footnote->load($this->nbd_id, $footnote_id);

            $this->footnotes[] = $footnote; 
        }
        
        $sql = "SELECT datasrc_id FROM data_links WHERE nbd_id = " . $this->nbd_id;
        $data_links = $this->db->queryCol($sql);
        foreach ($data_links as $datasrc_id) {
            $data_link = new USDA_DataLink($this->db);
            $data_link->load($this->nbd_id, $datasrc_id);

            $this->data_links[] = $data_link;
        }

        $this->group->load($this->group_id);

        return true;
    }

}
