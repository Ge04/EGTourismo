<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../backend/config/config.php';
require_once '../../backend/classes/TourismZone.php';
require_once '../../backend/classes/Hotel.php';
require_once '../../backend/classes/Transport.php';
require_once '../../backend/classes/Activity.php';

echo "<h1>Debug Test</h1>";

try {
    echo "<h2>Testing TourismZone</h2>";
    $tourismZone = new TourismZone();
    $zones = $tourismZone->getAllZones();
    echo "Zones found: " . count($zones) . "<br>";
    
    if (count($zones) > 0) {
        echo "First zone: " . $zones[0]['nombre'] . "<br>";
    }
    
    echo "<h2>Testing Hotel</h2>";
    $hotel = new Hotel();
    $hotelsByZone = $hotel->getHotelsByZone($zones[0]['id']);
    echo "Hotels in first zone: " . count($hotelsByZone) . "<br>";
    
    echo "<h2>Testing Transport</h2>";
    $transport = new Transport();
    $transportByZone = $transport->getTransportByZone($zones[0]['id']);
    echo "Transport in first zone: " . count($transportByZone) . "<br>";
    
    echo "<h2>Testing Activity</h2>";
    $activity = new Activity();
    $activitiesByZone = $activity->getActivitiesByZone($zones[0]['id']);
    echo "Activities in first zone: " . count($activitiesByZone) . "<br>";
    
} catch (Exception $e) {
    echo "<h2>Error:</h2>";
    echo $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?> 