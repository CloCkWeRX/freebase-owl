<?php
require_once 'common.php';

if (php_sapi_name() == 'cli') {
    // php rdfizer.php 1001
    $nbd_id = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : 1001;
} else {
    $nbd_id = isset($_GET['nbd_id']) ? $_GET['nbd_id'] : 1001;
}

$food = new USDA_Food($db);
$food->load($nbd_id);


$group = $food->group;


$is_state = !empty($source->issue_state) && Validate_US::region($source->issue_state);

ob_start();
?>
<rdf:RDF 
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:usda="http://lauken.com/doconnor/food/0.1/usda.rdf#"
    xmlns:nutrition="http://lauken.com/doconnor/food/0.1/schema.rdf#"
    xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
    xmlns:prism="http://prismstandard.org/namespaces/1.2/basic/"

    xmlns:dbpprop="http://dbpedia.org/property/">
    
    <?php print render_food($food); ?>

    <nutrition:FoodGroup rdf:about="#foodgroup-<?php print $group->group_id; ?>">
        <dc:title><?php print $group->description; ?></dc:title>
    </nutrition:FoodGroup>

    <?php foreach ($food->weights as $weight) { ?>
        <nutrition:Weight rdf:about="#food-<?php print $weight->nbd_id; ?>-<?php print $weight->sequence; ?>">
            <nutrition:food rdf:resource="#food-<?php print $weight->nbd_id; ?>" />

            <nutrition:amount><?php print $weight->amount; ?></nutrition:amount>
            <dc:description><?php print $weight->description; ?></dc:description>

            <nutrition:grams><?php print $weight->grams; ?></nutrition:grams>

            <?php if (!empty($weight->samples)) { ?>
                <!-- TODO: map this to a 'number of samples' property -->
                <nutrition:samples><?php print $weight->samples; ?></nutrition:samples>
            <?php } ?>

            <?php if (!empty($weight->std_deviation)) { ?>
                <!-- TODO: map this to a 'std_deviation' property -->
                <nutrition:std_deviation><?php print $weight->std_deviation; ?></nutrition:std_deviation>
            <?php } ?>
        </nutrition:Weight>
    <?php } ?>

    <?php foreach ($food->footnotes as $footnote) { ?>
        <nutrition:Footnote rdf:about="#footnote-<?php print $footnote->nbd_id; ?>-<?php print $footnote->footnote_id; ?>">
            <nutrition:food rdf:resource="#food-<?php print $footnote->nbd_id; ?>" />

            <?php if (!empty($footnote->nutrient_id)) { ?>
                <nutrition:nutrient rdf:resource="#nutrient-<?php print $footnote->nutrient_id; ?>" />
            <?php } ?>

            <!-- TODO: map these back to better values -->
            <nutrition:type><?php print $footnote->type; ?></nutrition:type>
            <dc:description><?php print $footnote->description; ?></dc:description>
        </nutrition:Footnote>
    <?php } ?>

    <?php foreach ($food->data_links as $link) { ?>
        <nutrition:DataLink rdf:about="#datalink-<?php print $link->nbd_id; ?>-<?php print $link->datasrc_id; ?>">
            <nutrition:food rdf:resource="#food-<?php print $link->nbd_id; ?>" />
            <?php if (!empty($link->datasrc_id)) { ?>
                <nutrition:data_source rdf:resource="#datasource-<?php print $link->datasrc_id; ?>" />
            <?php } ?>

            <?php if (!empty($link->nutrient_id)) { ?>
                <nutrition:nutrient rdf:resource="#nutrient-<?php print $link->nutrient_id; ?>" />
            <?php } ?>
        </nutrition:DataLink>

        <?php if (!empty($link->datasrc_id)) { ?>

            <?php $source = $link->source; ?>
            <nutrition:DataSource rdf:about="#datasource-<?php print $source->datasrc_id; ?>">
                <dc:creator><?php print $source->authors; ?></dc:creator>
                <dc:title><?php print $source->title; ?></dc:title>
                <dc:date><?php print $source->year; ?></dc:date>

                <?php if (!empty($source->openurl)) { ?>
                    <owl:sameAs rdf:resource="<?php print str_replace("&", "&amp;", $source->openurl); ?>" />
                <?php } ?>

                <?php if (!empty($source->journal)) { ?>
                    <prism:publicationName><?php print $source->journal; ?></prism:publicationName>
                <?php } ?>

                <?php if (!empty($source->volume_city)) { ?>
                    <!-- Note: this may be a city name not a volume because of USDA data; we look at state data first -->s
                    <?php if (!$is_state) { ?>
                        <prism:volume><?php print $source->volume_city; ?></prism:volume>
                    <?php } else { ?>
                        <!-- City: <?php print $source->volume_city; ?> -->
                    <?php } ?>
                <?php } ?>

                <?php if (!empty($source->issue_state)) { ?>
                    <?php if (!$is_state) { ?>
                        <prism:issueIdentifier><?php print $source->issue_state; ?></prism:issueIdentifier>
                    <?php } else { ?>
                        <!-- State: <?php print $source->issue_state; ?> -->
                    <?php } ?>
                <?php } ?>


                <?php if (!empty($source->start_page)) { ?>
                    <prism:startingPage><?php print $source->start_page; ?></prism:startingPage>
                <?php } ?>

                <?php if (!empty($source->end_page)) { ?>
                    <prism:endingPage><?php print $source->end_page; ?></prism:endingPage>
                <?php } ?>
            </nutrition:DataSource>
        <?php } ?>
    <?php } ?>

    

    <?php foreach ($food->nutrients as $food_nutrient) { ?>
        <nutrition:FoodNutrient rdf:about="#foodnutrient-<?php print $food_nutrient->nbd_id; ?>-<?php print $food_nutrient->nutrient_id;?>">
            <nutrition:food rdf:resource="#food-<?php print $food_nutrient->nbd_id; ?>" />
            <nutrition:food rdf:resource="#nutrient-<?php print $food_nutrient->nutrient_id; ?>" />

            <nutrition:nutrient_amount><?php print $food_nutrient->nutrient_amount; ?></nutrition:nutrient_amount>
            <nutrition:samples><?php print $food_nutrient->samples; ?></nutrition:samples>

            <?php if (!empty($food_nutrient->std_error)) { ?>
                <nutrition:std_error><?php print $food_nutrient->std_error; ?></nutrition:std_error>
            <?php } ?>

            <nutrition:source_id><?php print $food_nutrient->source_id; ?></nutrition:source_id>

            <?php if (!empty($food_nutrient->derivation_id)) { ?>
                <!-- TODO: Remember what this is -->
                <nutrition:derivation_id><?php print $food_nutrient->derivation_id; ?></nutrition:derivation_id>
            <?php } ?>

            <?php if (!empty($food_nutrient->missing_item_nbd_id)) { ?>
                <!-- TODO: remember what the hell this is -->
                <nutrition:missing_item_nbd_id><?php print $food_nutrient->missing_item_nbd_id; ?></nutrition:missing_item_nbd_id>
            <?php } ?>

            <?php if (!empty($food_nutrient->total_studies)) { ?>
                <nutrition:total_studies><?php print $food_nutrient->total_studies; ?></nutrition:total_studies>
            <?php } ?>

            <?php if (!empty($food_nutrient->minimum)) { ?>
                <nutrition:minimum><?php print $food_nutrient->minimum; ?></nutrition:minimum>
            <?php } ?>

            <?php if (!empty($food_nutrient->maximum)) { ?>
                <nutrition:maximum><?php print $food_nutrient->maximum; ?></nutrition:maximum>
            <?php } ?>

            <?php if (!empty($food_nutrient->degress_of_freedom)) { ?>
                <nutrition:degrees_of_freedom><?php print $food_nutrient->degress_of_freedom; ?></nutrition:degrees_of_freedom>
            <?php } ?>

            <?php if (!empty($food_nutrient->error_bound_lower)) { ?>
                <nutrition:error_bound_lower><?php print $food_nutrient->error_bound_lower; ?></nutrition:error_bound_lower>
            <?php } ?>

            <?php if (!empty($food_nutrient->error_bound_upper)) { ?>
                <nutrition:error_bound_upper><?php print $food_nutrient->error_bound_upper; ?></nutrition:error_bound_upper>
            <?php } ?>

            <?php if (!empty($food_nutrient->statistical_comment)) { ?>
                <nutrition:statistical_comment><?php print $food_nutrient->statistical_comment; ?></nutrition:statistical_comment>
            <?php } ?>

            <?php if (!empty($food_nutrient->confidence_id)) { ?>
                <nutrition:confidence_id><?php print $food_nutrient->confidence_id; ?></nutrition:confidence_id>
            <?php } ?>
        </nutrition:FoodNutrient>

        <?php $nutrient = $food_nutrient->nutrient; ?>
        <nutrition:Nutrient rdf:about="#nutrient-<?php print $nutrient->nutrient_id; ?>">
            <!-- One day, find a semantic web spot that lists all of these! -->
            <dc:title><?php print $nutrient->title; ?></dc:title>
            <dc:description><?php print $nutrient->description; ?></dc:description>
            <nutrition:units><?php print $nutrient->units; ?></nutrition:units>
            <nutrition:decimals><?php print $nutrient->decimals; ?></nutrition:decimals>
            <nutrition:order><?php print $nutrient->order; ?></nutrition:order>

        </nutrition:Nutrient>
    <?php } ?>
</rdf:RDF>
<?php 
$xml = ob_get_clean();

$fmt = new XML_Beautifier();
print $fmt->formatString($xml);
?>
