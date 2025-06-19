<?php
function generateBookingEmail($booking_data) {
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                background-color: #219150;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 5px 5px 0 0;
            }
            .content {
                padding: 20px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-top: none;
                border-radius: 0 0 5px 5px;
            }
            .booking-details {
                margin: 20px 0;
                padding: 15px;
                background-color: white;
                border-radius: 5px;
                border: 1px solid #eee;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
                font-size: 12px;
                color: #666;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #219150;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>¡Reserva Confirmada!</h1>
        </div>
        <div class="content">
            <p>Estimado/a ' . htmlspecialchars($booking_data['nombre']) . ',</p>
            
            <p>Gracias por elegir EGexplore para tu estancia en Guinea Ecuatorial. Tu reserva ha sido confirmada.</p>
            
            <div class="booking-details">
                <h3>Detalles de tu reserva:</h3>
                <p><strong>Hotel:</strong> ' . htmlspecialchars($booking_data['hotel_nombre']) . '</p>
                <p><strong>Habitación:</strong> ' . htmlspecialchars($booking_data['room_type']) . '</p>
                <p><strong>Check-in:</strong> ' . htmlspecialchars($booking_data['check_in']) . '</p>
                <p><strong>Check-out:</strong> ' . htmlspecialchars($booking_data['check_out']) . '</p>
                <p><strong>Huéspedes:</strong> ' . htmlspecialchars($booking_data['guests']) . '</p>
                <p><strong>Precio por noche:</strong> ' . htmlspecialchars($booking_data['price_per_night']) . ' €</p>
                <p><strong>Noches:</strong> ' . htmlspecialchars($booking_data['nights']) . '</p>
                <p><strong>Total:</strong> ' . htmlspecialchars($booking_data['total_price']) . ' €</p>
            </div>
            
            <p>Si necesitas modificar o cancelar tu reserva, por favor contáctanos lo antes posible.</p>
            
            <p>Política de cancelación:</p>
            <ul>
                <li>Cancelación gratuita hasta 24 horas antes del check-in</li>
                <li>Cancelación con cargo del 50% entre 24 horas y 12 horas antes del check-in</li>
                <li>No reembolsable si se cancela menos de 12 horas antes del check-in</li>
            </ul>
            
            <p>Para cualquier consulta, no dudes en contactarnos:</p>
            <p>Email: info@egexplore.com<br>
            Teléfono: +240 555 123 456</p>
            
            <a href="https://egexplore.com" class="button">Visitar nuestra web</a>
        </div>
        <div class="footer">
            <p>Este es un email automático, por favor no responda a este mensaje.</p>
            <p>&copy; ' . date('Y') . ' EGexplore. Todos los derechos reservados.</p>
        </div>
    </body>
    </html>';
    
    return $html;
}
?> 