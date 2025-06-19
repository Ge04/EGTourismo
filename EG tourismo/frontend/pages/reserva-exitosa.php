<?php
require_once '../../backend/config/config.php';

// Check if there's a success message
if (!isset($_SESSION['success'])) {
    header('Location: hoteles.php');
    exit;
}

$success_message = $_SESSION['success'];
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada - EGexplore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .success-card {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
            text-align: center;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 5rem;
            color: #219150;
            margin-bottom: 1.5rem;
        }
        .success-title {
            color: #219150;
            margin-bottom: 1rem;
        }
        .success-message {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .btn-primary {
            background-color: #219150;
            border-color: #219150;
        }
        .btn-primary:hover {
            background-color: #1a7a3d;
            border-color: #1a7a3d;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <i class="fas fa-check-circle success-icon"></i>
            <h1 class="success-title">¡Reserva Confirmada!</h1>
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <div class="d-grid gap-2">
                <a href="hoteles.php" class="btn btn-primary">Volver a Hoteles</a>
                <a href="../index.php" class="btn btn-outline-primary">Ir al Inicio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 