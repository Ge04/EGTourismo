<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/TourismZone.php';

header('Content-Type: application/json');

try {
    $zoneId = isset($_GET['zone_id']) ? intval($_GET['zone_id']) : null;
    $type = isset($_GET['type']) ? $_GET['type'] : 'hotels';
    
    if (!$zoneId) {
        throw new Exception('Zone ID is required');
    }
    
    $zone = new TourismZone();
    $zoneData = $zone->getZoneById($zoneId);
    
    if (!$zoneData) {
        throw new Exception('Zone not found');
    }
    
    $services = [];
    
    switch ($type) {
        case 'hotels':
            $services = $zone->getZoneHotels($zoneId);
            break;
        case 'restaurants':
            $services = $zone->getZoneRestaurants($zoneId);
            break;
        case 'activities':
            $services = $zone->getZoneActivities($zoneId);
            break;
        case 'transport':
            // For transport, we'll get from the transporte table directly
            $stmt = $conn->prepare("SELECT * FROM transporte WHERE zona_id = ?");
            $stmt->bind_param("i", $zoneId);
            $stmt->execute();
            $result = $stmt->get_result();
            $services = $result->fetch_all(MYSQLI_ASSOC);
            break;
        case 'gallery':
            $services = $zone->getZoneImages($zoneId);
            break;
        default:
            $services = [];
    }
    
    echo json_encode([
        'success' => true,
        'zone' => $zoneData,
        'services' => $services
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 