<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();

$result = $controller->all($dbh);



header('content-type: text/xml');

?>
<?xml version="1.0"?>
<rdf:RDF
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
xmlns:rss="http://purl.org/rss/1.0/"
xmlns:dc="http://purl.org/dc/elements/1.1/">

<?php foreach ($result as $h) { ?>
    <rss:Item rdf:about="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>">
        <dc:title><?php print htmlentities($h->ph_name); ?></dc:title>
        <dc:date><?php print $h->renderDate(DATE_ATOM); ?></dc:date>
        <rdfs:seeAlso rdf:resource="<?php print $h->source_uri; ?>" />
    </rss:Item>
<?php } ?>
</rdf:RDF>