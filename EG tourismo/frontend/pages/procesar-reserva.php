<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Hotel.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: hoteles.php');
    exit;
}

// Validate required fields
$required_fields = ['hotel_id', 'check_in', 'check_out', 'guests', 'room_type'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "Por favor, complete todos los campos requeridos.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

// Validate dates
$check_in = new DateTime($_POST['check_in']);
$check_out = new DateTime($_POST['check_out']);
$today = new DateTime();

if ($check_in < $today) {
    $_SESSION['error'] = "La fecha de llegada no puede ser anterior a hoy.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if ($check_out <= $check_in) {
    $_SESSION['error'] = "La fecha de salida debe ser posterior a la fecha de llegada.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Get hotel and room information
$hotelObj = new Hotel();
$hotel = $hotelObj->getHotelById($_POST['hotel_id']);
$rooms = $hotelObj->getHotelRooms($_POST['hotel_id']);

if (!$hotel) {
    $_SESSION['error'] = "Hotel no encontrado.";
    header('Location: hoteles.php');
    exit;
}

// Find the selected room
$selected_room = null;
foreach ($rooms as $room) {
    if ($room['tipo'] === $_POST['room_type']) {
        $selected_room = $room;
        break;
    }
}

if (!$selected_room) {
    $_SESSION['error'] = "Tipo de habitación no disponible.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Calculate number of nights
$nights = $check_in->diff($check_out)->days;

// Calculate total price
$total_price = $selected_room['precio'] * $nights;

// Store booking information in session for confirmation
$_SESSION['booking'] = array(
    'hotel_id' => $_POST['hotel_id'],
    'room_id' => $selected_room['id'],
    'hotel_name' => $hotel['nombre'],
    'room_type' => $selected_room['nombre'],
    'check_in' => $_POST['check_in'],
    'check_out' => $_POST['check_out'],
    'nights' => $nights,
    'guests' => $_POST['guests'],
    'price_per_night' => $selected_room['precio'],
    'total_price' => $total_price
);

// Redirect to booking confirmation page
header('Location: confirmar-reserva.php');
exit; 