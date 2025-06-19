<?php
require_once 'Database.php';

class Activity
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getActivitiesByZone($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT a.* 
            FROM actividad a 
            JOIN zona_actividad za ON a.id = za.actividad_id 
            WHERE za.zona_id = ?
            ORDER BY a.nombre
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getAllActivities()
    {
        $stmt = $this->db->query("SELECT * FROM actividad ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public function getActivityById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM actividad WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createActivity($nombre, $descripcion, $duracion, $precio, $image = null)
    {
        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../frontend/assets/images/activities/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($image['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = 'assets/images/activities/' . $fileName;
            }
        }

        $stmt = $this->db->prepare("
            INSERT INTO actividad (nombre, descripcion, duracion, precio, image) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$nombre, $descripcion, $duracion, $precio, $imagePath]);
    }

    public function updateActivity($id, $nombre, $descripcion, $duracion, $precio, $image = null)
    {
        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../frontend/assets/images/activities/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($image['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = 'assets/images/activities/' . $fileName;
            }
        }

        if ($imagePath === null) {
            $stmt = $this->db->prepare("
                UPDATE actividad 
                SET nombre = ?, descripcion = ?, duracion = ?, precio = ?
                WHERE id = ?
            ");
            return $stmt->execute([$nombre, $descripcion, $duracion, $precio, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE actividad 
                SET nombre = ?, descripcion = ?, duracion = ?, precio = ?, image = ?
                WHERE id = ?
            ");
            return $stmt->execute([$nombre, $descripcion, $duracion, $precio, $imagePath, $id]);
        }
    }

    public function deleteActivity($id)
    {
        $stmt = $this->db->prepare("DELETE FROM actividad WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function linkToZone($zoneId, $activityId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO zona_actividad (zona_id, actividad_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$zoneId, $activityId]);
    }

    public function unlinkFromZone($zoneId, $activityId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM zona_actividad 
            WHERE zona_id = ? AND actividad_id = ?
        ");
        return $stmt->execute([$zoneId, $activityId]);
    }
} 