<?php
function load_class($name) {
    $path = dirname(__FILE__) . "/" . $name . ".php";
    if (file_exists($path)) {
        require_once $path;
    }
}

spl_autoload_register('load_class');

$path = dirname(__FILE__) . '/config-local.php';
if (file_exists($path)) {
    include $path;
} else {
    include 'config.php';
}