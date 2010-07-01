<?php
require_once 'Application.php';
require_once 'Property.php';
require_once 'Address.php';
require_once 'Title.php';
require_once 'Person.php';
require_once 'ApplicationStage.php';
require_once 'ApplicationController.php';

$path = dirname(__FILE__) . '/config-local.php';
if (file_exists($path)) {
    include $path;
} else {
    include 'config.php';
}