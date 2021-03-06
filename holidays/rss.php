<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();


if (!empty($_GET['area_id'])) {
    $result = $controller->allForArea($dbh, (int)$_GET['area_id']);
} else {
    $result = $controller->all($dbh);
}


header('content-type: application/rss+xml');

$holidays = array();
foreach ($result as $h) {
    $holidays[] = clone $h;
}
?>
<?xml version="1.0"?>
<rdf:RDF
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
xmlns:rss="http://purl.org/rss/1.0/"
xmlns="http://purl.org/rss/1.0/"
xmlns:dc="http://purl.org/dc/elements/1.1/">

    <channel rdf:about="">
        <title>Australian Public Holidays</title>

        <items>
            <rdf:Seq>
                <?php foreach ($holidays as $h) { ?>
                    <rdf:li rdf:resource="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>" />
                <?php } ?>
            </rdf:Seq>
        </items>
    </channel>

    <?php foreach ($holidays as $h) { ?>
        <item rdf:about="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>">
            <title><?php print htmlentities($h->ph_name); ?></title>
            <link><?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?></link>
            <dc:date><?php print $h->renderDate(DATE_ATOM); ?></dc:date>
            <rdfs:seeAlso rdf:resource="<?php print $h->source_uri; ?>" />
        </item>
    <?php } ?>
</rdf:RDF>