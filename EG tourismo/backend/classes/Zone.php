<?php
require_once 'Database.php';

class Zone {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllZones() {
        $stmt = $this->db->query("SELECT * FROM zones ORDER BY name");
        return $stmt->fetchAll();
    }

    public function getZoneById($id) {
        $stmt = $this->db->prepare("SELECT * FROM zones WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createZone($name, $description, $image = null) {
        $stmt = $this->db->prepare("
            INSERT INTO zones (name, description, image) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$name, $description, $image]);
    }

    public function updateZone($id, $name, $description, $image = null) {
        if ($image) {
            $stmt = $this->db->prepare("
                UPDATE zones 
                SET name = ?, description = ?, image = ?
                WHERE id = ?
            ");
            return $stmt->execute([$name, $description, $image, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE zones 
                SET name = ?, description = ?
                WHERE id = ?
            ");
            return $stmt->execute([$name, $description, $id]);
        }
    }

    public function deleteZone($id) {
        $stmt = $this->db->prepare("DELETE FROM zones WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getZoneWithCities($zoneId) {
        $stmt = $this->db->prepare("
            SELECT z.*, c.id as city_id, c.name as city_name, c.description as city_description, 
                   c.latitude, c.longitude, c.image as city_image
            FROM zones z
            LEFT JOIN cities c ON z.id = c.zone_id
            WHERE z.id = ?
            ORDER BY c.name
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }
} 