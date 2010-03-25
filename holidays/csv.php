<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();

if (!empty($_GET['area_id'])) {
    $result = $controller->allForArea($dbh, (int)$_GET['area_id']);
} else {
    $result = $controller->all($dbh);
}

header('content-type: text/csv');

$fp = fopen('php://output', 'w');
fputcsv($fp, array("Name", "Date", "Timezone", "Unix Timestamp"));
foreach ($result as $h) {

    fputcsv($fp, array($h->ph_name, $h->renderDate("Y-m-d"), $h->ph_timezone, $h->ph_date));
}
fclose($fp);