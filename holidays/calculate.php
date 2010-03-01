<?php
require_once 'require.php';

require_once 'HolidayController.php';
require_once 'HolidayCalculator.php';

$hc = new HolidayCalculator();

$year = date("Y");

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

include 'header.php';

$holidays = $hc->calculateHolidayDates($year);

$controller = new HolidayController();

foreach ($holidays as $row) {
    $h = new Holiday();
    $h->ph_name = $row[0];
    $h->ph_timezone = $row[1];
    $h->ph_date = $row[2];
    $h->source_uri = BASEADDRESS;

    $result = $controller->find_holiday($dbh, $h->ph_date, $h->ph_timezone);

    $matches = array();
    foreach ($result as $match) {
        $matches[] = clone $match;
    }
    ?>

    <form method="post" action="add.php" target="_blank">
        <input type="hidden" name="ph_name" value="<?php print $h->ph_name; ?>" />
        <input type="hidden" name="ph_timezone" value="<?php print $h->ph_timezone; ?>" />
        <input type="hidden" name="ph_date" value="@<?php print $h->ph_date; ?>" />
        <input type="hidden" name="source_uri" value="<?php print $h->source_uri; ?>" />

        <div class="holiday">
            <h2><?php print !empty($h->ph_name)? htmlentities($h->ph_name) : "N/A"; ?></h2>
            <p><span class="date"><?php print $h->renderDate(); ?></span>
            Source: <a href="<?php print $h->source_uri; ?>"><?php print $h->source_uri; ?></a></p>
        </div>
        <?php if (!empty($matches)) { ?>
            <h4>Matches</h4>
            <ul>
        <?php } ?>
        <?php foreach ($matches as $match) { ?>
            <li>
                <a href="view.php?id=<?php print $match->ph_id; ?>"><?php print !empty($match->ph_name)? htmlentities($match->ph_name) : "N/A"; ?></a>, <span class="date"><?php print $match->renderDate(); ?></span>, Source: <a href="<?php print $h->source_uri; ?>"><?php print $h->source_uri; ?></a></p>
            </li>
        <?php } ?>
        <?php if (!empty($matches)) { ?>
            </ul>
        <?php } ?>

        <?php if (empty($matches)) { ?>
            <p>Check <a href="http://www.australia.gov.au/topics/australian-facts-and-figures/public-holidays">these sources</a></p>
            <input type="submit" name="action" value="Add" />
        <?php } ?>
    </form>
    <?php
}

include 'footer.php';
