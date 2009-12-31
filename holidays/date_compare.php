<?php
function date_compare(DateTime $a, DateTime $b) {
    if (version_compare(phpversion(), '5.2.2', '>=')) {
        return $a == $b;
    }

    return $a->format('U') == $b->format('U');
}