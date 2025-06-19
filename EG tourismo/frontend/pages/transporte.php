<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Transport.php';
require_once '../../backend/classes/TourismZone.php';

// Initialize objects
$transport = new Transport();
$tourismZone = new TourismZone();

// Get all tourism zones
$zones = $tourismZone->getAllZones();

// Get transport services by zone
$transportByZone = [];
foreach ($zones as $zone) {
    $transportByZone[$zone['id']] = $transport->getTransportByZone($zone['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transporte en Guinea Ecuatorial - Tu movilidad garantizada</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../frontend/assets/css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../../assets/images/transport-hero.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }
        .info-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: 100%;
        }
        .info-card:hover {
            transform: translateY(-5px);
        }
        .info-icon {
            font-size: 2.5rem;
            color: #219150;
            margin-bottom: 1rem;
        }
        .zone-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .zone-nav .nav-link {
            color: #219150;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        .zone-nav .nav-link:hover,
        .zone-nav .nav-link.active {
            color: white;
            background: #219150;
        }
        .transport-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: 100%;
        }
        .transport-card:hover {
            transform: translateY(-5px);
        }
        .transport-image {
            height: 200px;
            object-fit: cover;
        }
        .transport-price {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #219150;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .transport-features {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .transport-feature {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4">Transporte en Guinea Ecuatorial</h1>
            <p class="lead">Descubre las mejores opciones para moverte por el país</p>
        </div>
    </div>
    <div class="zone-nav mb-4">
        <div class="container">
            <ul class="nav nav-pills justify-content-center" id="zoneTabs" role="tablist">
                <?php foreach ($zones as $zone): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" 
                            id="zone-<?php echo $zone['id']; ?>-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#zone-<?php echo $zone['id']; ?>" 
                            type="button" 
                            role="tab">
                        <?php echo htmlspecialchars($zone['nombre']); ?>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="zoneTabsContent">
        <?php foreach ($zones as $zone): ?>
        <div class="tab-pane fade" id="zone-<?php echo $zone['id']; ?>" role="tabpanel">
            <div class="row">
                <?php foreach ($transportByZone[$zone['id']] as $service): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($service['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($service['matricula']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($service['matricula']); ?></h5>
                            <p class="card-text">Servicio de transporte disponible en <?php echo htmlspecialchars($zone['nombre']); ?></p>
                            <div class="transport-features">
                                <span class="transport-feature">
                                    <i class="fas fa-phone"></i> <?php echo htmlspecialchars($service['telefono']); ?>
                                </span>
                                <span class="transport-feature">
                                    <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($service['correo']); ?>
                                </span>
                            </div>
                            <div class="mt-3">
                                <a href="tel:<?php echo htmlspecialchars($service['telefono']); ?>" class="btn btn-primary me-2">
                                    <i class="fas fa-phone"></i> Llamar
                                </a>
                                <a href="mailto:<?php echo htmlspecialchars($service['correo']); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope"></i> Contactar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php include '../includes/footer.php'; ?>

    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activate first tab by default
        document.addEventListener('DOMContentLoaded', function() {
            const firstTab = document.querySelector('.nav-link');
            if (firstTab) {
                firstTab.click();
            }
        });
    </script>
</body>
</html> 