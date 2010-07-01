<?php
class ApplicationController {

    public function findByID($id) {
        return new Application();
    }

    public function findAllByStage(ApplicationStage $stage) {
        return array(new Application(), new Application(), new Application());
    }


    public function propose(Application $application) {
        $application->stages[] = new ProposedStage();
    }

    public function approve(Application $application) {
        $application->stages[] = new ApprovedStage();
    }

    public function reject(Application $application) {
        $application->stages[] = new RejectedStage();
    }
}