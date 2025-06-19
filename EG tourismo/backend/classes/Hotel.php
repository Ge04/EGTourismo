<?php
require_once 'Database.php';

class Hotel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getHotelsByZone($zoneId)
    {
        $stmt = $this->db->prepare('
            SELECT h.* 
            FROM hotel h
            JOIN zona_hotel zh ON h.id = zh.hotel_id
            WHERE zh.zona_id = ?
            ORDER BY h.nombre
        ');
        $stmt->execute([$zoneId]);
        return $stmt->fetchAll();
    }

    public function getAllHotels()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM hotel ORDER BY nombre");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all hotels: " . $e->getMessage());
            return array();
        }
    }

    public function getHotelById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM hotel WHERE id = ?");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting hotel by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getRelatedHotels($current_hotel_id, $location, $limit = 3)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM hotel 
                WHERE id != ? AND ubicacion LIKE ? 
                ORDER BY calificacion DESC 
                LIMIT ?
            ");
            $stmt->execute(array($current_hotel_id, "%$location%", $limit));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting related hotels: " . $e->getMessage());
            return array();
        }
    }

    public function getHotelReviews($hotel_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM hotel_review 
                WHERE hotel_id = ? 
                ORDER BY fecha DESC
            ");
            $stmt->execute(array($hotel_id));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting hotel reviews: " . $e->getMessage());
            return array();
        }
    }

    public function getHotelRooms($hotel_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM hotel_room 
                WHERE hotel_id = ? 
                ORDER BY precio
            ");
            $stmt->execute(array($hotel_id));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting hotel rooms: " . $e->getMessage());
            return array();
        }
    }

    public function createHotel($data)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO hotel (
                    nombre, descripcion, ubicacion, precio_rango, 
                    calificacion, categoria, servicios, telefono, 
                    email, website, image, imagenes
                ) VALUES (
                    :nombre, :descripcion, :ubicacion, :precio_rango,
                    :calificacion, :categoria, :servicios, :telefono,
                    :email, :website, :image, :imagenes
                )
            ");
            
            return $stmt->execute(array(
                ':nombre' => $data['nombre'],
                ':descripcion' => $data['descripcion'],
                ':ubicacion' => $data['ubicacion'],
                ':precio_rango' => $data['precio_rango'],
                ':calificacion' => $data['calificacion'],
                ':categoria' => $data['categoria'],
                ':servicios' => $data['servicios'],
                ':telefono' => $data['telefono'],
                ':email' => $data['email'],
                ':website' => $data['website'],
                ':image' => $data['image'],
                ':imagenes' => $data['imagenes']
            ));
        } catch (PDOException $e) {
            error_log("Error creating hotel: " . $e->getMessage());
            return false;
        }
    }

    public function updateHotel($id, $data)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE hotel SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    ubicacion = :ubicacion,
                    precio_rango = :precio_rango,
                    calificacion = :calificacion,
                    categoria = :categoria,
                    servicios = :servicios,
                    telefono = :telefono,
                    email = :email,
                    website = :website,
                    image = :image,
                    imagenes = :imagenes
                WHERE id = :id
            ");
            
            return $stmt->execute(array(
                ':id' => $id,
                ':nombre' => $data['nombre'],
                ':descripcion' => $data['descripcion'],
                ':ubicacion' => $data['ubicacion'],
                ':precio_rango' => $data['precio_rango'],
                ':calificacion' => $data['calificacion'],
                ':categoria' => $data['categoria'],
                ':servicios' => $data['servicios'],
                ':telefono' => $data['telefono'],
                ':email' => $data['email'],
                ':website' => $data['website'],
                ':image' => $data['image'],
                ':imagenes' => $data['imagenes']
            ));
        } catch (PDOException $e) {
            error_log("Error updating hotel: " . $e->getMessage());
            return false;
        }
    }

    public function deleteHotel($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM hotel WHERE id = ?");
            return $stmt->execute(array($id));
        } catch (PDOException $e) {
            error_log("Error deleting hotel: " . $e->getMessage());
            return false;
        }
    }

    public function linkToZone($zoneId, $hotelId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO zona_hotel (zona_id, hotel_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$zoneId, $hotelId]);
    }

    public function unlinkFromZone($zoneId, $hotelId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM zona_hotel 
            WHERE zona_id = ? AND hotel_id = ?
        ");
        return $stmt->execute([$zoneId, $hotelId]);
    }

    public function addReview($data)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO hotel_review (
                    hotel_id, nombre, email, calificacion, 
                    comentario, avatar
                ) VALUES (
                    :hotel_id, :nombre, :email, :calificacion,
                    :comentario, :avatar
                )
            ");
            
            return $stmt->execute(array(
                ':hotel_id' => $data['hotel_id'],
                ':nombre' => $data['nombre'],
                ':email' => $data['email'],
                ':calificacion' => $data['calificacion'],
                ':comentario' => $data['comentario'],
                ':avatar' => $data['avatar']
            ));
        } catch (PDOException $e) {
            error_log("Error adding review: " . $e->getMessage());
            return false;
        }
    }

    public function createBooking($data)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO hotel_booking (
                    hotel_id, room_id, nombre, email, telefono,
                    check_in, check_out, huespedes
                ) VALUES (
                    :hotel_id, :room_id, :nombre, :email, :telefono,
                    :check_in, :check_out, :huespedes
                )
            ");
            
            return $stmt->execute(array(
                ':hotel_id' => $data['hotel_id'],
                ':room_id' => $data['room_id'],
                ':nombre' => $data['nombre'],
                ':email' => $data['email'],
                ':telefono' => $data['telefono'],
                ':check_in' => $data['check_in'],
                ':check_out' => $data['check_out'],
                ':huespedes' => $data['huespedes']
            ));
        } catch (PDOException $e) {
            error_log("Error creating booking: " . $e->getMessage());
            return false;
        }
    }

    public function getHotelBookings($hotel_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM hotel_booking 
                WHERE hotel_id = ? 
                ORDER BY created_at DESC
            ");
            $stmt->execute(array($hotel_id));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting hotel bookings: " . $e->getMessage());
            return array();
        }
    }

    public function updateBookingStatus($booking_id, $status)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE hotel_booking 
                SET estado = ? 
                WHERE id = ?
            ");
            return $stmt->execute(array($status, $booking_id));
        } catch (PDOException $e) {
            error_log("Error updating booking status: " . $e->getMessage());
            return false;
        }
    }

    public function searchHotels($query)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM hotel 
                WHERE nombre LIKE ? 
                OR descripcion LIKE ? 
                OR ubicacion LIKE ?
                ORDER BY nombre
            ");
            $search = "%$query%";
            $stmt->execute(array($search, $search, $search));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching hotels: " . $e->getMessage());
            return array();
        }
    }

    public function filterHotels($filters)
    {
        try {
            $sql = "SELECT * FROM hotel WHERE 1=1";
            $params = array();

            if (!empty($filters['price'])) {
                $sql .= " AND precio_rango = ?";
                $params[] = $filters['price'];
            }

            if (!empty($filters['category'])) {
                $placeholders = str_repeat('?,', count($filters['category']) - 1) . '?';
                $sql .= " AND categoria IN ($placeholders)";
                $params = array_merge($params, $filters['category']);
            }

            if (!empty($filters['services'])) {
                foreach ($filters['services'] as $service) {
                    $sql .= " AND servicios LIKE ?";
                    $params[] = "%$service%";
                }
            }

            $sql .= " ORDER BY nombre";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error filtering hotels: " . $e->getMessage());
            return array();
        }
    }
} 