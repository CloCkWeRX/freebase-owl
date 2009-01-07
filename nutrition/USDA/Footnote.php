<?php
require_once 'Base.php';

class USDA_Footnote extends USDA_Base {
    public $nbd_id;
    public $footnote_id;
    public $type;
    public $nutrient_id;
    public $description;

    public $nutrient;

    public function __construct(MDB2_Driver_Common $db) {
        parent::__construct($db);
        
        $this->nutrient = new USDA_Nutrient($db);
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'nbd_id';
        $keys[] = 'footnote_id';
        $keys[] = 'type';
        $keys[] = 'nutrient_id';
        $keys[] = 'description';

        return $keys;
    }

    public function load($nbd_id, $footnote_id) {
        $sql = "SELECT * FROM footnotes WHERE nbd_id = " . $nbd_id . " AND footnote_id = " . $footnote_id;

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

        if (!empty($this->nutrient_id)) {
            $this->nutrient->load($this->nutrient_id);
        }
    }

    public function getTableName() {
        return 'footnotes';
    }
 
    public function getCreateStatement() {
        return 'CREATE TABLE footnotes (
            nbd_id INT(11),
            footnote_id INT(11),
            type VARCHAR(1),
            nutrient_id INT(11),
            description VARCHAR(200),

            KEY `footnode_id` (`footnote_id`),
            KEY `nbd_id` (`nbd_id`)

        )';
    }
}
