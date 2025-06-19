<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Hotel.php';
require_once '../../backend/classes/TourismZone.php';

// Initialize objects
$hotel = new Hotel();
$tourismZone = new TourismZone();

// Get all tourism zones
$zones = $tourismZone->getAllZones();

// Get hotels by zone
$hotelsByZone = [];
foreach ($zones as $zone) {
    $hotelsByZone[$zone['id']] = $hotel->getHotelsByZone($zone['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles en Guinea Ecuatorial - Tu alojamiento perfecto</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../frontend/assets/css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../../assets/images/hotels-hero.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
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
        .hotel-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: 100%;
        }
        .hotel-card:hover {
            transform: translateY(-5px);
        }
        .hotel-image {
            height: 200px;
            object-fit: cover;
        }
        .hotel-price {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #219150;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .hotel-rating {
            color: #ffc107;
        }
        .hotel-amenities {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .hotel-amenity {
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
            <h1 class="display-4">Hoteles en Guinea Ecuatorial</h1>
            <p class="lead">Descubre los mejores alojamientos para tu estancia</p>
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
    <div class="container mb-5">
        <div class="tab-content" id="zoneTabContent">
            <?php foreach ($zones as $zone): ?>
            <div class="tab-pane fade" 
                 id="zone-<?php echo $zone['id']; ?>" 
                 role="tabpanel" 
                 aria-labelledby="zone-<?php echo $zone['id']; ?>-tab">
                <h2 class="mb-4"><?php echo htmlspecialchars($zone['nombre']); ?></h2>
                <div class="row g-4">
                    <?php foreach ($hotelsByZone[$zone['id']] as $hotel): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="hotel-card">
                            <div class="position-relative">
                                <?php if (!empty($hotel['imagen'])): ?>
                                    <img src="<?php echo htmlspecialchars($hotel['imagen']); ?>" 
                                         class="hotel-image w-100" 
                                         alt="<?php echo htmlspecialchars($hotel['nombre']); ?>">
                                <?php else: ?>
                                    <div class="hotel-image w-100 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(45deg, #219150, #1a7340);">
                                        <i class="fas fa-hotel text-white" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="hotel-price">
                                    <?php echo htmlspecialchars($hotel['precio_rango']); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($hotel['nombre']); ?></h5>
                                <div class="hotel-rating mb-2">
                                    <?php for($i = 0; $i < $hotel['calificacion']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="card-text"><?php echo htmlspecialchars($hotel['descripcion']); ?></p>
                                <div class="hotel-amenities">
                                    <?php 
                                    if (!empty($hotel['servicios'])) {
                                        $amenities = explode(',', $hotel['servicios']);
                                        foreach($amenities as $amenity): 
                                    ?>
                                    <span class="hotel-amenity">
                                        <i class="fas fa-check"></i> <?php echo htmlspecialchars(trim($amenity)); ?>
                                    </span>
                                    <?php 
                                        endforeach;
                                    }
                                    ?>
                                </div>
                                <div class="mt-3">
                                    <a href="tel:<?php echo htmlspecialchars($hotel['telefono']); ?>" 
                                       class="btn btn-primary me-2">
                                        <i class="fas fa-phone"></i> Llamar
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($hotel['email']); ?>" 
                                       class="btn btn-outline-primary">
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