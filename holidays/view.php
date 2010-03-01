<?php
require 'require.php';

require_once 'HolidayController.php';


$controller = new HolidayController();

$h = $controller->view($dbh, $_GET['id']);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'remove') {
        $security->challenge($_SERVER);

        $controller->remove($dbh, $h);

        header('Location: ' . BASEADDRESS);
        die();
    }
}

include 'header.php';
?>

<div class="holiday">
    <h2><a href="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>"><?php print htmlentities($h->ph_name); ?></a></h2>
    <p><span class="date"><?php print $h->renderDate(); ?></span>
    Source: <a href="<?php print $h->source_uri; ?>" target="blank"><?php print $h->source_uri; ?></a></p>
    <p><a href="<?php print $h->guessWikipediaLink(); ?>" target="blank">Wikipedia</a></p>

    <form method="post">
        <input type="submit" name="action" value="remove" />
    </form>

    <?php if ($h->guessFreebaseID()) { ?>
        <div id="fbtb4132240678092071325" itemid="http://www.freebase.com/id<?php print $h->guessFreebaseID; ?>" itemscope="" itemtype="http://www.freebase.com/id/time/holiday">
            <div class="fbtb-frame">
                <div class="fbtb-title">
                    <a href="http://www.freebase.com/url?c=w&id=<?php print $h->guessFreebaseID(); ?>&mode=i&url=http://www.freebase.com/view<?php print $h->guessFreebaseID(); ?>&wid=topicblocks&wurl=http://www.freebase.com/widget/topic%3Fid%3D<?php print $h->guessFreebaseID(); ?>%26mode%3Di%26panes%3Dimage,full_info" target="_top">
                        <?php print htmlentities($h->ph_name); ?>
                    </a>
                </div>

                <div class="fbtb-content">
                    <div class="fbtb-pane fbtb-image-pane ">
                        <a href="http://www.freebase.com/url?c=w&id=<?php print $h->guessFreebaseID(); ?>&mode=i&url=http://www.freebase.com/view<?php print $h->guessFreebaseID(); ?>&wid=topicblocks&wurl=http://www.freebase.com/widget/topic%3Fid%3D<?php print $h->guessFreebaseID(); ?>%26mode%3Di%26panes%3Dimage,full_info" target="_top">
                            <img class="fbtb-img-150" height="150" src="http://img.freebase.com/api/trans/image_thumb<?php print $h->guessFreebaseID(); ?>?pad=1&errorid=%2Ffreebase%2Fno_image_png&maxheight=150&mode=fillcropmid&maxwidth=150" title="<?php print $h->ph_name; ?>" width="150" />
                        </a>
                    </div>
                </div>
                <div class="fbtb-get">
                    <a href="http://www.freebase.com/url?c=w&id=<?php print $h->guessFreebaseID(); ?>&mode=i&url=http://www.freebase.com/topicblocks%3Fid%3D<?php print $h->guessFreebaseID(); ?>%26mode%3Di%26panes%3Dimage,full_info%26utm_campaign%3Dtopicblocks%26utm_medium%3Dwww%26utm_source%3Dtopicblocks_getone&wid=topicblocks&wurl=http://www.freebase.com/widget/topic%3Fid%3D<?php print $h->guessFreebaseID(); ?>%26mode%3Di%26panes%3Dimage,full_info" target="_top">Get one for any topic!</a>
                </div>
            </div>
        </div>

    <style type="text/css">
        #fbtb4132240678092071325{position:relative;color:#666}
        #fbtb4132240678092071325 * div, #fbtb4132240678092071325 * img{text-align:left;vertical-align:baseline;font-family:"Helvetica Neue", Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;font-style:normal;line-height:1.3;border:0;outline:0;padding:0;margin:0}
        #fbtb4132240678092071325 a{color:#17b;text-decoration:none;border:0;outline:0;padding:0;margin:0}
        #fbtb4132240678092071325 a:hover{text-decoration:underline}
        #fbtb4132240678092071325 .fbtb-frame{width:212px;height:275px;background:#eee;-moz-border-radius:5px;-webkit-border-radius:5px}
        #fbtb4132240678092071325 .fbtb-title{padding:5px 10px;font-size:13px;font-weight:bold;line-height:1.6}
        #fbtb4132240678092071325 .fbtb-content{float:left;border:1px solid #ddd;border-top:1px solid #ccc;margin-left:5px;height:220px}
        #fbtb4132240678092071325 .fbtb-pane{float:left;width:200px;height:220px;overflow:auto;border-right:1px solid #ddd;background-color:#fff}
        #fbtb4132240678092071325 .fbtb-pane-last{border:0px}
        #fbtb4132240678092071325 .fbtb-get{clear:both;padding:5px 8px;line-height:1.1}
        #fbtb4132240678092071325 .fbtb-get a{color:#888;display:block;text-align:right;background:url(http://res.freebase.com/s/e19283a4edb40d4f6c030a6c6025b4e0ceae13c5c61e65d8fb17fc22431c2d42/resources/images/freebase-widget-attribution.png) no-repeat center left}
        #fbtb4132240678092071325 .fbtb-get a:hover{text-decoration:none;color:#f71;background:url(http://res.freebase.com/s/e19283a4edb40d4f6c030a6c6025b4e0ceae13c5c61e65d8fb17fc22431c2d42/resources/images/freebase-widget-attribution-over.png) no-repeat center left}
        #fbtb4132240678092071325 img{border:1px solid #ddd}
        #fbtb4132240678092071325 .fbtb-more{font-weight:bold;padding:0 0 0 4px}
        #fbtb4132240678092071325 .fbtb-head{clear:left;padding:0 6px;background-color:#f5f5f5;line-height:2;font-weight:bold;color:#777}
        #fbtb4132240678092071325 .fbtb-rule{border-top:1px solid #ccc}
        #fbtb4132240678092071325 .fbtb-properties{border-top:1px dotted #ccc;clear:both}
        #fbtb4132240678092071325 .fbtb-property{border-bottom:1px dotted #ccc;padding:4px 6px}
        #fbtb4132240678092071325 .fbtb-label{font-size:9px;font-weight:bold;color:#444;padding-right:4px}
        #fbtb4132240678092071325 .fbtb-image-pane{text-align:center}
        #fbtb4132240678092071325 .fbtb-img-150{width:150px;height:150px;margin:28px 0 0 0}
        #fbtb4132240678092071325 .fbtb-info-pane .fbtb-description{padding:6px 4px}
        #fbtb4132240678092071325 .fbtb-img-75{width:75px;height:75px;margin:2px 4px 2px 2px;float:left}
    </style>

    <img src="http://www.freebase.com/private/beacon?c=w&id=<?php print $h->guessFreebaseID(); ?>&mode=i&wid=topicblocks&wurl=http://www.freebase.com/widget/topic%3Fid%3D<?php print $h->guessFreebaseID(); ?>%26mode%3Di%26panes%3Dimage,full_info" style="position:absolute;top:0;left:0;border:0;outline:0;padding:0;margin:0;" />
    <?php } ?>
</div>
<?php
include 'footer.php';
