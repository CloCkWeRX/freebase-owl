<?php
require_once 'Base.php';
require_once 'Net/URL2.php';

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
            openurl TEXT

            KEY `datasrc_id` (`datasrc_id`)
        )';
    }

    public function getBioGUIDLink() {
        if (empty($this->volume_city) || empty($this->start_page) || empty($this->journal)) {
            return false;
        }

        $url = new Net_URL2('http://bioguid.info/openurl');

        $url->setQueryVariable('genre', 'article');

        $url->setQueryVariable('title', $this->journal);
        $url->setQueryVariable('volume', $this->volume_city);
        $url->setQueryVariable('spage', $this->start_page);
    
        $url->setQueryVariable('display', 'rdf');

        return $url->getURL();
    }

    public function resolve() {
        $link = $this->getBioGUIDLink();

        if (empty($link)) {
            return false;
        }

        $document = simplexml_load_file($link);
        $namespaces = $document->getNamespaces(true);

        //Register them with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $document->registerXPathNamespace($prefix, $ns);
        }

        list($id) = $document->xpath('//dc:identifier');

        if (!empty($id)) {
            $link = 'http://bioguid.info/' . $id;
            $sql = "UPDATE data_sources SET openurl = " . $this->db->quote($link) . " WHERE datasrc_id = " . $this->db->quote($this->getID());
            $this->db->query($sql);

            return $link;
        }

        return false;
    }
}
