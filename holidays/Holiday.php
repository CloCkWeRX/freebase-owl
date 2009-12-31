<?php
class Holiday {

    public $ph_id;
    public $ph_date = 0;
    public $ph_name;
    public $ph_timezone = 'GMT';
    public $source_uri;


    /** @todo Shift to controller? */
    public function renderDate($format = "jS M Y e") {
        $date = new DateTime('@' . $this->ph_date);
        $date->setTimezone(new DateTimeZone($this->ph_timezone));

        return $date->format($format);
    }

    public function guessWikipediaLink() {
        $uri = 'http://en.wikipedia.org/wiki/';
        switch ($this->ph_name) {
            default:
                return $uri . $this->ph_name;
                break;
            case "Melbourne Cup Day":
                return $uri . "Melbourne_Cup_Day#Public_holiday";
            case "Labour Day":
                return $uri . "Labour_Day#Australia";
            case "Queen's Birthday":
                return $uri . "Queen's_Official_Birthday#Australia";
            case 'Brisbane Show Day':
                return $uri . 'Ekka';
            case 'Picnic Day':
                return $uri . 'Picnic_Day_(Australia_holiday)';
            case 'Proclamation Day':
                return $uri . 'Proclamation_Day#South_Australia';
            case 'Australia Day':
                return $uri . $this->ph_name;
            case 'Foundation Day':
                return $uri . 'Foundation_Day_(Western_Australia)';
        }
    }

    public function guessFreebaseID() {
        switch ($this->ph_name) {
            case "Melbourne Cup Day":
                return '/en/melbourne_cup';
            case "Labour Day":
                return '/en/labour_day';
            case "Queen's Birthday":
                return '/en/queens_official_birthday';
            case 'Brisbane Show Day':
                return '/en/ekka';
            case 'Picnic Day':
                return '/en/picnic_day';
            case 'Foundation Day':
                return '/en/foundation_day';
            case 'May Day':
                return '/en/may_day';
            case 'Eight Hours Day':
                return '/en/eight-hour_day';
            case 'Good Friday':
                return '/en/good_friday';
            case 'Easter Monday':
                return '/en/easter_monday';
            case 'Anzac Day':
                return '/en/anzac_day';
            case 'Proclamation Day':
            case 'Boxing Day':
                return '/en/boxing_day';
            case 'Christmas Day':
                return '/en/christmas';
            case 'Australia Day':
                return '/en/australia_day';
            case "New Year's Day":
                return '/en/new_years_day';
        }
    }
}
