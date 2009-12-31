<?php
if (empty($title)) {
    $title = "Australian Public Holidays";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php print htmlentities($title); ?></title>
        <link rel="alternate" href="<?php print BASEADDRESS; ?>rss.php" title="RSS feed" type="application/rss+xml" />
        <link rel="stylesheet" href="<?php print BASEADDRESS; ?>style.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/calendar/assets/skins/sam/calendar.css">

        <script  type="text/javascript"  src="/modernizr-1.1.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/calendar/calendar-min.js"></script>

        <script type="text/javascript">
        /** @see http://delete.me.uk/2005/03/iso8601.html */
        Date.prototype.setISO8601 = function (string) {
            var regexp = "([0-9]{4})(-([0-9]{2})(-([0-9]{2})" +
                "(T([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?" +
                "(Z|(([-+])([0-9]{2}):([0-9]{2})))?)?)?)?";
            var d = string.match(new RegExp(regexp));

            var offset = 0;
            var date = new Date(d[1], 0, 1);

            if (d[3]) { date.setMonth(d[3] - 1); }
            if (d[5]) { date.setDate(d[5]); }
            if (d[7]) { date.setHours(d[7]); }
            if (d[8]) { date.setMinutes(d[8]); }
            if (d[10]) { date.setSeconds(d[10]); }
            if (d[12]) { date.setMilliseconds(Number("0." + d[12]) * 1000); }
            if (d[14]) {
                offset = (Number(d[16]) * 60) + Number(d[17]);
                offset *= ((d[15] == '-') ? 1 : -1);
            }

            offset -= date.getTimezoneOffset();
            time = (Number(date) + (offset * 60 * 1000));
            this.setTime(Number(time));
        }
        </script>
    </head>

    <body>
        <div id="header">
            <h1><a href="/"><?php print htmlentities($title); ?></a></h1>

        </div>

        <?php if (!empty($e)) { ?>
            <div class="flash error"><?php print $e; ?></div>
        <?php } ?>

        <div id="content">