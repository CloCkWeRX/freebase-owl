<?php
require_once 'Base.php';

class USDA_DataLink extends USDA_Base {
    public $nbd_id;
    public $nutrient_id;
    public $datasrc_id;

    public $nutrient;
    public $source;

    public function getKeys() {
        $keys = array();
        $keys[] = 'nbd_id';
        $keys[] = 'nutrient_id';
        $keys[] = 'datasrc_id';

        return $keys;
    }

    public function getTableName() {
        return 'data_links';
    }
 
    public function getCreateStatement() {
        return 'CREATE TABLE data_links (
                nbd_id INT(11),
                nutrient_id INT(11),
                datasrc_id VARCHAR(7),

                KEY `nbd_id` (`nbd_id`),
                KEY `nutrient_id` (`nutrient_id`),
                KEY `datasrc_id` (`datasrc_id`)
            )';
    }

    public function load($nbd_id, $datasrc_id) {
        $sql = "SELECT * FROM data_links WHERE nbd_id = " . $this->db->quote($nbd_id) . " AND datasrc_id = " . $this->db->quote($datasrc_id);

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

        if (!empty($this->datasrc_id)) {
            $this->source->load($this->datasrc_id);
        }

        if (!empty($this->nutrient_id)) {
            $this->nutrient->load($this->nutrient_id);
        }
    }

    public function __construct(MDB2_Driver_Common $db) {
        parent::__construct($db);
        
        $this->nutrient = new USDA_Nutrient($db);
        $this->source = new USDA_DataSource($db);
    }
}
