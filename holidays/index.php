<?php
require 'require.php';

require_once 'HolidayController.php';



$controller = new HolidayController();

$result = $controller->all_between($dbh, strtotime("now - 1 month"), strtotime("now + 2 months"));

$years = array(date("Y") - 1, date("Y"), date("Y") + 1);

include 'header.php';
?>
<script type="text/javascript">
//     Timeline_ajax_url="<?php print BASEADDRESS; ?>timeline/timeline_ajax/simile-ajax-api.js";
     Timeline_urlPrefix='http://api.simile-widgets.org/timeline/2.3.1/';
//     Timeline_parameters='bundle=true';
</script>

<script src="http://api.simile-widgets.org/timeline/2.3.1/timeline-api.js"
      type="text/javascript"></script>

<script type="text/javascript">
    var tl;
    window.onload = function() {
        var eventSource = new Timeline.DefaultEventSource();

        var zones = [
            {   start:    "Fri Nov 22 1963 00:00:00 GMT-0600",
                end:      "Mon Nov 25 1963 00:00:00 GMT-0600",
                magnify:  10,
                unit:     Timeline.DateTime.DAY
            },
            {   start:    "Fri Nov 22 1963 09:00:00 GMT-0600",
                end:      "Sun Nov 24 1963 00:00:00 GMT-0600",
                magnify:  5,
                unit:     Timeline.DateTime.HOUR
            },
            {   start:    "Fri Nov 22 1963 11:00:00 GMT-0600",
                end:      "Sat Nov 23 1963 00:00:00 GMT-0600",
                magnify:  5,
                unit:     Timeline.DateTime.MINUTE,
                multiple: 10
            },
            {   start:    "Fri Nov 22 1963 12:00:00 GMT-0600",
                end:      "Fri Nov 22 1963 14:00:00 GMT-0600",
                magnify:  3,
                unit:     Timeline.DateTime.MINUTE,
                multiple: 5
            }
        ];
        var zones2 = [
            {   start:    "Fri Nov 22 1963 00:00:00 GMT-0600",
                end:      "Mon Nov 25 1963 00:00:00 GMT-0600",
                magnify:  10,
                unit:     Timeline.DateTime.WEEK
            },
            {   start:    "Fri Nov 22 1963 09:00:00 GMT-0600",
                end:      "Sun Nov 24 1963 00:00:00 GMT-0600",
                magnify:  5,
                unit:     Timeline.DateTime.DAY
            },
            {   start:    "Fri Nov 22 1963 11:00:00 GMT-0600",
                end:      "Sat Nov 23 1963 00:00:00 GMT-0600",
                magnify:  5,
                unit:     Timeline.DateTime.MINUTE,
                multiple: 60
            },
            {   start:    "Fri Nov 22 1963 12:00:00 GMT-0600",
                end:      "Fri Nov 22 1963 14:00:00 GMT-0600",
                magnify:  3,
                unit:     Timeline.DateTime.MINUTE,
                multiple: 15
            }
        ];

        var theme = Timeline.ClassicTheme.create();
        theme.event.bubble.width = 250;

        var date = "<?php print date('r'); ?>"
        var bandInfos = [
            Timeline.createHotZoneBandInfo({
                width:          "80%",
                intervalUnit:   Timeline.DateTime.WEEK,
                intervalPixels: 220,
                zones:          zones,
                eventSource:    eventSource,
                date:           date,
                timeZone:       -6,
                theme:          theme
            }),
            Timeline.createHotZoneBandInfo({
                width:          "20%",
                intervalUnit:   Timeline.DateTime.MONTH,
                intervalPixels: 200,
                zones:          zones2,
                eventSource:    eventSource,
                date:           date,
                timeZone:       -6,
                overview:       true,
                theme:          theme
            })
        ];
        bandInfos[1].syncWith = 0;
        bandInfos[1].highlight = true;


        tl = Timeline.create(document.getElementById("tl"), bandInfos, Timeline.HORIZONTAL);
        tl.loadXML("timeline.php", function(xml, url) { eventSource.loadXML(xml, url); });
    }
    var resizeTimerID = null;
    window.onresize = function() {
        if (resizeTimerID == null) {
            resizeTimerID = window.setTimeout(function() {
                resizeTimerID = null;
                tl.layout();
            }, 500);
        }
    }



</script>
<h1>Holidays within Australia</h1>
<p>Gazetted public holidays within Australia. Need to <a href="add.php">add another</a> (check
<?php foreach ($years as $year) { ?>
    <a href="calculate.php?year=<?php print $year; ?>"><?php print $year; ?></a>
<?php } ?>)? Perhaps you should verify it with <a href="http://www.australia.gov.au/topics/australian-facts-and-figures/public-holidays">these sources</a>.</p>
<p>This is also available as <a href="rss.php">RSS 1.0</a>, <a href="csv.php">CSV</a> or <a href="ical.php">iCal</a>.</p>

<?php if (empty($result)) { ?>
    <p>No holidays available.</p>
<?php } ?>

<div id="tl" class="timeline-default" style="height: 300px;"></div>

<?php foreach ($result as $h) { ?>
    <div class="holiday">
        <h2><a href="<?php print BASEADDRESS; ?>view.php?id=<?php print $h->ph_id; ?>"><?php print !empty($h->ph_name)? htmlentities($h->ph_name) : "N/A"; ?></a></h2>
        <p><span class="date"><?php print $h->renderDate(); ?></span>
        Source: <a href="<?php print $h->source_uri; ?>"><?php print $h->source_uri; ?></a></p>
    </div>
<?php } ?>
<?php
include 'footer.php';