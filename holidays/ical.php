<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();


if (!empty($_GET['area_id'])) {
    $result = $controller->allForArea($dbh, (int)$_GET['area_id']);
} else {
    $result = $controller->all($dbh);
}

header('content-type: text/calendar');
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN

<?php foreach ($result as $h) { ?>
<?php
$time = $h->renderDate('U');
?>
BEGIN:VEVENT
DTSTART;TZID=UTC:<?php print gmdate("Ymd", $time); ?>T<?php print gmdate("his", $time) . "\n"; ?>
DURATION:P1D
SUMMARY:<?php print $h->ph_name . ' ' .  $h->ph_timezone . "\n"; ?>
END:VEVENT

<?php } ?>

END:VCALENDAR
