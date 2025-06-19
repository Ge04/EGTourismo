<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Activity.php';
require_once '../../backend/classes/TourismZone.php';

$activity = new Activity();
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

$zoneActivities = $activity->getActivitiesByZone($zoneId);
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
                       id="activitySearch" 
                       placeholder="Buscar actividades...">
            </div>
        </div>
        <div class="col-md-8">
            <div class="filter-group">
                <select class="filter-select" id="durationFilter">
                    <option value="">Todas las duraciones</option>
                    <option value="1">1 hora</option>
                    <option value="2">2+ horas</option>
                    <option value="4">4+ horas</option>
                    <option value="8">8+ horas</option>
                </select>
                <select class="filter-select" id="priceFilter">
                    <option value="">Todos los precios</option>
                    <option value="low">Económico (< 50€)</option>
                    <option value="medium">Medio (50-100€)</option>
                    <option value="high">Alto (> 100€)</option>
                </select>
            </div>
            <div class="category-filter">
                <span class="category-btn active" data-category="all">
                    <i class="fas fa-globe me-1"></i>Todas
                </span>
                <span class="category-btn" data-category="Aventura">
                    <i class="fas fa-mountain me-1"></i>Aventura
                </span>
                <span class="category-btn" data-category="Cultural">
                    <i class="fas fa-landmark me-1"></i>Cultural
                </span>
                <span class="category-btn" data-category="Naturaleza">
                    <i class="fas fa-tree me-1"></i>Naturaleza
                </span>
                <span class="category-btn" data-category="Acuática">
                    <i class="fas fa-water me-1"></i>Acuática
                </span>
            </div>
        </div>
    </div>
</div>

<div class="stats-card">
    <div class="row">
        <div class="col-md-3">
            <div class="stats-number"><?php echo count($zoneActivities); ?></div>
            <div class="stats-label">Actividades</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneActivities, fn($a) => $a['precio'] < 50)); ?></div>
            <div class="stats-label">Económicas</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneActivities, fn($a) => strpos($a['categoria'], 'Aventura') !== false)); ?></div>
            <div class="stats-label">Aventura</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneActivities, fn($a) => strpos($a['categoria'], 'Cultural') !== false)); ?></div>
            <div class="stats-label">Cultural</div>
        </div>
    </div>
</div>

<div class="text-center mb-4 fade-in">
    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['nombre']); ?></h1>
    <p class="zone-description"><?php echo htmlspecialchars($zoneData['descripcion'] ?? ''); ?></p>
</div>

<div class="row g-4" id="activitiesContainer">
    <?php if (!empty($zoneActivities)): ?>
        <?php foreach ($zoneActivities as $activity): ?>
        <div class="col-md-6 col-lg-4 activity-item" 
             data-name="<?php echo strtolower(htmlspecialchars($activity['nombre'])); ?>"
             data-duration="<?php echo intval($activity['duracion']); ?>"
             data-price="<?php echo $activity['precio'] < 50 ? 'low' : ($activity['precio'] < 100 ? 'medium' : 'high'); ?>"
             data-category="<?php echo htmlspecialchars($activity['categoria']); ?>">
            <div class="activity-card">
                <div class="position-relative">
                    <?php if (!empty($activity['imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($activity['imagen']); ?>" 
                             class="activity-image w-100" 
                             alt="<?php echo htmlspecialchars($activity['nombre']); ?>">
                    <?php else: ?>
                        <div class="activity-image w-100 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(45deg, #219150, #1a7340);">
                            <i class="fas fa-hiking text-white" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="activity-price">
                        <?php echo htmlspecialchars($activity['precio']); ?> €
                    </div>
                    <div class="activity-duration">
                        <i class="far fa-clock"></i> <?php echo htmlspecialchars($activity['duracion']); ?>
                    </div>
                    <div class="activity-category">
                        <?php echo htmlspecialchars($activity['categoria']); ?>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($activity['nombre']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($activity['descripcion']); ?></p>
                    <div class="activity-features">
                        <?php 
                        if (!empty($activity['caracteristicas'])) {
                            $features = explode(',', $activity['caracteristicas']);
                            foreach($features as $feature): 
                        ?>
                        <span class="activity-feature">
                            <i class="fas fa-check"></i> <?php echo htmlspecialchars(trim($feature)); ?>
                        </span>
                        <?php 
                            endforeach;
                        }
                        ?>
                    </div>
                    <div class="mt-3">
                        <a href="tel:<?php echo htmlspecialchars($activity['telefono']); ?>" 
                           class="btn btn-primary me-2">
                            <i class="fas fa-phone"></i> Llamar
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($activity['correo']); ?>" 
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
                <i class="fas fa-hiking"></i>
                <h4>No hay actividades registradas</h4>
                <p>Próximamente tendremos actividades disponibles en esta zona</p>
            </div>
        </div>
    <?php endif; ?>
</div> 