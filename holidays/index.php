<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();

$result = $controller->all_between($dbh, strtotime("now - 1 month"), strtotime("now + 2 months"));

include 'header.php';
?>
<h1>Holidays within Australia</h1>
<p>Gazetted public holidays within Australia. Need to <a href="add.php">add another</a>? Perhaps you should verify it with <a href="http://www.australia.gov.au/topics/australian-facts-and-figures/public-holidays">these sources</a>.</p>
<p>This is also available as <a href="rss.php">RSS 1.0</a> or <a href="ical.php">iCal</a>.</p>

<?php if (empty($result)) { ?>
    <p>No holidays available.</p>
<?php } ?>

<?php foreach ($result as $h) { ?>
    <div class="holiday">
        <h2><a href="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>"><?php print !empty($h->ph_name)? htmlentities($h->ph_name) : "N/A"; ?></a></h2>
        <p><span class="date"><?php print $h->renderDate(); ?></span>
        Source: <a href="<?php print $h->source_uri; ?>"><?php print $h->source_uri; ?></a></p>
    </div>
<?php } ?>
<?php
include 'footer.php';