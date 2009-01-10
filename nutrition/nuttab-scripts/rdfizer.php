<?php
require_once 'common.php';

if (php_sapi_name() == 'cli') {
    // php rdfizer.php 1001
    $nbd_id = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '14B10076';
} else {
    $nbd_id = isset($_GET['nbd_id']) ? $_GET['nbd_id'] : '14B10076';
}

$food = new NUTTAB_Food($db);
$food->load($nbd_id);


ob_start();
?>
<rdf:RDF 
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:nutrition="http://lauken.com/doconnor/nutrition/0.1/#"
    xmlns:foaf="http://xmlns.com/foaf/0.1/"
    xmlns:dbpprop="http://dbpedia.org/property/">

    <!--
    This data is copyright of the Commonwealth of Australia, Food Standards Australia New Zealand and 
    Adjunct Professor H. Greenfield and others at the University of New South Wales. Certain
    material used in this product has been reproduced with the permission of the Commonwealth
    of Australia, Food Standards Australia New Zealand, Associate Professor H. Greenfield and
    others at the University of New South Wales and other researchers.

    To use this data in a commercial product, see http://www.foodstandards.gov.au/_srcfiles/Licence%20Agreement%202007.pdf
    or contact NPC@foodstandards.gov.au
    -->

    <foaf:Document rdf:about="">
       <foaf:primaryTopic rdf:resource="#food-<?php print $food->getID(); ?>" />
       <dc:creator>Commonwealth of Australia</dc:creator>
       <dc:creator>Food Standards Australia New Zealand</dc:creator>
       <dc:creator>Heather Greenfield</dc:creator>
       <dc:creator>University of New South Wales</dc:creator>
    </foaf:Document>

    <?php print render_food($food); ?>

    <?php if (!empty($food->group_name)) { ?>
    <nutrition:FoodGroup rdf:about="#foodgroup-<?php print $food->group_name; ?>">
        <dc:title><?php print $food->group_name; ?></dc:title>
    </nutrition:FoodGroup>
    <?php } ?>

    <?php if (!empty($food->sub_group_name)) { ?>
    <nutrition:FoodGroup rdf:about="#foodgroup-<?php print $food->sub_group_name; ?>">
        <dc:title><?php print $food->sub_group_name; ?></dc:title>
    </nutrition:FoodGroup>
    <?php } ?>

</rdf:RDF>
<?php 
$xml = ob_get_clean();

$fmt = new XML_Beautifier();
print $fmt->formatString($xml);
?>
