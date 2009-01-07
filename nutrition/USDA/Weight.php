<?php
require_once 'Base.php';

class USDA_Weight extends USDA_Base {
    public $nbd_id;
    public $sequence;
    public $amount;
    public $description;
    public $grams;
    public $samples;
    public $std_deviation;

    public function getKeys() {
        $keys = array();
        $keys[] = 'nbd_id';
        $keys[] = 'sequence';
        $keys[] = 'amount';
        $keys[] = 'description';
        $keys[] = 'grams';
        $keys[] = 'samples';
        $keys[] = 'std_deviation';

        return $keys;
    }

    public function getTableName() {
        return 'weights';
    }
 
    public function getCreateStatement() {
        return 'CREATE TABLE weights (
            nbd_id INT(11),
            sequence INT(2),
            amount DECIMAL(5,3),
            description VARCHAR(80),
            grams DECIMAL(7,1),
            samples INT(3),
            std_deviation DECIMAL(7,3),

            KEY `nbd_id` (`nbd_id`),
            KEY `sequence` (`sequence`)
        )';
    }

    public function load($nbd_id, $sequence) {
        $sql = "SELECT * FROM weights WHERE nbd_id = " . $nbd_id . " AND sequence = " . $sequence;

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
