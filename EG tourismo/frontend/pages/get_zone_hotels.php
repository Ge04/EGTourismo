<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Hotel.php';
require_once '../../backend/classes/TourismZone.php';

$hotel = new Hotel();
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

$zoneHotels = $hotel->getHotelsByZone($zoneId);
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
                       id="hotelSearch" 
                       placeholder="Buscar hoteles...">
            </div>
        </div>
        <div class="col-md-8">
            <div class="filter-group">
                <select class="filter-select" id="ratingFilter">
                    <option value="">Todas las calificaciones</option>
                    <option value="5">5 estrellas</option>
                    <option value="4">4+ estrellas</option>
                    <option value="3">3+ estrellas</option>
                    <option value="2">2+ estrellas</option>
                </select>
                <select class="filter-select" id="categoryFilter">
                    <option value="">Todas las categorías</option>
                    <option value="Lujo">Lujo</option>
                    <option value="Negocios">Negocios</option>
                    <option value="Económico">Económico</option>
                    <option value="Familiar">Familiar</option>
                </select>
            </div>
            <div class="price-filter">
                <span class="price-btn active" data-price="all">
                    <i class="fas fa-globe me-1"></i>Todos
                </span>
                <span class="price-btn" data-price="low">
                    <i class="fas fa-dollar-sign me-1"></i>Económico
                </span>
                <span class="price-btn" data-price="medium">
                    <i class="fas fa-dollar-sign me-1"></i>Medio
                </span>
                <span class="price-btn" data-price="high">
                    <i class="fas fa-dollar-sign me-1"></i>Alto
                </span>
            </div>
        </div>
    </div>
</div>

<div class="stats-card">
    <div class="row">
        <div class="col-md-3">
            <div class="stats-number"><?php echo count($zoneHotels); ?></div>
            <div class="stats-label">Hoteles</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneHotels, fn($h) => $h['calificacion'] >= 4)); ?></div>
            <div class="stats-label">4+ Estrellas</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneHotels, fn($h) => strpos($h['precio_rango'], 'Económico') !== false)); ?></div>
            <div class="stats-label">Económicos</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneHotels, fn($h) => strpos($h['categoria'], 'Lujo') !== false)); ?></div>
            <div class="stats-label">De Lujo</div>
        </div>
    </div>
</div>

<div class="text-center mb-4 fade-in">
    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['nombre']); ?></h1>
    <p class="zone-description"><?php echo htmlspecialchars($zoneData['descripcion'] ?? ''); ?></p>
</div>

<div class="row g-4" id="hotelsContainer">
    <?php if (!empty($zoneHotels)): ?>
        <?php foreach ($zoneHotels as $hotel): ?>
        <div class="col-md-6 col-lg-4 hotel-item" 
             data-name="<?php echo strtolower(htmlspecialchars($hotel['nombre'])); ?>"
             data-rating="<?php echo $hotel['calificacion']; ?>"
             data-category="<?php echo htmlspecialchars($hotel['categoria']); ?>"
             data-price="<?php echo strtolower(htmlspecialchars($hotel['precio_rango'])); ?>">
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
    <?php else: ?>
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-hotel"></i>
                <h4>No hay hoteles registrados</h4>
                <p>Próximamente tendremos hoteles disponibles en esta zona</p>
            </div>
        </div>
    <?php endif; ?>
</div> 