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


ob_start();
?>
<rdf:RDF 
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:usda="http://lauken.com/doconnor/food/0.1/#"

    xmlns:dbpprop="http://dbpedia.org/property/">
    <usda:Food rdf:about="#food-<?php print $food->nbd_id; ?>">
        <dc:title><?php print $food->title; ?></dc:title>
        <dc:description><?php print $food->description; ?></dc:description>
        <usda:food_group rdf:resource="#foodgroup-<?php print $food->group_id; ?>" />

        <?php if (!empty($food->nitrogen_factor)) { ?>
            <usda:nitrogen_factor><?php print $food->nitrogen_factor; ?></usda:nitrogen_factor>
        <?php } ?>

        <?php if (!empty($food->protein_factor)) { ?>
            <usda:protein_factor><?php print $food->protein_factor; ?></usda:protein_factor>
        <?php } ?>

        <?php if (!empty($food->fat_factor)) { ?>
            <usda:fat_factor><?php print $food->fat_factor; ?></usda:fat_factor>
        <?php } ?>
        
        <?php if (!empty($food->carbohydrate_factor)) { ?>
            <usda:carbohydrate_factor><?php print $food->carbohydrate_factor; ?></usda:carbohydrate_factor>
        <?php } ?>

        <?php if (!empty($food->alias)) { ?>
            <dc:title><?php print $food->alias; ?></dc:title>
        <?php } ?>

        <?php if (!empty($food->company)) { ?>
            <foaf:maker><?php print $food->company; ?></foaf:maker>
        <?php } ?>

        <?php if (!empty($food->survey)) { ?>
            <usda:survey><?php print $food->survey; ?></usda:survey>
        <?php } ?>

        <?php if (!empty($food->refuse)) { ?>
            <usda:refuse><?php print $food->refuse; ?></usda:refuse>
        <?php } ?>

        <?php if (!empty($food->refuse_description)) { ?>
            <usda:refuse_description><?php print $food->refuse_description; ?></usda:refuse_description>
        <?php } ?>

        <?php if (!empty($food->scientific_name)) { ?>
            <dc:title><?php print $food->scientific_name; ?></dc:title>
        <?php } ?>
    </usda:Food>

    <usda:FoodGroup rdf:about="#foodgroup-<?php print $group->group_id; ?>">
        <dc:title><?php print $group->description; ?></dc:title>
    </usda:FoodGroup>

    <?php foreach ($food->weights as $weight) { ?>
        <usda:Weight rdf:about="#food-<?php print $weight->nbd_id; ?>-<?php print $weight->sequence; ?>">
            <usda:food rdf:resource="#food-<?php print $weight->nbd_id; ?>" />

            <usda:amount><?php print $weight->amount; ?></usda:amount>
            <dc:description><?php print $weight->description; ?></dc:description>

            <usda:grams><?php print $weight->grams; ?></usda:grams>
            <dbpprop:unit rdf:resource="http://dbpedia.org/resource/Gram" />

            <?php if (!empty($weight->samples)) { ?>
                <!-- TODO: map this to a 'number of samples' property -->
                <usda:samples><?php print $weight->samples; ?></usda:samples>
            <?php } ?>

            <?php if (!empty($weight->std_deviation)) { ?>
                <!-- TODO: map this to a 'std_deviation' property -->
                <usda:std_deviation><?php print $weight->std_deviation; ?></usda:std_deviation>
            <?php } ?>
        </usda:Weight>
    <?php } ?>

    <?php foreach ($food->footnotes as $footnote) { ?>
        <usda:Footnote rdf:about="#footnote-<?php print $footnote->nbd_id; ?>-<?php print $footnote->footnote_id; ?>">
            <usda:food rdf:resource="#food-<?php print $footnote->nbd_id; ?>" />

            <?php if (!empty($footnote->nutrient_id)) { ?>
                <usda:nutrient rdf:resource="#nutrient-<?php print $footnote->nutrient_id; ?>" />
            <?php } ?>

            <!-- TODO: map these back to better values -->
            <usda:type><?php print $footnote->type; ?></usda:type>
            <dc:description><?php print $footnote->description; ?></dc:description>
        </usda:Footnote>
    <?php } ?>

    <?php foreach ($food->data_links as $link) { ?>
        <usda:DataLink rdf:about="#datalink-<?php print $link->nbd_id; ?>-<?php print $link->datasrc_id; ?>">
            <usda:food rdf:resource="#food-<?php print $link->nbd_id; ?>" />
            <?php if (!empty($link->datasrc_id)) { ?>
                <usda:data_source rdf:resource="#datasource-<?php print $link->datasrc_id; ?>" />
            <?php } ?>

            <?php if (!empty($link->nutrient_id)) { ?>
                <usda:nutrient rdf:resource="#nutrient-<?php print $link->nutrient_id; ?>" />
            <?php } ?>
        </usda:DataLink>

        <?php if (!empty($link->datasrc_id)) { ?>

        <?php $source = $link->source; ?>
            <usda:DataSource rdf:about="#datasource-<?php print $source->datasrc_id; ?>">
                <dc:creator><?php print $source->authors; ?></dc:creator>
                <dc:title><?php print $source->title; ?></dc:title>
                <dc:date><?php print $source->year; ?></dc:date>
            
                <?php if (!empty($source->journal)) { ?>
                    <!-- Look up journal name? -->
                <?php } ?>


                <?php if (!empty($source->volume_city)) { ?>
                    <!-- Look up journal name? -->
                <?php } ?>


                <?php if (!empty($source->issue_state)) { ?>
                    <!-- Look up journal name? -->
                <?php } ?>


                <?php if (!empty($source->start_page)) { ?>
                    <!-- Look up journal name? -->
                <?php } ?>

                <?php if (!empty($source->end_page)) { ?>
                    <!-- Look up journal name? -->
                <?php } ?>
            </usda:DataSource>
        <?php } ?>
    <?php } ?>

    

    <?php foreach ($food->nutrients as $food_nutrient) { ?>
        <usda:FoodNutrient rdf:about="#foodnutrient-<?php print $food_nutrient->nbd_id; ?>-<?php print $food_nutrient->nutrient_id;?>">
            <usda:food rdf:resource="#food-<?php print $food_nutrient->nbd_id; ?>" />
            <usda:food rdf:resource="#nutrient-<?php print $food_nutrient->nutrient_id; ?>" />

            <usda:nutrient_amount><?php print $food_nutrient->nutrient_amount; ?></usda:nutrient_amount>
            <usda:samples><?php print $food_nutrient->samples; ?></usda:samples>

            <?php if (!empty($food_nutrient->std_error)) { ?>
                <usda:std_error><?php print $food_nutrient->std_error; ?></usda:std_error>
            <?php } ?>

            <usda:source_id><?php print $food_nutrient->source_id; ?></usda:source_id>

            <?php if (!empty($food_nutrient->derivation_id)) { ?>
                <!-- TODO: Remember what this is -->
                <usda:derivation_id><?php print $food_nutrient->derivation_id; ?></usda:derivation_id>
            <?php } ?>

            <?php if (!empty($food_nutrient->missing_item_nbd_id)) { ?>
                <!-- TODO: remember what the hell this is -->
                <usda:missing_item_nbd_id><?php print $food_nutrient->missing_item_nbd_id; ?></usda:missing_item_nbd_id>
            <?php } ?>

            <?php if (!empty($food_nutrient->total_studies)) { ?>
                <usda:total_studies><?php print $food_nutrient->total_studies; ?></usda:total_studies>
            <?php } ?>

            <?php if (!empty($food_nutrient->minimum)) { ?>
                <usda:minimum><?php print $food_nutrient->minimum; ?></usda:minimum>
            <?php } ?>

            <?php if (!empty($food_nutrient->maximum)) { ?>
                <usda:maximum><?php print $food_nutrient->maximum; ?></usda:maximum>
            <?php } ?>

            <?php if (!empty($food_nutrient->degress_of_freedom)) { ?>
                <usda:degrees_of_freedom><?php print $food_nutrient->degress_of_freedom; ?></usda:degrees_of_freedom>
            <?php } ?>

            <?php if (!empty($food_nutrient->error_bound_lower)) { ?>
                <usda:error_bound_lower><?php print $food_nutrient->error_bound_lower; ?></usda:error_bound_lower>
            <?php } ?>

            <?php if (!empty($food_nutrient->error_bound_upper)) { ?>
                <usda:error_bound_upper><?php print $food_nutrient->error_bound_upper; ?></usda:error_bound_upper>
            <?php } ?>

            <?php if (!empty($food_nutrient->statistical_comment)) { ?>
                <usda:statistical_comment><?php print $food_nutrient->statistical_comment; ?></usda:statistical_comment>
            <?php } ?>

            <?php if (!empty($food_nutrient->confidence_id)) { ?>
                <usda:confidence_id><?php print $food_nutrient->confidence_id; ?></usda:confidence_id>
            <?php } ?>
        </usda:FoodNutrient>

        <?php $nutrient = $food_nutrient->nutrient; ?>
        <usda:Nutrient rdf:about="#nutrient-<?php print $nutrient->nutrient_id; ?>">
            <!-- One day, find a semantic web spot that lists all of these! -->
            <dc:title><?php print $nutrient->title; ?></dc:title>
            <dc:description><?php print $nutrient->description; ?></dc:description>

            <!-- 
                TODO: map to SI units
                
                http://www.w3.org/2007/ont/unit ?
                http://dig.csail.mit.edu/breadcrumbs/node/198 ?

                g = http://dbpedia.org/page/Gram
                kcal / 1000 = http://dbpedia.org/page/Calorie
                mg / 1000 = http://dbpedia.org/page/Gram
                kj / 1000 = http://dbpedia.org/page/Joule
                mcg      
                IU       
                mcg_RAE  
                mcg_DFE  
             -->
            <usda:units><?php print $nutrient->units; ?></usda:units>

            <!-- Wow, someone should punch to wikipedia person who merged all pages about milligrams, etc into Gram -->
            <?php if ($nutrient->units == 'g') { ?>
                <dbpprop:unit rdf:resource="http://dbpedia.org/resource/Gram" />
            <?php } ?>

            <usda:decimals><?php print $nutrient->decimals; ?></usda:decimals>
            <usda:order><?php print $nutrient->order; ?></usda:order>

        </usda:Nutrient>
    <?php } ?>
</rdf:RDF>
<?php 
$xml = ob_get_clean();

$fmt = new XML_Beautifier();
print $fmt->formatString($xml);
?>
