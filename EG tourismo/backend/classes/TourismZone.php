<?php
require_once 'Database.php';

class TourismZone
{
    private $db;

    public function __construct()
    {
        try {
            // Force database initialization
            $db = Database::getInstance();
            $this->db = $db->getConnection();
            
            // Check if zona_turismo table exists
            $tables = $this->db->query("SHOW TABLES LIKE 'zona_turismo'")->fetchAll();
            if (empty($tables)) {
                // If table doesn't exist, try to recreate database
                $db->createDatabase();
                $this->db = $db->getConnection();
            }
        } catch (Exception $e) {
            error_log("Error initializing TourismZone: " . $e->getMessage());
            throw new Exception("Database initialization failed: " . $e->getMessage());
        }
    }

    public function getAllZones()
    {
        $stmt = $this->db->query("SELECT * FROM zona_turismo ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public function getZoneById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM zona_turismo WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getZoneImages($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM galeria_multimedia 
            WHERE entity_type = 'zona_turismo' AND entity_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getZoneServices($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT s.* 
            FROM servicios s 
            JOIN zona_servicio zs ON s.id = zs.servicio_id 
            WHERE zs.zona_id = ?
            ORDER BY s.nombre
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getZoneHotels($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT h.* 
            FROM hotel h 
            JOIN zona_hotel zh ON h.id = zh.hotel_id 
            WHERE zh.zona_id = ?
            ORDER BY h.nom_hotel
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getZoneActivities($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT a.* 
            FROM actividad a 
            JOIN zona_actividad za ON a.id = za.actividad_id 
            WHERE za.zona_id = ?
            ORDER BY a.tipo
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getZoneRestaurants($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT r.* 
            FROM restaurantes r 
            JOIN zona_restaurante zr ON r.id = zr.restaurante_id 
            WHERE zr.zona_id = ?
            ORDER BY r.nombre
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function createZone($nombre, $descripcion, $ubicacion, $atractivos)
    {
        // Convert atractivos array to JSON string if it's an array
        $atractivosJson = is_array($atractivos) ? json_encode($atractivos) : $atractivos;

        $stmt = $this->db->prepare("
            INSERT INTO zona_turismo (nombre, descripcion, ubicacion, atractivos) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $nombre,
            $descripcion,
            $ubicacion,
            $atractivosJson
        ]);
    }

    public function updateZone($id, $nombre, $descripcion, $ubicacion, $image = null)
    {
        // Handle image upload if provided
        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../frontend/assets/images/zones/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($image['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = 'assets/images/zones/' . $fileName;
            }
        }

        // If no new image was uploaded, keep the existing one
        if ($imagePath === null) {
            $stmt = $this->db->prepare("
                UPDATE zona_turismo 
                SET nombre = ?, descripcion = ?, ubicacion = ?
                WHERE id = ?
            ");
            return $stmt->execute([$nombre, $descripcion, $ubicacion, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE zona_turismo 
                SET nombre = ?, descripcion = ?, ubicacion = ?, main_image = ?
                WHERE id = ?
            ");
            return $stmt->execute([$nombre, $descripcion, $ubicacion, $imagePath, $id]);
        }
    }

    public function deleteZone($id)
    {
        $stmt = $this->db->prepare("DELETE FROM zona_turismo WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function addZoneImage($zoneId, $imagePath, $description = '')
    {
        $stmt = $this->db->prepare("
            INSERT INTO galeria_multimedia (url_img, descripcion, entity_type, entity_id) 
            VALUES (?, ?, 'zona_turismo', ?)
        ");
        return $stmt->execute([$imagePath, $description, $zoneId]);
    }

    public function deleteZoneImage($imageId)
    {
        $stmt = $this->db->prepare("DELETE FROM galeria_multimedia WHERE id = ?");
        return $stmt->execute([$imageId]);
    }

    public function linkService($zoneId, $serviceId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO zona_servicio (zona_id, servicio_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$zoneId, $serviceId]);
    }

    public function unlinkService($zoneId, $serviceId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM zona_servicio 
            WHERE zona_id = ? AND servicio_id = ?
        ");
        return $stmt->execute([$zoneId, $serviceId]);
    }
}
