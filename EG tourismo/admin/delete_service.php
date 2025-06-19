<?php
session_start();
require_once '../backend/classes/Service.php';
require_once '../backend/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: services.php');
    exit;
}

$serviceObj = new Service();
$result = $serviceObj->deleteService($_GET['id']);

if ($result === true) {
    $_SESSION['success'] = 'Servicio eliminado exitosamente';
} else {
    $_SESSION['error'] = $result;
}

header('Location: services.php');
exit; 