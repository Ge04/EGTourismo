<?php
require_once '../../backend/classes/TourismZone.php';
require_once '../../backend/classes/Service.php';

$zoneSlug = $_GET['slug'] ?? '';
if (empty($zoneSlug)) {
    header('Location: /');
    exit;
}

$zoneObj = new TourismZone();
$serviceObj = new Service();

$zone = $zoneObj->getZoneBySlug($zoneSlug);
if (!$zone) {
    header('Location: /');
    exit;
}

$zoneImages = $zoneObj->getZoneImages($zone['id']);
$services = $zoneObj->getZoneServices($zone['id']);

// Group services by category
$servicesByCategory = [];
foreach ($services as $service) {
    $categoryName = $service['category_name'];
    if (!isset($servicesByCategory[$categoryName])) {
        $servicesByCategory[$categoryName] = [
            'icon' => $service['category_icon'],
            'services' => []
        ];
    }
    $servicesByCategory[$categoryName]['services'][] = $service;
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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <!-- Hero Section -->
    <section class="hero" style="background-image: url('<?php echo htmlspecialchars($zone['main_image']); ?>');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1><?php echo htmlspecialchars($zone['nombre']); ?></h1>
            <p><?php echo htmlspecialchars($zone['ubicacion']); ?></p>
        </div>
    </section>
    <!-- Main Content -->
    <section class="section">
        <div class="container">
            <!-- Zone Description -->
            <div class="row mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">Sobre <?php echo htmlspecialchars($zone['nombre']); ?></h2>
                    <p class="lead"><?php echo nl2br(htmlspecialchars($zone['descripcion'])); ?></p>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h4>
                            <p class="mb-0"><?php echo htmlspecialchars($zone['ubicacion']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zone Gallery -->
            <?php if (!empty($zoneImages)): ?>
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title">Galería de Imágenes</h2>
                    <div class="row g-4">
                        <?php foreach ($zoneImages as $image): ?>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <img src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($image['caption']); ?>">
                                <?php if ($image['caption']): ?>
                                <div class="card-body">
                                    <p class="card-text"><?php echo htmlspecialchars($image['caption']); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- Services by Category -->
            <?php if (!empty($servicesByCategory)): ?>
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">Servicios Disponibles</h2>
                    <?php foreach ($servicesByCategory as $categoryName => $category): ?>
                    <div class="mb-5">
                        <h3 class="mb-4">
                            <i class="fas <?php echo htmlspecialchars($category['icon']); ?> me-2"></i>
                            <?php echo htmlspecialchars($categoryName); ?>
                        </h3>
                        <div class="row g-4">
                            <?php foreach ($category['services'] as $service): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100">
                                    <?php
                                    $serviceImages = $serviceObj->getServiceImages($service['id']);
                                    $mainImage = array_filter($serviceImages, function($img) {
                                        return $img['is_main'];
                                    });
                                    $mainImage = reset($mainImage);
                                    ?>
                                    <?php if ($mainImage): ?>
                                    <img src="<?php echo htmlspecialchars($mainImage['image_path']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($service['name']); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h4>
                                        <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                                        <?php if ($service['price_range']): ?>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-tag me-2"></i>
                                            <?php echo htmlspecialchars($service['price_range']); ?>
                                        </p>
                                        <?php endif; ?>
                                        <?php if ($service['address']): ?>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            <?php echo htmlspecialchars($service['address']); ?>
                                        </p>
                                        <?php endif; ?>
                                        <?php if ($service['contact_info']): ?>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-phone me-2"></i>
                                            <?php echo htmlspecialchars($service['contact_info']); ?>
                                        </p>
                                        <?php endif; ?>
                                        <?php
                                        $averageRating = $serviceObj->getAverageRating($service['id']);
                                        if ($averageRating > 0):
                                        ?>
                                        <div class="rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $averageRating ? 'text-warning' : 'text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                            <span class="ms-2"><?php echo $averageRating; ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>

    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 