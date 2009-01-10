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

    <?php if (!empty($food->acids)) { ?>
        <!-- Mmm, this should probably be remodelled as 'has_measurement' -->
        <!-- http://www.obofoundry.org/ro/ro.owl# -->
        <?php if (!empty($food->acids->acetic_acid)) { ?>
            <nutrition:acetic_acid><?php print $food->acids->acetic_acid; ?></nutrition:acetic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->butyric_acid)) { ?>
            <nutrition:butyric_acid><?php print $food->acids->butyric_acid; ?></nutrition:butyric_acid>
        <?php } ?>

        <?php if (!empty($food->acids->citric_acid)) { ?>
            <nutrition:citric_acid><?php print $food->acids->citric_acid; ?></nutrition:citric_acid>
        <?php } ?>

        <?php if (!empty($food->acids->fumaric_acid)) { ?>
            <nutrition:fumaric_acid><?php print $food->acids->fumaric_acid; ?></nutrition:fumaric_acid>
        <?php } ?>

        <?php if (!empty($food->acids->lactice_acid)) { ?>
            <nutrition:lactice_acid><?php print $food->acids->lactice_acid; ?></nutrition:lactice_acid>
        <?php } ?>

        <?php if (!empty($food->acids->malic_acid)) { ?>
            <nutrition:malic_acid><?php print $food->acids->malic_acid; ?></nutrition:malic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->oxalic_acid)) { ?>
            <nutrition:oxalic_acid><?php print $food->acids->oxalic_acid; ?></nutrition:oxalic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->propionic_acid)) { ?>
            <nutrition:propionic_acid><?php print $food->acids->propionic_acid; ?></nutrition:propionic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->quinic_acid)) { ?>
            <nutrition:quinic_acid><?php print $food->acids->quinic_acid;  ?></nutrition:quinic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->shikimic_acid)) { ?>
            <nutrition:shikimic_acid><?php print $food->acids->shikimic_acid; ?></nutrition:shikimic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->succinic_acid)) { ?>
            <nutrition:succinic_acid><?php print $food->acids->succinic_acid; ?></nutrition:succinic_acid>
        <?php } ?>

        <?php if (!empty($food->acids->tartaric_acid)) { ?>
            <nutrition:tartaric_acid><?php print $food->acids->tartaric_acid; ?></nutrition:tartaric_acid>
        <?php } ?>
    <?php } ?>

    <?php if (!empty($food->minerals)) { ?>
        <!-- Mmm, this should probably be remodelled as 'has_measurement' -->
        <!-- http://www.obofoundry.org/ro/ro.owl# -->
        <?php if (!empty($food->acids->aluminium)) { ?>
            <!-- ug -->
            <nutrition:aluminium><?php print $food->acids->aluminium; ?></nutrition:aluminium>
        <?php } ?>

        <?php if (!empty($food->acids->antimony)) { ?>
            <!-- ug -->
            <nutrition:antimony><?php print $food->acids->antimony; ?></nutrition:antimony>
        <?php } ?>

        <?php if (!empty($food->acids->arsenic)) { ?>
            <!-- ug -->
            <nutrition:arsenic><?php print $food->acids->arsenic; ?></nutrition:aluminium>
        <?php } ?>

        <?php if (!empty($food->acids->cadmium)) { ?>
            <!-- ug -->
            <nutrition:cadmium><?php print $food->acids->cadmium; ?></nutrition:cadmium>
        <?php } ?>

        <?php if (!empty($food->acids->calcium)) { ?>
            <!-- mg -->
            <nutrition:calcium><?php print $food->acids->calcium; ?></nutrition:calcium>
        <?php } ?>

        <?php if (!empty($food->acids->chromium)) { ?>
            <!-- ug -->
            <nutrition:chromium><?php print $food->acids->chromium; ?></nutrition:chromium>
        <?php } ?>

        <?php if (!empty($food->acids->cobalt)) { ?>
            <!-- ug -->
            <nutrition:cobalt><?php print $food->acids->cobalt; ?></nutrition:cobalt>
        <?php } ?>

        <?php if (!empty($food->acids->copper)) { ?>
            <!-- mg -->
            <nutrition:copper><?php print $food->acids->copper; ?></nutrition:copper>
        <?php } ?>

        <?php if (!empty($food->acids->fluoride)) { ?>
            <!-- ug -->
            <nutrition:fluoride><?php print $food->acids->fluoride; ?></nutrition:fluoride>
        <?php } ?>

        <?php if (!empty($food->acids->iodine)) { ?>
            <!-- ug -->
            <nutrition:iodine><?php print $food->acids->iodine; ?></nutrition:iodine>
        <?php } ?>

        <?php if (!empty($food->acids->iron)) { ?>
            <!-- mg -->
            <nutrition:iron><?php print $food->acids->iron; ?></nutrition:iron>
        <?php } ?>

        <?php if (!empty($food->acids->lead)) { ?>
            <!-- ug -->
            <nutrition:lead><?php print $food->acids->lead; ?></nutrition:lead>
        <?php } ?>

        <?php if (!empty($food->acids->magnesium)) { ?>
            <!-- mg -->
            <nutrition:magnesium><?php print $food->acids->magnesium; ?></nutrition:magnesium>
        <?php } ?>

        <?php if (!empty($food->acids->manganese)) { ?>
            <!-- mg -->
            <nutrition:manganese><?php print $food->acids->manganese; ?></nutrition:manganese>
        <?php } ?>

        <?php if (!empty($food->acids->mercury)) { ?>
            <!-- ug -->
            <nutrition:mercury><?php print $food->acids->mercury; ?></nutrition:mercury>
        <?php } ?>

        <?php if (!empty($food->acids->molybdenum)) { ?>
            <!-- ug -->
            <nutrition:molybdenum><?php print $food->acids->molybdenum; ?></nutrition:molybdenum>
        <?php } ?>

        <?php if (!empty($food->acids->nickel)) { ?>
            <!-- ug -->
            <nutrition:nickel><?php print $food->acids->nickel; ?></nutrition:nickel>
        <?php } ?>
 
        <?php if (!empty($food->acids->phosphorus)) { ?>
            <!-- mg -->
            <nutrition:phosphorus><?php print $food->acids->phosphorus; ?></nutrition:phosphorus>
        <?php } ?>

        <?php if (!empty($food->acids->potassium)) { ?>
            <!-- mg -->
            <nutrition:potassium><?php print $food->acids->potassium; ?></nutrition:potassium>
        <?php } ?>

        <?php if (!empty($food->acids->selenium)) { ?>
            <!-- ug -->
            <nutrition:selenium><?php print $food->acids->selenium; ?></nutrition:selenium>
        <?php } ?>

        <?php if (!empty($food->acids->sodium)) { ?>
            <!-- mg -->
            <nutrition:sodium><?php print $food->acids->sodium; ?></nutrition:sodium>
        <?php } ?>

        <?php if (!empty($food->acids->sulphur)) { ?>
            <!-- mg -->
            <nutrition:sulphur><?php print $food->acids->sulphur; ?></nutrition:sulphur>
        <?php } ?>

        <?php if (!empty($food->acids->tin)) { ?>
            <!-- ug -->
            <nutrition:tin><?php print $food->acids->tin; ?></nutrition:tin>
        <?php } ?>

        <?php if (!empty($food->acids->zinc)) { ?>
            <!-- mg -->
            <nutrition:zinc><?php print $food->acids->zinc; ?></nutrition:zinc>
        <?php } ?>


    <?php } ?>
</nutrition:Food>
