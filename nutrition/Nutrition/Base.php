<?php
class Nutrition_Base {
    protected $db;

    public function __construct(MDB2_Driver_Common $db) {
        $this->db = $db;
    }

    public function getID() {
        $property = $this->getPrimaryKey();

        return $this->$property;
    }


    public function mapArray($keys, $values) {

        foreach ($keys as $n => $key) {
            if (isset($values[$n])) {
                $this->$key = $values[$n];
            }
        }
    }

    public function mapHash($keys, $values) {
        foreach ($keys as $n => $key) {
            $this->$key = $values[$key];
        }
    }

    public function toArray($keys) {
        $values = array();
        foreach ($keys as $n => $key) {
            $values[$n] = $this->$key;
        }

        return $values;
    }

    // I hate references, and array_walk, which needs &
    public function quote(&$value) {
        $value = $this->db->quote($value);
        return $value;
    }

    public function updateFromArray($values) {
        if (!is_array($values)) {
            throw new InvalidArgumentException("Expected an array");
        }
        $this->mapArray($this->getKeys(), $values);
    }

    public function updateFromHash($values) {
        $this->mapHash($this->getKeys(), $values);
    }

    public function load($id) {
        $result = $this->db->query("SELECT * FROM " . $this->getTableName() . " WHERE " . $this->getPrimaryKey() . " = " . $this->db->quote($id));
        if (MDB2::isError($result)) {
            print_r($result);
            throw new Exception($result->getMessage());
        }
        $row = $result->fetchRow();

        if (empty($row)) {
            return false;
        }

        $this->updateFromArray($row);

        return true;
    }

    public function insert() {
        $columns = $this->getKeys();

        $values = $this->toArray($columns);
        array_walk($values, array($this, 'quote'));

        $query = "INSERT INTO " . $this->getTableName() . "(`" . implode('`, `', $columns) . "`) VALUES(" . implode(', ', $values) . ")";

        $result = $this->db->query($query);
        if (MDB2::isError($result)) {
            print_r($result);
            throw new Exception($result->getMessage());
        }
        return $result;
    }
}
