<?php
require_once 'Holiday.php';

class HolidayController {

    public function all(PDO $dbh) {
        $sql = 'SELECT ph_id, ph_date, ph_name, ph_timezone, source_uri FROM public_holidays ORDER BY ph_date DESC';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Holiday());

        return $stmt;
    }

    public function all_between(PDO $dbh, $start_date, $end_date) {
        $sql = 'SELECT ph_id, ph_date, ph_name, ph_timezone, source_uri FROM public_holidays WHERE ph_date BETWEEN ' . $dbh->quote((int)$start_date) . ' AND ' . $dbh->quote((int)$end_date) . ' ORDER BY ph_date DESC';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Holiday());

        return $stmt;
    }

    public function find_holiday(PDO $dbh, $start_date, $timezone) {

        $pre_start_date = (int)$start_date - (86400 * 3);
        $post_start_date = (int)$start_date + (86400 * 3);

        $sql = 'SELECT ph_id, ph_date, ph_name, ph_timezone, source_uri FROM public_holidays WHERE ph_date BETWEEN ' . $dbh->quote((int)$pre_start_date) . ' AND ' . $dbh->quote((int)$post_start_date) . ' AND ph_timezone = ' . $dbh->quote($timezone) . ' ORDER BY ph_date DESC';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Holiday());

        return $stmt;
    }

    public function view(PDO $dbh, $id) {
        $sql = 'SELECT ph_id, ph_date, ph_name, ph_timezone, source_uri FROM public_holidays WHERE ph_id = ' . $dbh->quote($id) . ' LIMIT 1';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Holiday());

        return $stmt->fetch();
    }

    public function create(PDO $dbh, Holiday $h) {
        $sql = 'INSERT INTO public_holidays(ph_date, ph_name, ph_timezone, source_uri) VALUES(:ph_date, :ph_name, :ph_timezone, :source_uri)';

        $stmt = $dbh->prepare($sql);

        $data = array(
                    ':ph_date' => $h->ph_date,
                    ':ph_name' => $h->ph_name,
                    ':ph_timezone' => $h->ph_timezone,
                    ':source_uri' => $h->source_uri,
                );

        $stmt->execute($data);

        $h->ph_id = $dbh->lastInsertId();

        return $h;
    }

    public function remove(PDO $dbh, Holiday $h) {
        $sql = 'DELETE FROM public_holidays WHERE ph_id = ' . $dbh->quote($h->ph_id);

        return $dbh->query($sql);
    }
}