<?php
include 'config-local.php';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);