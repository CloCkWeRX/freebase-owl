<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();

$result = $controller->all($dbh);

header('content-type: text/xml');
?>
<data
    wiki-url="http://simile.mit.edu/shelf/"
    wiki-section="Simile JFK Timeline"
    >
    <?php foreach ($result as $h) { ?>
    <event start="<?php print $h->renderDate("r"); ?>" title="<?php print htmlentities($h->ph_name); ?> <?php print htmlentities($h->ph_timezone); ?>"></event>
    <?php } ?>
</data>