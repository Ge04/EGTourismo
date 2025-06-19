<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/City.php';

$city = new City();

$cityId = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;
$serviceType = isset($_GET['type']) ? $_GET['type'] : null;

if (!$cityId) {
    echo json_encode(['error' => 'City ID is required']);
    exit;
}

$cityData = $city->getCityById($cityId);
if (!$cityData) {
    echo json_encode(['error' => 'City not found']);
    exit;
}

$services = $city->getCityServices($cityId);

if ($serviceType && isset($services[$serviceType])) {
    $data = $services[$serviceType];
} else {
    $data = $services;
}

header('Content-Type: application/json');
echo json_encode([
    'city' => $cityData,
    'services' => $data
]);
?> 