<?php
require_once 'Database.php';

class Service {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Category Methods
    public function createCategory($data) {
        $stmt = $this->db->prepare("INSERT INTO servicios (nombre, precio, d_servicio) VALUES (?, ?, ?)");
        return $stmt->execute([$data['nombre'], $data['precio'], $data['d_servicio']]);
    }
    
    public function updateCategory($data) {
        $stmt = $this->db->prepare("UPDATE service_categories SET name = ?, slug = ?, icon = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'], $data['precio'], $data['d_servicio'], $data['id']]);
    }
    
    public function deleteCategory($id) {
        // First delete all services in this category
        $stmt = $this->db->prepare("DELETE FROM servicios WHERE id = ?");
        $stmt->execute([$id]);
        
        // Then delete the category
        $stmt = $this->db->prepare("DELETE FROM service_categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM servicios ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }
    
    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getCategoryBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE guia_turist = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    // Service Methods
    public function createService($nombre, $descripcion, $precio, $guia_turist, $telefono, $correo, $d_servicio) {
        $stmt = $this->db->prepare("
            INSERT INTO servicios (
                nombre, descripcion, precio, guia_turist, 
                telefono, correo, d_servicio
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute(
            $nombre,
            $descripcion,
            $precio,
            $guia_turist,
            $telefono,
            $correo,
            $d_servicio
        );
    }
    
    public function updateService($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE servicios 
            SET nombre = ?, descripcion = ?, precio = ?, 
                guia_turist = ?, telefono = ?, correo = ?, d_servicio = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['guia_turist'],
            $data['telefono'],
            $data['correo'],
            $data['d_servicio'],
            $id
        ]);
    }
    
    public function deleteService($id) {
        $stmt = $this->db->prepare("DELETE FROM servicios WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAllServices() {
        $stmt = $this->db->query("SELECT * FROM servicios ORDER BY nombre");
        return $stmt->fetchAll();
    }
    
    public function getServiceById($id) {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getServicesByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE category_id = ? ORDER BY name ASC");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    
    public function searchServices($query) {
        $searchTerm = "%{$query}%";
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as category_name, c.icon as category_icon 
            FROM servicios s 
            JOIN service_categories c ON s.category_id = c.id 
            WHERE s.name LIKE ? OR s.description LIKE ? OR s.location LIKE ? 
            ORDER BY s.name ASC
        ");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getServiceImages($serviceId) {
        $stmt = $this->db->prepare("
            SELECT * FROM galeria_multimedia 
            WHERE entity_type = 'servicios' AND entity_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$serviceId]);
        return $stmt->fetchAll();
    }
    
    public function getServiceReviews($serviceId) {
        $stmt = $this->db->prepare("
            SELECT * FROM servicios 
            WHERE service_id = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$serviceId]);
        return $stmt->fetchAll();
    }
    
    public function addServiceImage($serviceId, $imagePath, $description = '') {
        $stmt = $this->db->prepare("
            INSERT INTO galeria_multimedia (url_img, descripcion, entity_type, entity_id) 
            VALUES (?, ?, 'servicios', ?)
        ");
        return $stmt->execute([$imagePath, $description, $serviceId]);
    }
    
    public function deleteServiceImage($imageId) {
        $stmt = $this->db->prepare("DELETE FROM galeria_multimedia WHERE id = ?");
        return $stmt->execute([$imageId]);
    }
    
    public function setMainServiceImage($serviceId, $imageId) {
        // First, unset any existing main image
        $stmt = $this->db->prepare("
            UPDATE service_images 
            SET is_main = FALSE 
            WHERE service_id = ?
        ");
        $stmt->execute([$serviceId]);
        
        // Then set the new main image
        $stmt = $this->db->prepare("
            UPDATE service_images 
            SET is_main = TRUE 
            WHERE id = ? AND service_id = ?
        ");
        return $stmt->execute([$imageId, $serviceId]);
    }
    
    public function addReview($serviceId, $userName, $rating, $comment) {
        $stmt = $this->db->prepare("
            INSERT INTO service_reviews (service_id, user_name, rating, comment) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$serviceId, $userName, $rating, $comment]);
    }
    
    public function getAverageRating($serviceId) {
        $stmt = $this->db->prepare("
            SELECT AVG(rating) as average_rating 
            FROM service_reviews 
            WHERE service_id = ?
        ");
        $stmt->execute([$serviceId]);
        $result = $stmt->fetch();
        return $result['average_rating'] ? round($result['average_rating'], 1) : 0;
    }
    
    public function getServiceZones($serviceId) {
        $stmt = $this->db->prepare("
            SELECT z.* 
            FROM zona_turismo z 
            JOIN zona_servicio zs ON z.id = zs.zona_id 
            WHERE zs.servicio_id = ?
            ORDER BY z.nombre
        ");
        $stmt->execute([$serviceId]);
        return $stmt->fetchAll();
    }
    
    public function getServiceHotels($serviceId) {
        $stmt = $this->db->prepare("
            SELECT h.* 
            FROM hotel h 
            JOIN hotel_servicio hs ON h.id = hs.hotel_id 
            WHERE hs.servicio_id = ?
            ORDER BY h.nom_hotel
        ");
        $stmt->execute([$serviceId]);
        return $stmt->fetchAll();
    }
    
    public function linkZone($serviceId, $zoneId) {
        $stmt = $this->db->prepare("
            INSERT INTO zona_servicio (servicio_id, zona_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$serviceId, $zoneId]);
    }
    
    public function unlinkZone($serviceId, $zoneId) {
        $stmt = $this->db->prepare("
            DELETE FROM zona_servicio 
            WHERE servicio_id = ? AND zona_id = ?
        ");
        return $stmt->execute([$serviceId, $zoneId]);
    }
    
    public function linkHotel($serviceId, $hotelId) {
        $stmt = $this->db->prepare("
            INSERT INTO hotel_servicio (servicio_id, hotel_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$serviceId, $hotelId]);
    }
    
    public function unlinkHotel($serviceId, $hotelId) {
        $stmt = $this->db->prepare("
            DELETE FROM hotel_servicio 
            WHERE servicio_id = ? AND hotel_id = ?
        ");
        return $stmt->execute([$serviceId, $hotelId]);
    }
} 