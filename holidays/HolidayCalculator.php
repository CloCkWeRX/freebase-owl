<?php
require_once 'date_compare.php';

class HolidayCalculator {
    protected $holidays;

    protected $timezones = array();

    public function __construct() {
        $this->timezones["ACT"] = "Australia/Canberra";
        $this->timezones["NT"]  = "Australia/Darwin";
        $this->timezones["SA"]  = "Australia/Adelaide";
        $this->timezones["TAS"] = "Australia/Hobart";
        $this->timezones["QLD"] = "Australia/Brisbane";
        $this->timezones["WA"]  = "Australia/Perth";
        $this->timezones["VIC"] = "Australia/Melbourne";
        $this->timezones["NSW"] = "Australia/Sydney";
    }

    public function is(DateTime $date, $holidays = array()) {
        $ndate = clone $date;
        $ndate->setTime(0, 0, 0);
        foreach ($holidays as $holiday) {
            if (date_compare($holiday, $ndate)) {
                return true;
            }
        }
        return false;
    }

    /**
     * New Year's Day
     */
    protected function calculateNewYearsDay($year, $states = array()) {
        $dates = array();

        //New Year's Day.
        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime($year . '-01-01', $tz);
            $end   = new DateTime($year . '-01-02', $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("New Year's Day", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Australia Day
     */
    protected function calculateAustraliaDay($year, $states = array()) {
        $dates = array();

        //Australia Day.
        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime($year . '-01-26', $tz);
            $end   = new DateTime($year . '-01-27', $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Australia Day", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Anzac Day
     */
    protected function calculateAnzacDay($year, $states = array()) {
        $dates = array();

        //Anzac Day.
        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime($year . '-04-25', $tz);
            $end   = new DateTime($year . '-04-26', $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Anzac Day", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Christmas Day.
     */
    protected function calculateChristmasDay($year, $states = array()) {
        $dates = array();

        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime($year . '-12-25', $tz);
            $end   = new DateTime($year . '-12-26', $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Christmas Day", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Queen's Birthday - 2nd Monday in June (except WA: 1 Monday in October)
     */
    protected function calculateQueensBirthday($year, $states = array()) {
        $dates = array();

        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            switch ($state) {
                case "WA":
                    $n      = 1; //First
                    $dow    = 1; //Monday
                    $month  = 10; //October
                    break;
                default:
                    $n      = 2; //Second
                    $dow    = 1; //Monday
                    $month  = 6; //June
                    break;
            }
            $calc = new Date_Calc();

            $secondMonday = $calc->NWeekdayOfMonth($n, $dow, $month, $year, "%d");
            $secondTuesday = $calc->nextDay($secondMonday, $month, $year, "%d");

            $tz = new DateTimeZone($timezoneName);

            $start  = new DateTime($year . '-' . $month . '-' . $secondMonday, $tz);
            $end    = new DateTime($year . '-' . $month . '-' . $secondTuesday, $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Queen's Birthday", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Calculate Good Friday
     */
    protected function calculateGoodFriday($year, $states = array()) {

        $dates = array();
        $timestamp =  easter_date($year);
        $date = new DateTime('@' . $timestamp);


        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime();
            $start->setTimezone($tz);
            $start->setDate($date->format("Y"), $date->format("m"), $date->format("d"));
            $start->modify("-1 day");
            $start->setTime(0, 00, 00);

            $end = new DateTime();
            $end->setTimezone($tz);
            $end->setDate($date->format("Y"), $date->format("m"), $date->format("d"));
            $end->setTime(0, 00, 00);

            $dates[] = array("Good Friday", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;

    }

    /**
     * Calculate Easter Monday
     */
    protected function calculateEasterMonday($year, $states = array()) {

        $dates = array();
        $timestamp =  easter_date($year);
        $date = new DateTime('@' . $timestamp);


        foreach ($states as $state => $timezoneName) {
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime();
            $start->setTimezone($tz);
            $start->setDate($date->format("Y"), $date->format("m"), $date->format("d"));
            $start->modify("+2 day");
            $start->setTime(00, 00, 00);

            $end = new DateTime();
            $end->setTimezone($tz);
            $end->setDate($date->format("Y"), $date->format("m"), $date->format("d"));
            $end->modify("+3 day");
            $end->setTime(00, 00, 00);

            $dates[] = array("Easter Monday", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;

    }

    /**
     * @see calculateLabourDay()
     */
    protected function calculateLaborDay($year) {
        return $this->calculateLabourDay($year);
    }

    /**
     * The Labour Day public holiday is fixed by the various states and territories' governments, and so varies considerably.
     *
     * The first Monday in October in the Australian Capital Territory, New South Wales and South Australia
     * The second Monday in March in both Victoria and Tasmania
     * The first Monday in March in Western Australia
     * The first Monday in May in both Queensland and the Northern Territory
     */
    protected function calculateLabourDay($year, $states = array()) {
        $dates = array();


        foreach ($states as $state => $timezoneName) {
            $calc = new Date_Calc();
            switch ($state) {
                case "ACT":
                case "NSW":
                case "SA":
                    //The first Monday in October in the Australian Capital Territory, New South Wales and South Australia
                    $n      = 1; //First
                    $dow    = 1; //Monday
                    $month  = 10; //October
                    break;

                case "TAS":
                case "VIC":
                    //The second Monday in March in both Victoria and Tasmania
                    $n      = 2; //Second
                    $dow    = 1; //Monday
                    $month  = 3; //March
                    break;

                case "WA":
                    // The first Monday in March in Western Australia
                    $n      = 1; //First
                    $dow    = 1; //Monday
                    $month  = 3; //March
                    break;
                case "QLD":
                case "NT":
                    //The first Monday in May in both Queensland and the Northern Territory
                    $n      = 1; //First
                    $dow    = 1; //Monday;
                    $month  = 5; //May
                    break;
                default:
                    //EERGGH!

                    break;
            }

            $nDayOfMonth = $calc->NWeekdayOfMonth($n, $dow, $month, $year, "%d");
            $dayAfter   =  $calc->nextDay($nDayOfMonth, $month, $year, "%d");

            $tz = new DateTimeZone($timezoneName);
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $start  = new DateTime($year . '-' . $month . '-' . $nDayOfMonth, $tz);
            $end    = new DateTime($year . '-' . $month . '-' . $dayAfter, $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Labour Day", $state, $start->format('U'), $end->format('U'));
        }

        return $dates;
    }

    /**
     * Proclamation Day - SA only.
     *
     * The first working (week?) day after christmas.
     */
    protected function calculateProclamationDay($year, $states = array()) {
        $dates = array();

        $timezoneName = $states["SA"];
        $state        = "SA";

        $calc = new Date_Calc();

        if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
            throw new Exception("Unknown Timezone Name: " . $timezoneName);
        }
        $tz = new DateTimeZone($timezoneName);

        $boxingDay      = $calc->nextWeekday(25, 12, $year, "%d");
        $endBoxingDay   = $calc->nextDay($boxingDay, 12, $year, "%d");

        $start = new DateTime($year . '-12-' . $boxingDay, $tz);
        $end   = new DateTime($year . '-12-' . $endBoxingDay, $tz);

        $start->setTimezone($tz);
        $end->setTimezone($tz);

        $dates[] = array("Proclamation Day", $state, $start->format('U'), $end->format('U'));

        return $dates;
    }

    /**
     * Boxing Day is a public holiday observed in many Commonwealth countries on the first day
     * (other than Sunday) following Christmas Day.
     *
     * Except for SA.
     */
    protected function calculateBoxingDay($year, $states = array()) {
        $dates = array();

        $calc = new Date_Calc();
        $boxingDay = $calc->nextDay(25, 12, $year, "%d");
        while ($calc->getWeekdayFullName($boxingDay, 12, $year) == "Sunday") {
            $boxingDay = $calc->nextDay($boxingDay, 12, $year, "%d");
        }

        $endBoxingDay   = $calc->nextDay($boxingDay, 12, $year, "%d");


        foreach ($states as $state => $timezoneName) {
            if ($state == "SA") {
                continue;
            }
            if (!in_array($timezoneName, DateTimeZone::listIdentifiers())) {
                throw new Exception("Unknown Timezone Name: " . $timezoneName);
            }

            $tz = new DateTimeZone($timezoneName);

            $start = new DateTime($year . '-12-' . $boxingDay, $tz);
            $end   = new DateTime($year . '-12-' . $endBoxingDay, $tz);

            $start->setTimezone($tz);
            $end->setTimezone($tz);

            $dates[] = array("Boxing Day", $state, $start->format('U'), $end->format('U'));

        }

        return $dates;
    }

    /**
     * For the Holidays which can be calculated by a rule; return an array of
     * title, state_id, and holiday start, end date.
     *
     * You should always combine these results with database results, as individual years
     * may have exceptions.
     *
     * Handles: New Years Day, Australia Day, Anzac Day, Christmas Day, Queens Birthday,
     * Labour Day, Proclamation Day, Boxing Day
     *
     * @see     http://en.wikipedia.org/wiki/Public_holidays_in_Australia
     * @return  mixed[]
     */
    public function calculateHolidayDates($year) {
        $dates = array();

        $states = $this->timezones;

        $dates = array_merge($dates, $this->calculateNewYearsDay($year, $states));
        $dates = array_merge($dates, $this->calculateAustraliaDay($year, $states));
        $dates = array_merge($dates, $this->calculateAnzacDay($year, $states));
        $dates = array_merge($dates, $this->calculateChristmasDay($year, $states));
        $dates = array_merge($dates, $this->calculateQueensBirthday($year, $states));
        $dates = array_merge($dates, $this->calculateLabourDay($year, $states));
        $dates = array_merge($dates, $this->calculateProclamationDay($year, $states));
        $dates = array_merge($dates, $this->calculateBoxingDay($year, $states));
        $dates = array_merge($dates, $this->calculateGoodFriday($year, $states));
        $dates = array_merge($dates, $this->calculateEasterMonday($year, $states));

        return $dates;
    }

}
