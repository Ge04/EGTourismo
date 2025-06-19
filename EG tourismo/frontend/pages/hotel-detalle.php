<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Hotel.php';

$hotel_id = $_GET['id'] ?? null;
if (!$hotel_id) {
    header('Location: hoteles.php');
    exit;
}

$hotelObj = new Hotel();
$hotel = $hotelObj->getHotelById($hotel_id);

if (!$hotel) {
    header('Location: hoteles.php');
    exit;
}

// Get related hotels
$related_hotels = $hotelObj->getRelatedHotels($hotel_id, $hotel['ubicacion']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hotel['nombre']); ?> - Guinea Ecuatorial Turismo</title>
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .hotel-gallery {
            position: relative;
            height: 500px;
            overflow: hidden;
            border-radius: 15px;
        }
        .hotel-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .gallery-thumbnail {
            width: 100px;
            height: 70px;
            border-radius: 8px;
            cursor: pointer;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }
        .gallery-thumbnail:hover {
            opacity: 0.8;
        }
        .hotel-info-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .hotel-info-card .card-body {
            padding: 2rem;
        }
        .amenity-icon {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .amenity-icon i {
            color: #219150;
            font-size: 1.2rem;
        }
        .room-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .room-card:hover {
            transform: translateY(-5px);
        }
        .room-image {
            height: 200px;
            object-fit: cover;
        }
        .price-tag {
            font-size: 1.5rem;
            font-weight: 600;
            color: #219150;
        }
        .related-hotel-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .related-hotel-card:hover {
            transform: translateY(-5px);
        }
        .related-hotel-image {
            height: 150px;
            object-fit: cover;
        }
        .booking-form {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
        }
        .form-control:focus {
            border-color: #219150;
            box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25);
        }
        .review-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .rating {
            color: #ffc107;
        }
        .map-container {
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-palm-tree me-2"></i>Guinea Ecuatorial Turismo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="hoteles.php">Hoteles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visa.php">Visa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transporte.php">Transporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vuelos.php">Vuelos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actividades.php">Actividades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="zonas.php">Zonas de Turismo</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="section">
        <div class="container">
            <!-- Hotel Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1 class="mb-2"><?php echo htmlspecialchars($hotel['nombre']); ?></h1>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating me-2">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star<?php echo $i < $hotel['calificacion'] ? '' : '-o'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-muted">(<?php echo $hotel['calificacion']; ?> estrellas)</span>
                    </div>
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <?php echo htmlspecialchars($hotel['ubicacion']); ?>
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="price-tag mb-2">
                        <?php echo htmlspecialchars($hotel['precio_rango']); ?>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        <i class="fas fa-calendar-check me-2"></i>Reservar Ahora
                    </button>
                </div>
            </div>

            <!-- Hotel Gallery -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="hotel-gallery">
                        <img src="<?php echo !empty($hotel['image']) ? htmlspecialchars($hotel['image']) : '../assets/images/default-hotel.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($hotel['nombre']); ?>" 
                             class="main-image">
                    </div>
                    <div class="gallery-thumbnails">
                        <?php
                        $images = explode(',', $hotel['imagenes']);
                        foreach ($images as $image):
                            if (!empty($image)):
                        ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" 
                                 alt="Hotel thumbnail" 
                                 class="gallery-thumbnail"
                                 onclick="changeMainImage(this.src)">
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Hotel Description -->
                    <div class="card hotel-info-card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Descripción</h3>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($hotel['descripcion'])); ?></p>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="card hotel-info-card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Servicios y Amenidades</h3>
                            <div class="row">
                                <?php
                                $amenities = explode(',', $hotel['servicios']);
                                foreach ($amenities as $amenity):
                                    $icon = '';
                                    switch (trim($amenity)) {
                                        case 'wifi':
                                            $icon = 'wifi';
                                            break;
                                        case 'pool':
                                            $icon = 'swimming-pool';
                                            break;
                                        case 'spa':
                                            $icon = 'spa';
                                            break;
                                        case 'gym':
                                            $icon = 'dumbbell';
                                            break;
                                        case 'restaurant':
                                            $icon = 'utensils';
                                            break;
                                        default:
                                            $icon = 'check';
                                    }
                                ?>
                                <div class="col-md-4 mb-4">
                                    <div class="amenity-icon">
                                        <i class="fas fa-<?php echo $icon; ?>"></i>
                                    </div>
                                    <h6><?php echo ucfirst(trim($amenity)); ?></h6>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="card hotel-info-card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Ubicación</h3>
                            <div class="map-container mb-3">
                                <iframe
                                    width="100%"
                                    height="100%"
                                    frameborder="0"
                                    style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q=<?php echo urlencode($hotel['ubicacion']); ?>"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <?php echo htmlspecialchars($hotel['ubicacion']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="card hotel-info-card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Reseñas de Huéspedes</h3>
                            <?php
                            $reviews = $hotelObj->getHotelReviews($hotel_id);
                            if (!empty($reviews)):
                                foreach ($reviews as $review):
                            ?>
                            <div class="review-card p-3 mb-3">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?php echo !empty($review['avatar']) ? htmlspecialchars($review['avatar']) : '../assets/images/default-avatar.jpg'; ?>" 
                                         alt="Reviewer" 
                                         class="review-avatar me-3">
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($review['nombre']); ?></h6>
                                        <div class="rating">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fas fa-star<?php echo $i < $review['calificacion'] ? '' : '-o'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <small class="text-muted ms-auto">
                                        <?php echo date('d M Y', strtotime($review['fecha'])); ?>
                                    </small>
                                </div>
                                <p class="mb-0"><?php echo htmlspecialchars($review['comentario']); ?></p>
                            </div>
                            <?php
                                endforeach;
                            else:
                            ?>
                            <p class="text-muted">No hay reseñas disponibles.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Booking Form -->
                    <div class="booking-form mb-4">
                        <h4 class="mb-4">Reservar Ahora</h4>
                        <form action="procesar-reserva.php" method="POST">
                            <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Fecha de Llegada</label>
                                <input type="date" name="check_in" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Fecha de Salida</label>
                                <input type="date" name="check_out" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Huéspedes</label>
                                <select name="guests" class="form-select" required>
                                    <option value="1">1 Huésped</option>
                                    <option value="2">2 Huéspedes</option>
                                    <option value="3">3 Huéspedes</option>
                                    <option value="4">4 Huéspedes</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tipo de Habitación</label>
                                <select name="room_type" class="form-select" required>
                                    <option value="standard">Habitación Estándar</option>
                                    <option value="deluxe">Habitación Deluxe</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                Verificar Disponibilidad
                            </button>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div class="card hotel-info-card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Información de Contacto</h4>
                            <p class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <?php echo htmlspecialchars($hotel['telefono']); ?>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <?php echo htmlspecialchars($hotel['email']); ?>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-globe text-primary me-2"></i>
                                <a href="<?php echo htmlspecialchars($hotel['website']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($hotel['website']); ?>
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Related Hotels -->
                    <?php if (!empty($related_hotels)): ?>
                    <div class="card hotel-info-card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Hoteles Similares</h4>
                            <?php foreach ($related_hotels as $related): ?>
                            <div class="related-hotel-card mb-3">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img src="<?php echo !empty($related['image']) ? htmlspecialchars($related['image']) : '../assets/images/default-hotel.jpg'; ?>" 
                                             class="related-hotel-image" 
                                             alt="<?php echo htmlspecialchars($related['nombre']); ?>">
                                    </div>
                                    <div class="col-8">
                                        <div class="p-3">
                                            <h6 class="mb-1">
                                                <a href="hotel-detalle.php?id=<?php echo $related['id']; ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($related['nombre']); ?>
                                                </a>
                                            </h6>
                                            <div class="rating mb-1">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <i class="fas fa-star<?php echo $i < $related['calificacion'] ? '' : '-o'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <p class="price-tag mb-0">
                                                <?php echo htmlspecialchars($related['precio_rango']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        function changeMainImage(src) {
            document.querySelector('.main-image').src = src;
        }
    </script>
</body>
</html> 