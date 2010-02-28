<?php
require_once 'require.php';

require_once 'Holiday.php';
require_once 'HolidayCalculator.php';

$hc = new HolidayCalculator();

$year = date("Y");

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

include 'header.php';

$holidays = $hc->calculateHolidayDates($year);

foreach ($holidays as $row) {
    $h = new Holiday();
    $h->ph_name = $row[0];
    $h->ph_timezone = $row[1];
    $h->ph_date = $row[2];
    $h->source_uri = BASEADDRESS;
    ?>

    <form method="post" action="add.php">
        <input type="hidden" name="ph_name" value="<?php print $h->ph_name; ?>" />
        <input type="hidden" name="ph_timezone" value="<?php print $h->ph_timezone; ?>" />
        <input type="hidden" name="ph_date" value="<?php print $h->ph_date; ?>" />
        <input type="hidden" name="source_uri" value="<?php print $h->source_uri; ?>" />

        <div class="holiday">
            <h2><?php print !empty($h->ph_name)? htmlentities($h->ph_name) : "N/A"; ?></h2>
            <p><span class="date"><?php print $h->renderDate(); ?></span>
            Source: <a href="<?php print $h->source_uri; ?>"><?php print $h->source_uri; ?></a></p>
        </div>

        <input type="submit" name="action" value="Create" />
    </form>
    <?php
}

include 'footer.php';
