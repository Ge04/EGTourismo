<?php
session_start();
require_once '../backend/classes/Admin.php';
require_once '../backend/config/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admins.php');
    exit;
}

// Prevent self-deletion
if ($_GET['id'] == $_SESSION['admin_id']) {
    $_SESSION['error'] = 'No puedes eliminar tu propia cuenta';
    header('Location: admins.php');
    exit;
}

$adminObj = new Admin();
$result = $adminObj->deleteAdmin($_GET['id']);

if ($result === true) {
    $_SESSION['success'] = 'Administrador eliminado exitosamente';
} else {
    $_SESSION['error'] = $result;
}

header('Location: admins.php');
exit; 