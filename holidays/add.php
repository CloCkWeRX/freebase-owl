<?php
require 'require.php';

require_once 'HolidayController.php';


$controller = new HolidayController();

$h = new Holiday();
if (!empty($_POST['action']) && $_POST['action'] == 'add') {

    try {
        if (empty($_POST['ph_name'])) {
            throw new Exception("Name is required");
        }

        if (empty($_POST['ph_timezone'])) {
            throw new Exception("Timezone is required");
        }

        if (empty($_POST['ph_date'])) {
            throw new Exception("Date is required");
        }


        if (empty($_POST['source_uri'])) {
            throw new Exception("Source link is required");
        }

        $tz = new DateTimeZone($_POST['ph_timezone']);
        $date = new DateTime($_POST['ph_date'], $tz);

        $h->ph_date = $date->format('U');
        $h->ph_timezone = $_POST['ph_timezone'];
        $h->ph_name = $_POST['ph_name'];
        $h->source_uri = $_POST['source_uri'];



        $another_h = $controller->create($dbh, $h);

        header('Location: view.php?id=' . $another_h->ph_id);
        die();
    } catch (Exception $e) {
    }
}


include 'header.php';

?>
<div class="holiday yui-skin-sam">
    <h2>Add Holiday</h2>
    <p>Perhaps you should verify it with <a href="http://www.australia.gov.au/topics/australian-facts-and-figures/public-holidays">these sources</a>.</p>
    <form method="post">
        <div id="cal1Container" style="float: right"></div>
        <p>Name:<br /><input type="text" name="ph_name" value="<?php print htmlentities($h->ph_name); ?>" /></p>
        <p>Date:<br /><input id="ph_date" type="date" value="<?php print htmlentities($h->renderDate("Y-m-d")); ?>" name="ph_date" /></p>
        <p>Source Link:<br /><input id="source_uri" type="text" value="<?php print htmlentities($h->source_uri); ?>" name="source_uri" /></p>

        <p>Timezone:<br />
        <select name="ph_timezone">
            <option>Australia/Adelaide</option>
            <option>Australia/Melbourne</option>
            <option>Australia/Brisbane</option>
            <option>Australia/Perth</option>
            <option>Australia/Sydney</option>
            <!-- Todo: more -->
        </select>
        </p>
        <p>
            <input type="submit" name="action" value="add" />
        </p>
    </form>
</div>

<div style="clear:both"></div>





<script type="text/javascript">

if (!Modernizr.inputtypes.date) {


    YAHOO.namespace("example.calendar");

    YAHOO.example.calendar.init = function() {

        function handleSelect(type,args,obj) {
            var dates = args[0];
            var date = dates[0];
            var year = parseInt(date[0]), month = parseInt(date[1]), day = parseInt(date[2]);

            var txtDate1 = document.getElementById("ph_date");
            txtDate1.value = year + "-" + month + "-" + day;
        }

        function updateCal() {
            var txtDate1 = document.getElementById("ph_date");

            if (txtDate1.value != "") {
                var date = new Date();
                date.setISO8601(txtDate1.value);
                console.log(date);
                YAHOO.example.calendar.cal1.select(date);

                var selectedDates = YAHOO.example.calendar.cal1.getSelectedDates();
                if (selectedDates.length > 0) {
                    var firstDate = selectedDates[0];
                    YAHOO.example.calendar.cal1.cfg.setProperty("pagedate", (firstDate.getMonth()+1) + "-" + firstDate.getFullYear());
                    YAHOO.example.calendar.cal1.render();
                }
            }
        }

        YAHOO.example.calendar.cal1 = new YAHOO.widget.Calendar("cal1","cal1Container", { });
        YAHOO.example.calendar.cal1.selectEvent.subscribe(handleSelect, YAHOO.example.calendar.cal1, true);
        YAHOO.example.calendar.cal1.render();


        YAHOO.example.calendar.cal1.cfg.setProperty("DATE_FIELD_DELIMITER", "-");

        YAHOO.example.calendar.cal1.cfg.setProperty("MDY_DAY_POSITION", 3);
        YAHOO.example.calendar.cal1.cfg.setProperty("MDY_MONTH_POSITION", 2);
        YAHOO.example.calendar.cal1.cfg.setProperty("MDY_YEAR_POSITION", 1);
        YAHOO.example.calendar.cal1.this.updateCal();


        YAHOO.util.Event.addListener("ph_date", "blur", updateCal);
    }

    YAHOO.util.Event.onDOMReady(YAHOO.example.calendar.init);
}
</script>

<?php
include 'footer.php';
