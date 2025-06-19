<?php
require_once '../../backend/classes/TourismZone.php';
require_once '../../backend/classes/Transport.php';
require_once '../../backend/classes/Activity.php';
require_once '../../backend/classes/Hotel.php';

$zoneId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$zoneObj = new TourismZone();
$transportObj = new Transport();
$activityObj = new Activity();
$hotelObj = new Hotel();

$zone = $zoneObj->getZoneById($zoneId);

if (!$zone) {
    header('Location: zonas.php');
    exit;
}

// Initialize empty arrays for related items
$transports = [];
$activities = [];
$hotels = [];

// Try to get related items, but don't fail if tables don't exist
try {
    $transports = $transportObj->getTransportsByZone($zoneId);
} catch (PDOException $e) {
    // Table might not exist yet
}

try {
    $activities = $activityObj->getActivitiesByZone($zoneId);
} catch (PDOException $e) {
    // Table might not exist yet
}

try {
    $hotels = $hotelObj->getHotelsByZone($zoneId);
} catch (PDOException $e) {
    // Table might not exist yet
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($zone['nombre']); ?> - EG Turismo</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .hero-section {
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero-overlay {
            background: rgba(0,0,0,0.5);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding-top: 150px;
        }
        .section-title {
            color: #219150;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .empty-state {
            text-align: center;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        .empty-state i {
            font-size: 3rem;
            color: #219150;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('<?php echo !empty($zone['main_image']) ? htmlspecialchars($zone['main_image']) : '../assets/images/default-zone.jpg'; ?>');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1><?php echo htmlspecialchars($zone['nombre']); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($zone['ubicacion']); ?></p>
        </div>
    </section>
    <!-- Main Content -->
    <div class="container my-5">
        <!-- Zone Description -->
        <div class="info-card">
            <h2 class="section-title">Sobre esta zona</h2>
            <p class="lead"><?php echo htmlspecialchars($zone['descripcion']); ?></p>
        </div>
        <!-- Transport Section -->
        <h2 class="section-title">Transporte Disponible</h2>
        <?php if (empty($transports)): ?>
        <div class="empty-state">
            <i class="fas fa-bus"></i>
            <h3>No hay transportes disponibles</h3>
            <p class="text-muted">Próximamente se agregarán opciones de transporte para esta zona.</p>
        </div>
        <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($transports as $transport): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?php echo !empty($transport['image']) ? htmlspecialchars($transport['image']) : '../assets/images/default-transport.jpg'; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($transport['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($transport['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($transport['descripcion']); ?></p>
                        <p class="text-muted">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            <?php echo htmlspecialchars($transport['precio']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Activities Section -->
        <h2 class="section-title">Actividades</h2>
        <?php if (empty($activities)): ?>
        <div class="empty-state">
            <i class="fas fa-hiking"></i>
            <h3>No hay actividades disponibles</h3>
            <p class="text-muted">Próximamente se agregarán actividades para esta zona.</p>
        </div>
        <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($activities as $activity): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?php echo !empty($activity['image']) ? htmlspecialchars($activity['image']) : '../assets/images/default-activity.jpg'; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($activity['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($activity['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($activity['descripcion']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-clock me-2"></i>
                                <?php echo htmlspecialchars($activity['duracion']); ?>
                            </span>
                            <span class="text-primary">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <?php echo htmlspecialchars($activity['precio']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Hotels Section -->
        <h2 class="section-title">Hoteles</h2>
        <?php if (empty($hotels)): ?>
        <div class="empty-state">
            <i class="fas fa-hotel"></i>
            <h3>No hay hoteles disponibles</h3>
            <p class="text-muted">Próximamente se agregarán hoteles para esta zona.</p>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($hotels as $hotel): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?php echo !empty($hotel['image']) ? htmlspecialchars($hotel['image']) : '../assets/images/default-hotel.jpg'; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($hotel['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($hotel['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($hotel['descripcion']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-star me-2"></i>
                                <?php echo htmlspecialchars($hotel['calificacion']); ?>
                            </span>
                            <span class="text-primary">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <?php echo htmlspecialchars($hotel['precio_rango']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php include '../includes/footer.php'; ?>

    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 