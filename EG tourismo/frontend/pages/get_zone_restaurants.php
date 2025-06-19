<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Restaurant.php';
require_once '../../backend/classes/TourismZone.php';

$restaurant = new Restaurant();
$tourismZone = new TourismZone();

$zoneId = isset($_GET['zone']) ? intval($_GET['zone']) : null;

if (!$zoneId) {
    echo '<div class="alert alert-danger">Zona no especificada</div>';
    exit;
}

$zoneData = $tourismZone->getZoneById($zoneId);
if (!$zoneData) {
    echo '<div class="alert alert-danger">Zona no encontrada</div>';
    exit;
}

$zoneRestaurants = $restaurant->getRestaurantsByZone($zoneId);
?>

<div class="search-filter-section">
    <div class="row align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" 
                       class="form-control search-input border-start-0" 
                       id="restaurantSearch" 
                       placeholder="Buscar restaurantes...">
            </div>
        </div>
        <div class="col-md-8">
            <div class="filter-group">
                <select class="filter-select" id="priceFilter">
                    <option value="">Todos los precios</option>
                    <option value="Económico">Económico</option>
                    <option value="Medio">Medio</option>
                    <option value="Alto">Alto</option>
                </select>
                <select class="filter-select" id="ratingFilter">
                    <option value="">Todas las calificaciones</option>
                    <option value="5">5 estrellas</option>
                    <option value="4">4+ estrellas</option>
                    <option value="3">3+ estrellas</option>
                </select>
            </div>
            <div class="cuisine-filter">
                <span class="cuisine-btn active" data-cuisine="all">
                    <i class="fas fa-globe me-1"></i>Todas
                </span>
                <span class="cuisine-btn" data-cuisine="Local">
                    <i class="fas fa-utensils me-1"></i>Local
                </span>
                <span class="cuisine-btn" data-cuisine="Internacional">
                    <i class="fas fa-globe-americas me-1"></i>Internacional
                </span>
                <span class="cuisine-btn" data-cuisine="Mariscos">
                    <i class="fas fa-fish me-1"></i>Mariscos
                </span>
                <span class="cuisine-btn" data-cuisine="Vegetariano">
                    <i class="fas fa-leaf me-1"></i>Vegetariano
                </span>
            </div>
        </div>
    </div>
</div>

<div class="stats-card">
    <div class="row">
        <div class="col-md-3">
            <div class="stats-number"><?php echo count($zoneRestaurants); ?></div>
            <div class="stats-label">Restaurantes</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneRestaurants, fn($r) => strpos($r['tipo_cocina'], 'Local') !== false)); ?></div>
            <div class="stats-label">Cocina Local</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneRestaurants, fn($r) => strpos($r['precio_medio'], 'Económico') !== false)); ?></div>
            <div class="stats-label">Económicos</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneRestaurants, fn($r) => strpos($r['tipo_cocina'], 'Mariscos') !== false)); ?></div>
            <div class="stats-label">Mariscos</div>
        </div>
    </div>
</div>

<div class="text-center mb-4 fade-in">
    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['nombre']); ?></h1>
    <p class="zone-description"><?php echo htmlspecialchars($zoneData['descripcion'] ?? ''); ?></p>
</div>

<div class="row g-4" id="restaurantsContainer">
    <?php if (!empty($zoneRestaurants)): ?>
        <?php foreach ($zoneRestaurants as $restaurant): ?>
        <div class="col-md-6 col-lg-4 restaurant-item" 
             data-name="<?php echo strtolower(htmlspecialchars($restaurant['nombre'])); ?>"
             data-cuisine="<?php echo htmlspecialchars($restaurant['tipo_cocina']); ?>"
             data-price="<?php echo strtolower(htmlspecialchars($restaurant['precio_medio'])); ?>"
             data-rating="<?php echo $restaurant['calificacion'] ?? 3; ?>">
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
            <div class="empty-state">
                <i class="fas fa-utensils"></i>
                <h4>No hay restaurantes registrados</h4>
                <p>Próximamente tendremos restaurantes disponibles en esta zona</p>
            </div>
        </div>
    <?php endif; ?>
</div> 