<?php
require_once 'Area.php';

class AreaController {

    public function all(PDO $dbh) {
        $sql = 'SELECT area_id, area_name, polygon_coordinates, same_as_uri FROM areas ORDER BY area_name';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Area());

        return $stmt;
    }

    public function view(PDO $dbh, $id) {
        $sql = 'SELECT area_id, area_name, polygon_coordinates, same_as_uri FROM areas WHERE area_id = ' . $dbh->quote($id) . ' LIMIT 1';

        $stmt = $dbh->query($sql);

        $stmt->setFetchMode(PDO::FETCH_INTO, new Area());

        return $stmt->fetch();
    }

    public function create(PDO $dbh, Area $a) {
        $sql = 'INSERT INTO areas(area_id, area_name, polygon_coordinates, same_as_uri) VALUES(:area_id, :area_name, :polygon_coordinates, :same_as_uri)';

        $stmt = $dbh->prepare($sql);

        $data = array(
                    ':area_id' => $a->area_id,
                    ':area_name' => $a->area_name,
                    ':polygon_coordinates' => $a->polygon_coordinates,
                    ':same_as_uri' => $a->same_as_uri,
                );

        $stmt->execute($data);

        $h->ph_id = $dbh->lastInsertId();

        return $h;
    }

    public function remove(PDO $dbh, Area $a) {
        $sql = 'DELETE FROM area WHERE area_id = ' . $dbh->quote($a->area_id);

        return $dbh->query($sql);
    }
}