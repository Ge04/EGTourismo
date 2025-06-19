<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class Mailer {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'your-email@gmail.com';
        $this->mailer->Password = 'your-app-password';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        
        // Default sender
        $this->mailer->setFrom('info@egexplore.com', 'EGexplore');
        $this->mailer->isHTML(true);
    }
    
    public function sendBookingConfirmation($booking_data) {
        try {
            $this->mailer->addAddress($booking_data['email'], $booking_data['nombre']);
            $this->mailer->Subject = 'Confirmación de Reserva - EGexplore';
            require_once __DIR__ . '/../templates/booking_email.php';
            $this->mailer->Body = generateBookingEmail($booking_data);
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Error sending booking confirmation email: " . $e->getMessage());
            return false;
        }
    }
    
    public function sendAdminNotification($booking_data) {
        try {
            $this->mailer->addAddress('admin@egexplore.com', 'EGexplore Admin');
            $this->mailer->Subject = 'Nueva Reserva - EGexplore';
            $this->mailer->Body = $this->generateAdminEmailBody($booking_data);
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Error sending admin notification email: " . $e->getMessage());
            return false;
        }
    }
    
    private function generateAdminEmailBody($booking_data) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .booking-details { margin: 20px 0; padding: 15px; background-color: #f9f9f9; }
            </style>
        </head>
        <body>
            <h2>Nueva Reserva Recibida</h2>
            <div class="booking-details">
                <h3>Detalles de la Reserva:</h3>
                <p><strong>Hotel:</strong> ' . htmlspecialchars($booking_data['hotel_nombre']) . '</p>
                <p><strong>Habitación:</strong> ' . htmlspecialchars($booking_data['room_type']) . '</p>
                <p><strong>Cliente:</strong> ' . htmlspecialchars($booking_data['nombre']) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($booking_data['email']) . '</p>
                <p><strong>Teléfono:</strong> ' . htmlspecialchars($booking_data['telefono']) . '</p>
                <p><strong>Check-in:</strong> ' . htmlspecialchars($booking_data['check_in']) . '</p>
                <p><strong>Check-out:</strong> ' . htmlspecialchars($booking_data['check_out']) . '</p>
                <p><strong>Huéspedes:</strong> ' . htmlspecialchars($booking_data['guests']) . '</p>
                <p><strong>Total:</strong> ' . htmlspecialchars($booking_data['total_price']) . ' €</p>
            </div>
            <p>Por favor, verifica los detalles de la reserva en el panel de administración.</p>
        </body>
        </html>';
    }
} 