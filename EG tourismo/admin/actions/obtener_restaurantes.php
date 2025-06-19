<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Restaurant.php';

header('Content-Type: application/json');

try {
    $restaurant = new Restaurant();
    $restaurants = $restaurant->getAllRestaurants();
    
    echo json_encode([
        'success' => true,
        'restaurants' => $restaurants
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 