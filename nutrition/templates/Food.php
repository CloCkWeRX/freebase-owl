<nutrition:Food rdf:about="#food-<?php print $food->getID(); ?>">
    <dc:title><?php print $food->title; ?></dc:title>
    <dc:description><?php print $food->description; ?></dc:description>

    <?php if (!empty($food->alias)) { ?>
        <dc:title><?php print $food->alias; ?></dc:title>
    <?php } ?>

    <?php if (!empty($food->company)) { ?>
        <foaf:maker><?php print $food->company; ?></foaf:maker>
    <?php } ?>



    <!-- Groups -->
    <?php if (!empty($food->group_name)) { ?>
        <nutrition:food_group rdf:resource="#foodgroup-<?php print $food->group_name; ?>" />
    <?php } ?>

    <?php if (!empty($food->sub_group_name)) { ?>
        <nutrition:food_group rdf:resource="#foodgroup-<?php print $food->sub_group_name; ?>" />
    <?php } ?>

    <?php if (!empty($food->group_id)) { ?>
        <nutrition:food_group rdf:resource="#foodgroup-<?php print $food->group_id; ?>" />
    <?php } ?>

    <!-- Factors -->
    <?php if (!empty($food->nitrogen_factor)) { ?>
        <nutrition:nitrogen_factor><?php print $food->nitrogen_factor; ?></nutrition:nitrogen_factor>
    <?php } ?>

    <?php if (!empty($food->protein_factor)) { ?>
        <nutrition:protein_factor><?php print $food->protein_factor; ?></nutrition:protein_factor>
    <?php } ?>

    <?php if (!empty($food->fat_factor)) { ?>
        <nutrition:fat_factor><?php print $food->fat_factor; ?></nutrition:fat_factor>
    <?php } ?>
    
    <?php if (!empty($food->carbohydrate_factor)) { ?>
        <nutrition:carbohydrate_factor><?php print $food->carbohydrate_factor; ?></nutrition:carbohydrate_factor>
    <?php } ?>

    <!-- about the study -->
    <?php if (!empty($food->survey)) { ?>
        <nutrition:survey><?php print $food->survey; ?></nutrition:survey>
    <?php } ?>

    <?php if (!empty($food->refuse)) { ?>
        <nutrition:refuse><?php print $food->refuse; ?></nutrition:refuse>
    <?php } ?>

    <?php if (!empty($food->refuse_description)) { ?>
        <nutrition:refuse_description><?php print $food->refuse_description; ?></nutrition:refuse_description>
    <?php } ?>

    <?php if (!empty($food->edible_description)) { ?>
        <nutrition:edible_description><?php print $food->edible_description; ?></nutrition:edible_description>
    <?php } ?>

    <?php if (!empty($food->derivation)) { ?>
        <nutrition:derivation><?php print $food->derivation; ?></nutrition:derivation>
    <?php } ?>

    <?php if (!empty($food->scientific_name)) { ?>
        <dc:title><?php print $food->scientific_name; ?></dc:title>
    <?php } ?>
</nutrition:Food>
