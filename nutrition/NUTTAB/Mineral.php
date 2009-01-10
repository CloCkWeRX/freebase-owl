<?php
require_once 'Base.php';

class NUTTAB_Mineral extends NUTTAB_Base {
    public $food_id;
    public $title;



    public $aluminium; //Aluminium (ug)
    public $antimony;	//Antimony (ug)
    public $arsenic;	//Arsenic (ug)
    public $cadmium;	//Cadmium (ug)
    public $calcium;	//Calcium (mg)
    public $chromium;	//Chromium (ug)
    public $cobalt;	//Cobalt (ug)
    public $copper;	//Copper (mg)
    public $fluoride;	//Fluoride (ug)
    public $iodine;	//Iodine (ug)
    public $iron;	//Iron (mg)
    public $lead;	//Lead (ug)
    public $magnesium;	//Magnesium (mg)
    public $manganese;	//Manganese (mg)
    public $mercury;	//Mercury (ug)
    public $molybdenum;	//Molybdenum (ug)
    public $nickel;	//Nickel (ug)
    public $phosphorus;	//Phosphorus (mg)
    public $potassium;	//Potassium (mg)
    public $selenium;	//Selenium (ug)
    public $sodium;	//Sodium (mg)
    public $sulphur;	//Sulphur (mg)
    public $tin;	//Tin (ug)
    public $zinc;	//Zinc (mg)

    
    public function getTableName() {
        return 'minerals';
    }

    public function getPrimaryKey() {
        return 'food_id';
    }

    public function getKeys() {
        $keys = array();
        $keys[] = 'food_id';
        $keys[] = 'title';
        $keys[] = 'aluminium'; //Aluminium (ug)
        $keys[] = 'antimony';	//Antimony (ug)
        $keys[] = 'arsenic';	//Arsenic (ug)
        $keys[] = 'cadmium';	//Cadmium (ug)
        $keys[] = 'calcium';	//Calcium (mg)
        $keys[] = 'chromium';	//Chromium (ug)
        $keys[] = 'cobalt';	//Cobalt (ug)
        $keys[] = 'copper';	//Copper (mg)
        $keys[] = 'fluoride';	//Fluoride (ug)
        $keys[] = 'iodine';	//Iodine (ug)
        $keys[] = 'iron';	//Iron (mg)
        $keys[] = 'lead';	//Lead (ug)
        $keys[] = 'magnesium';	//Magnesium (mg)
        $keys[] = 'manganese';	//Manganese (mg)
        $keys[] = 'mercury';	//Mercury (ug)
        $keys[] = 'molybdenum';	//Molybdenum (ug)
        $keys[] = 'nickel';	//Nickel (ug)
        $keys[] = 'phosphorus';	//Phosphorus (mg)
        $keys[] = 'potassium';	//Potassium (mg)
        $keys[] = 'selenium';	//Selenium (ug)
        $keys[] = 'sodium';	//Sodium (mg)
        $keys[] = 'sulphur';	//Sulphur (mg)
        $keys[] = 'tin';	//Tin (ug)
        $keys[] = 'zinc';	//Zinc (mg)
        return $keys;
    }

    public function getCreateStatement() {
        return 'CREATE TABLE minerals (
            food_id VARCHAR(8),
            title VARCHAR(200),

            aluminium DECIMAL(2, 2),
            antimony DECIMAL(2, 2),
            arsenic DECIMAL(2, 2),
            cadmium DECIMAL(2, 2),
            calcium DECIMAL(2, 2),
            chromium DECIMAL(2, 2),
            cobalt DECIMAL(2, 2),
            copper DECIMAL(2, 2),
            fluoride DECIMAL(2, 2),
            iodine DECIMAL(2, 2),
            iron DECIMAL(2, 2),
            lead DECIMAL(2, 2),
            magnesium DECIMAL(2, 2),
            manganese DECIMAL(2, 2),
            mercury DECIMAL(2, 2),
            molybdenum DECIMAL(2, 2),
            nickel DECIMAL(2, 2),
            phosphorus DECIMAL(2, 2),
            potassium DECIMAL(2, 2),
            selenium DECIMAL(2, 2),
            sodium DECIMAL(2, 2),
            sulphur DECIMAL(2, 2),
            tin DECIMAL(2, 2),
            zinc DECIMAL(2, 2),

            KEY `food_id` (`food_id`)
        )';
    }
}
