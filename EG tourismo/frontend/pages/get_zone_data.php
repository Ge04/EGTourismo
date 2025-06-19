<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Zone.php';
require_once '../../backend/classes/City.php';

$zone = new Zone();
$city = new City();

$zoneId = isset($_GET['zone']) ? intval($_GET['zone']) : null;

if (!$zoneId) {
    echo '<div class="alert alert-danger">Zona no especificada</div>';
    exit;
}

$zoneData = $zone->getZoneById($zoneId);
if (!$zoneData) {
    echo '<div class="alert alert-danger">Zona no encontrada</div>';
    exit;
}

$cities = $city->getCitiesByZone($zoneId);
?>

<div class="text-center mb-4 fade-in">
    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['name']); ?></h1>
    <p class="zone-description"><?php echo htmlspecialchars($zoneData['description']); ?></p>
</div>

<div class="row g-4">
    <?php foreach ($cities as $cityItem): ?>
    <div class="col-md-6 col-lg-4">
        <div class="city-card">
            <?php if (!empty($cityItem['image'])): ?>
                <img src="<?php echo htmlspecialchars($cityItem['image']); ?>" 
                     class="city-image" 
                     alt="<?php echo htmlspecialchars($cityItem['name']); ?>">
            <?php else: ?>
                <div class="city-image d-flex align-items-center justify-content-center" 
                     style="background: linear-gradient(45deg, #219150, #1a7340);">
                    <i class="fas fa-city text-white" style="font-size: 3rem;"></i>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <h3 class="city-title"><?php echo htmlspecialchars($cityItem['name']); ?></h3>
                <p class="city-description"><?php echo htmlspecialchars($cityItem['description']); ?></p>
                <div class="city-actions">
                    <a href="#" class="btn btn-explore" data-city="<?php echo $cityItem['id']; ?>">
                        <i class="fas fa-compass me-2"></i>Explorar más
                    </a>
                    <?php if ($cityItem['latitude'] && $cityItem['longitude']): ?>
                    <a href="https://www.google.com/maps?q=<?php echo $cityItem['latitude']; ?>,<?php echo $cityItem['longitude']; ?>" 
                       target="_blank" class="btn btn-map">
                        <i class="fas fa-map me-2"></i>Ver mapa
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($cities)): ?>
    <div class="col-12">
        <div class="empty-state">
            <i class="fas fa-city"></i>
            <h4>No hay ciudades registradas</h4>
            <p>Próximamente tendremos ciudades disponibles en esta zona</p>
        </div>
    </div>
    <?php endif; ?>
</div> 