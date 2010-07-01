<?php
class Application {
    public $property;
    public $applicant;

    public $fees = array();
    public $stages = array();

    public function __construct() {
        $this->property = new Property();
        $this->applicant = new Person();
        $this->stages[] = new ProposedStage();
    }

    public function getStatus() {
        return end($this->stages)->toString();
    }

    public function renderName() {
        return "26 Example St, Exampleton";
    }

    public function getProposedDevelopment() {
        return "An addition of an external enclosed dwelling ('Granny Flat')";
    }

    public function getExistingProperty() {
        return "Standard Residential 4 bedroom house";
    }

    public function getApproximateCost() {
        return 12345.00;
    }

    public function getApproximateDate() {
        return time();
    }

}
