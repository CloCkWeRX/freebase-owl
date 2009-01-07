<?php
require_once 'Base.php';

class USDA_DataSource extends USDA_Base {
    public $datasrc_id;
    public $authors;
    public $title;
    public $year;
    public $journal;
    public $volume_city;
    public $issue_state;
    public $start_page;
    public $end_page;
    

    public function getKeys() {
        $keys = array();
        $keys[] = 'datasrc_id';
        $keys[] = 'authors';
        $keys[] = 'title';
        $keys[] = 'year';
        $keys[] = 'journal';
        $keys[] = 'volume_city';
        $keys[] = 'issue_state';
        $keys[] = 'start_page';
        $keys[] = 'end_page';

        return $keys;
    }

    public function getTableName() {
        return 'data_sources';
    }
 
    public function getPrimaryKey() {
        return 'datasrc_id';
    }

    public function getCreateStatement() {
        return 'CREATE TABLE data_sources (
            datasrc_id VARCHAR(7),
            authors VARCHAR(255),
            title VARCHAR(255),
            year INT(4),
            journal VARCHAR(135),
            volume_city VARCHAR(16),
            issue_state VARCHAR(5),
            start_page INT(5),
            end_page INT(5),

            KEY `datasrc_id` (`datasrc_id`)
        )';
    }

}
