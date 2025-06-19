<?php
require_once 'Database.php';

class Transport
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getTransportsByZone($zoneId)
    {
        $stmt = $this->db->prepare("
            SELECT t.* 
            FROM transporte t 
            JOIN zona_transporte zt ON t.id = zt.transporte_id 
            WHERE zt.zona_id = ?
            ORDER BY t.matricula
        ");
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getAllTransports()
    {
        $stmt = $this->db->query("SELECT * FROM transporte ORDER BY matricula");
        return $stmt->fetchAll();
    }

    public function getTransportById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM transporte WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createTransport($matricula, $telefono, $correo, $zona_id)
    {
        $stmt = $this->db->prepare("
            INSERT INTO transporte (matricula, telefono, correo, zona_id) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$matricula, $telefono, $correo, $zona_id]);
    }

    public function updateTransport($id, $matricula, $telefono, $correo, $zona_id)
    {
        $stmt = $this->db->prepare("
            UPDATE transporte 
            SET matricula = ?, telefono = ?, correo = ?, zona_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$matricula, $telefono, $correo, $zona_id, $id]);
    }

    public function deleteTransport($id)
    {
        $stmt = $this->db->prepare("DELETE FROM transporte WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function linkToZone($zoneId, $transportId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO zona_transporte (zona_id, transporte_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$zoneId, $transportId]);
    }

    public function unlinkFromZone($zoneId, $transportId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM zona_transporte 
            WHERE zona_id = ? AND transporte_id = ?
        ");
        return $stmt->execute([$zoneId, $transportId]);
    }

    public function getTransportByZone($zoneId)
    {
        $stmt = $this->db->prepare('
            SELECT t.* 
            FROM transporte t
            JOIN zona_transporte zt ON t.id = zt.transporte_id
            WHERE zt.zona_id = ?
            ORDER BY t.matricula
        ');
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }
} 