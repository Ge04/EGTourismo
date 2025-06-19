<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Hotel.php';
require_once '../../backend/classes/Mailer.php';

// Check if booking information exists in session
if (!isset($_SESSION['booking'])) {
    header('Location: hoteles.php');
    exit;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: confirmar-reserva.php');
    exit;
}

// Validate required fields
$required_fields = ['nombre', 'email', 'telefono', 'pais', 'payment_method'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "Por favor, complete todos los campos requeridos.";
        header('Location: confirmar-reserva.php');
        exit;
    }
}

// Validate payment method specific fields
if ($_POST['payment_method'] === 'credit_card') {
    $card_fields = ['card_number', 'card_expiry', 'card_cvv', 'card_name'];
    foreach ($card_fields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Por favor, complete todos los campos de la tarjeta de crédito.";
            header('Location: confirmar-reserva.php');
            exit;
        }
    }
}

// Process the booking
$hotelObj = new Hotel();
$booking_data = array(
    'hotel_id' => $_SESSION['booking']['hotel_id'],
    'room_id' => $_SESSION['booking']['room_id'],
    'nombre' => $_POST['nombre'],
    'email' => $_POST['email'],
    'telefono' => $_POST['telefono'],
    'check_in' => $_SESSION['booking']['check_in'],
    'check_out' => $_SESSION['booking']['check_out'],
    'huespedes' => $_SESSION['booking']['guests']
);

// Add booking to database
if ($hotelObj->createBooking($booking_data)) {
    // Prepare data for email
    $email_data = array_merge($booking_data, array(
        'hotel_nombre' => $_SESSION['booking']['hotel_nombre'],
        'room_type' => $_SESSION['booking']['room_type'],
        'guests' => $_SESSION['booking']['guests'],
        'price_per_night' => $_SESSION['booking']['price_per_night'],
        'nights' => $_SESSION['booking']['nights'],
        'total_price' => $_SESSION['booking']['total_price']
    ));
    
    // Send confirmation emails
    $mailer = new Mailer();
    $mailer->sendBookingConfirmation($email_data);
    $mailer->sendAdminNotification($email_data);
    
    // Clear booking session data
    unset($_SESSION['booking']);
    
    // Set success message
    $_SESSION['success'] = "¡Reserva confirmada! Te hemos enviado un email con los detalles de tu reserva.";
    
    // Redirect to success page
    header('Location: reserva-exitosa.php');
    exit;
} else {
    $_SESSION['error'] = "Ha ocurrido un error al procesar tu reserva. Por favor, intenta de nuevo.";
    header('Location: confirmar-reserva.php');
    exit;
} 