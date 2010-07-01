<?php
class Property {

    public $address;
    public $title;

    public $owner;

    public function __construct() {
        $this->address = new Address();
        $this->title = new Title();
        $this->owner = new Person();
    }
}
