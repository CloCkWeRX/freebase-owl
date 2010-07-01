<?php
class ApplicationStage {

    public function toString() {
        return "";
    }
}

class ProposedStage extends ApplicationStage {
    public function toString() {
        return "Proposed";
    }
}

class ApprovedStage extends ApplicationStage {
    public function toString() {
        return "Approved";
    }
}

class RejectedStage extends ApplicationStage {
    public function toString() {
        return "Rejected";
    }
}