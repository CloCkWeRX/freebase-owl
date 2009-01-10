<?php
require_once 'Base.php';

class NUTTAB_OrganicAcid extends NUTTAB_Base {
    public $food_id;
    public $title;
    public $acetic_acid; // Acetic Acid (g) http://en.wikipedia.org/wiki/Acetic_acid
    public $butyric_acid;//	Butyric Acid (g) http://en.wikipedia.org/wiki/Butyric_acid
    public $citric_acid; //	Citric Acid (g) http://en.wikipedia.org/wiki/Citric_acid
    public $fumaric_acid;//	Fumaric Acid (g) http://en.wikipedia.org/wiki/Fumaric_acid
    public $lactice_acid;//	Lactic Acid (g) http://en.wikipedia.org/wiki/Lactic_acid
    public $malic_acid;  //	Malic Acid (g) http://en.wikipedia.org/wiki/Malic_Acid
    public $oxalic_acid; //	Oxalic Acid (g) http://en.wikipedia.org/wiki/Oxalic_Acid
    public $propionic_acid;//	Propionic Acid (g) http://en.wikipedia.org/wiki/Propionic_Acid
    public $quinic_acid;//	Quinic Acid (g)
    public $shikimic_acid;//	Shikimic Acid (g)
    public $succinic_acid;//	Succinic Acid (g) http://en.wikipedia.org/wiki/Succinic_Acid
    public $tartaric_acid;//	Tartaric Acid (g) http://en.wikipedia.org/wiki/Tartaric_Acid

    
    public function getTableName() {
        return 'organic_acids';
    }

    public function getPrimaryKey() {
        return 'food_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'food_id';
        $keys[] = 'title';
        $keys[] = 'acetic_acid';
        $keys[] = 'butyric_acid';
        $keys[] = 'citric_acid';
        $keys[] = 'fumaric_acid';
        $keys[] = 'lactice_acid';
        $keys[] = 'malic_acid';
        $keys[] = 'oxalic_acid';
        $keys[] = 'propionic_acid';
        $keys[] = 'shikimic_acid';
        $keys[] = 'succinic_acid';
        $keys[] = 'tartaric_acid';

        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE organic_acids (
            food_id VARCHAR(8),
            title VARCHAR(200),
            acetic_acid DECIMAL(2,2),
            butyric_acid DECIMAL(2,2),
            citric_acid DECIMAL(2,2),
            fumaric_acid DECIMAL(2,2),
            lactice_acid DECIMAL(2,2),
            malic_acid DECIMAL(2,2),
            oxalic_acid DECIMAL(2,2),
            propionic_acid DECIMAL(2,2),
            shikimic_acid DECIMAL(2,2),
            succinic_acid DECIMAL(2,2),
            tartaric_acid DECIMAL(2,2),

            KEY `food_id` (`food_id`)
        )';
    }
}
