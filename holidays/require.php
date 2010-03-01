<?php
include 'config-local.php';

require_once 'SecurityController.php';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($admin_user) || !isset($admin_pass)) {
    die("Check your configuration for administration credentials");
}

$security = new SecurityController($admin_user, $admin_pass);