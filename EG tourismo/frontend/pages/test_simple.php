<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple Test</h1>";

try {
    echo "<h2>Testing config inclusion</h2>";
    require_once '../../backend/config/config.php';
    echo "Config loaded successfully<br>";
    
    echo "<h2>Testing database connection</h2>";
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Database connected successfully<br>";
    
    echo "<h2>Testing zones query</h2>";
    $result = $conn->query("SELECT * FROM zona_turismo ORDER BY nombre");
    $zones = $result->fetch_all(MYSQLI_ASSOC);
    echo "Found " . count($zones) . " zones<br>";
    
    if (count($zones) > 0) {
        echo "First zone: " . $zones[0]['nombre'] . "<br>";
    }
    
    echo "<h2>Testing hotels query</h2>";
    $result = $conn->query("SELECT h.* FROM hotel h JOIN zona_hotel zh ON h.id = zh.hotel_id WHERE zh.zona_id = " . $zones[0]['id']);
    $hotels = $result->fetch_all(MYSQLI_ASSOC);
    echo "Found " . count($hotels) . " hotels in first zone<br>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<h2>Error:</h2>";
    echo $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?> 