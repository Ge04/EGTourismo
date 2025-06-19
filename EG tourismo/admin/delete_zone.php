<?php
session_start();
require_once '../backend/classes/TourismZone.php';
require_once '../backend/config/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: zones.php');
    exit;
}

$zoneObj = new TourismZone();
$result = $zoneObj->deleteZone($_GET['id']);

if ($result === true) {
    $_SESSION['success'] = 'Zona turística eliminada exitosamente';
} else {
    $_SESSION['error'] = $result;
}

header('Location: zones.php');
exit; 