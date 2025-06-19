<?php
require_once 'Database.php';

class Restaurant {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAllRestaurants() {
        $stmt = $this->db->query("SELECT * FROM restaurante ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }
    
    public function getRestaurantById($id) {
        $stmt = $this->db->prepare("SELECT * FROM restaurante WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createRestaurant($data) {
        $stmt = $this->db->prepare("
            INSERT INTO restaurante (nombre, ubicacion, tipo_cocina, precio_medio, descripcion, horario, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'],
            $data['ubicacion'],
            $data['tipo_cocina'],
            $data['precio_medio'],
            $data['descripcion'],
            $data['horario'],
            $data['imagen']
        ]);
    }
    
    public function updateRestaurant($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE restaurante SET 
            nombre = ?,
            ubicacion = ?,
            tipo_cocina = ?,
            precio_medio = ?,
            descripcion = ?,
            horario = ?,
            imagen = COALESCE(?, imagen)
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'],
            $data['ubicacion'],
            $data['tipo_cocina'],
            $data['precio_medio'],
            $data['descripcion'],
            $data['horario'],
            $data['imagen'],
            $id
        ]);
    }
    
    public function deleteRestaurant($id) {
        $stmt = $this->db->prepare("DELETE FROM restaurante WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getRestaurantsByZone($zoneId) {
        $stmt = $this->db->prepare("
            SELECT r.* 
            FROM restaurante r
            JOIN zona_restaurante zr ON r.id = zr.restaurante_id
            WHERE zr.zona_id = ?
            ORDER BY r.nombre
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function linkToZone($zoneId, $restaurantId) {
        $stmt = $this->db->prepare("
            INSERT INTO zona_restaurante (zona_id, restaurante_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$zoneId, $restaurantId]);
    }

    public function unlinkFromZone($zoneId, $restaurantId) {
        $stmt = $this->db->prepare("
            DELETE FROM zona_restaurante 
            WHERE zona_id = ? AND restaurante_id = ?
        ");
        return $stmt->execute([$zoneId, $restaurantId]);
    }
} 