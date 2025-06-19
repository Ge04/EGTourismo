<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Restaurant.php';
require_once '../../backend/classes/TourismZone.php';

// Initialize objects
$restaurant = new Restaurant();
$zone = new TourismZone();

// Get all zones
$zones = $zone->getAllZones();
if (!is_array($zones)) $zones = [];

// Get restaurants for each zone
$restaurantsByZone = [];
foreach ($zones as $zone) {
    $restaurants = $restaurant->getRestaurantsByZone($zone['id']);
    if (is_array($restaurants)) {
        $restaurantsByZone[$zone['id']] = $restaurants;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes en Guinea Ecuatorial - EG Turismo</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .zone-section {
            margin-bottom: 4rem;
        }
        .zone-title {
            color: #219150;
            border-bottom: 2px solid #219150;
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
        }
        .restaurant-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(33, 145, 80, 0.08);
            border: none;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
            height: 100%;
        }
        .restaurant-card:hover {
            transform: translateY(-5px);
        }
        .restaurant-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 18px 18px 0 0;
        }
        .restaurant-info {
            padding: 1.5rem;
        }
        .restaurant-title {
            color: #219150;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .restaurant-type {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .restaurant-price {
            background: #219150;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }
        .restaurant-contact {
            border-top: 1px solid #eee;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }
        .contact-item i {
            color: #219150;
            margin-right: 0.5rem;
            width: 20px;
        }
        .zone-nav {
            background: #f8f9fa;
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-radius: 10px;
            position: sticky;
            top: 80px;
            z-index: 100;
        }
        .zone-nav .nav-link {
            color: #219150;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin: 0 0.25rem;
        }
        .zone-nav .nav-link:hover,
        .zone-nav .nav-link.active {
            background: #219150;
            color: white;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

    </nav>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1>Restaurantes en Guinea Ecuatorial</h1>
            <p>Descubre la mejor gastronomía local e internacional</p>
        </div>
    </section>

    <!-- Zone Navigation -->
    <div class="container mt-4">
        <div class="zone-nav">
            <ul class="nav justify-content-center" id="zoneNav">
                <?php foreach ($zones as $index => $zone): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                       href="#zone-<?php echo $zone['id']; ?>">
                        <?php echo htmlspecialchars($zone['nombre']); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <section class="section">
        <div class="container">
            <?php foreach ($zones as $zone): ?>
            <div id="zone-<?php echo $zone['id']; ?>" class="zone-section">
                <h2 class="zone-title">Restaurantes en <?php echo htmlspecialchars($zone['nombre']); ?></h2>
                <div class="row">
                    <?php if (isset($restaurantsByZone[$zone['id']]) && !empty($restaurantsByZone[$zone['id']])): ?>
                        <?php foreach ($restaurantsByZone[$zone['id']] as $restaurant): ?>
                        <div class="col-md-4 mb-4">
                            <div class="restaurant-card">
                                <img src="<?php echo htmlspecialchars($restaurant['imagen']); ?>" 
                                     class="restaurant-image" 
                                     alt="<?php echo htmlspecialchars($restaurant['nombre']); ?>">
                                <div class="restaurant-info">
                                    <h3 class="restaurant-title"><?php echo htmlspecialchars($restaurant['nombre']); ?></h3>
                                    <p class="restaurant-type"><?php echo htmlspecialchars($restaurant['tipo_cocina']); ?></p>
                                    <span class="restaurant-price"><?php echo htmlspecialchars($restaurant['precio_medio']); ?></span>
                                    <p><?php echo htmlspecialchars($restaurant['descripcion']); ?></p>
                                    <div class="restaurant-contact">
                                        <div class="contact-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo htmlspecialchars($restaurant['ubicacion']); ?></span>
                                        </div>
                                        <div class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span><?php echo htmlspecialchars($restaurant['telefono']); ?></span>
                                        </div>
                                        <div class="contact-item">
                                            <i class="fas fa-envelope"></i>
                                            <span><?php echo htmlspecialchars($restaurant['correo']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No hay restaurantes registrados en esta zona.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for zone navigation
        document.querySelectorAll('.zone-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                targetSection.scrollIntoView({ behavior: 'smooth' });
                
                // Update active state
                document.querySelectorAll('.zone-nav .nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Update active nav item on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.zone-section');
            const navLinks = document.querySelectorAll('.zone-nav .nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').substring(1) === current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html> 