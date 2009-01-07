<?php
require_once 'Base.php';

class USDA_Source extends USDA_Base {
    public $source_id;
    public $description;

    public function getTableName() {
        return 'sources';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'source_id';
        $keys[] = 'description';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE sources (
            source_id INT(11),
            description VARCHAR(60),

            KEY `source_id` (`source_id`)
        )';
    }
}
