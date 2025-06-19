<?php
require_once 'Database.php';

class City {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllCities() {
        $stmt = $this->db->query("SELECT c.*, z.name as zone_name FROM cities c JOIN zones z ON c.zone_id = z.id ORDER BY c.name");
        return $stmt->fetchAll();
    }

    public function getCityById($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, z.name as zone_name 
            FROM cities c 
            JOIN zones z ON c.zone_id = z.id 
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getCitiesByZone($zoneId) {
        $stmt = $this->db->prepare("SELECT * FROM cities WHERE zone_id = ? ORDER BY name");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function createCity($zoneId, $name, $description, $latitude = null, $longitude = null, $image = null) {
        $stmt = $this->db->prepare("
            INSERT INTO cities (zone_id, name, description, latitude, longitude, image) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$zoneId, $name, $description, $latitude, $longitude, $image]);
    }

    public function updateCity($id, $zoneId, $name, $description, $latitude = null, $longitude = null, $image = null) {
        if ($image) {
            $stmt = $this->db->prepare("
                UPDATE cities 
                SET zone_id = ?, name = ?, description = ?, latitude = ?, longitude = ?, image = ?
                WHERE id = ?
            ");
            return $stmt->execute([$zoneId, $name, $description, $latitude, $longitude, $image, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE cities 
                SET zone_id = ?, name = ?, description = ?, latitude = ?, longitude = ?
                WHERE id = ?
            ");
            return $stmt->execute([$zoneId, $name, $description, $latitude, $longitude, $id]);
        }
    }

    public function deleteCity($id) {
        $stmt = $this->db->prepare("DELETE FROM cities WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCityServices($cityId) {
        return [
            'hotels' => $this->getCityHotels($cityId),
            'restaurants' => $this->getCityRestaurants($cityId),
            'transport' => $this->getCityTransport($cityId),
            'activities' => $this->getCityActivities($cityId),
            'gallery' => $this->getCityGallery($cityId)
        ];
    }

    private function getCityHotels($cityId) {
        $stmt = $this->db->prepare("SELECT * FROM city_hotels WHERE city_id = ? ORDER BY name");
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }

    private function getCityRestaurants($cityId) {
        $stmt = $this->db->prepare("SELECT * FROM city_restaurants WHERE city_id = ? ORDER BY name");
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }

    private function getCityTransport($cityId) {
        $stmt = $this->db->prepare("SELECT * FROM city_transport WHERE city_id = ? ORDER BY name");
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }

    private function getCityActivities($cityId) {
        $stmt = $this->db->prepare("SELECT * FROM city_activities WHERE city_id = ? ORDER BY name");
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }

    private function getCityGallery($cityId) {
        $stmt = $this->db->prepare("SELECT * FROM city_gallery WHERE city_id = ? ORDER BY created_at DESC");
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }
} 