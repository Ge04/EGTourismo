<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Transport.php';
require_once '../../backend/classes/TourismZone.php';

$transport = new Transport();
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

$zoneTransports = $transport->getTransportByZone($zoneId);
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
                       id="transportSearch" 
                       placeholder="Buscar transporte...">
            </div>
        </div>
        <div class="col-md-8">
            <div class="filter-group">
                <select class="filter-select" id="availabilityFilter">
                    <option value="">Todas las disponibilidades</option>
                    <option value="Disponible">Disponible</option>
                    <option value="Ocupado">Ocupado</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                </select>
            </div>
            <div class="type-filter">
                <span class="type-btn active" data-type="all">
                    <i class="fas fa-globe me-1"></i>Todos
                </span>
                <span class="type-btn" data-type="Taxi">
                    <i class="fas fa-taxi me-1"></i>Taxi
                </span>
                <span class="type-btn" data-type="Bus">
                    <i class="fas fa-bus me-1"></i>Bus
                </span>
                <span class="type-btn" data-type="Coche">
                    <i class="fas fa-car me-1"></i>Coche
                </span>
                <span class="type-btn" data-type="Barco">
                    <i class="fas fa-ship me-1"></i>Barco
                </span>
            </div>
        </div>
    </div>
</div>

<div class="stats-card">
    <div class="row">
        <div class="col-md-3">
            <div class="stats-number"><?php echo count($zoneTransports); ?></div>
            <div class="stats-label">Vehículos</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneTransports, fn($t) => strpos($t['tipo'], 'Taxi') !== false)); ?></div>
            <div class="stats-label">Taxis</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneTransports, fn($t) => strpos($t['tipo'], 'Bus') !== false)); ?></div>
            <div class="stats-label">Buses</div>
        </div>
        <div class="col-md-3">
            <div class="stats-number"><?php echo count(array_filter($zoneTransports, fn($t) => strpos($t['tipo'], 'Coche') !== false)); ?></div>
            <div class="stats-label">Coches</div>
        </div>
    </div>
</div>

<div class="text-center mb-4 fade-in">
    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['nombre']); ?></h1>
    <p class="zone-description"><?php echo htmlspecialchars($zoneData['descripcion'] ?? ''); ?></p>
</div>

<div class="row g-4" id="transportsContainer">
    <?php if (!empty($zoneTransports)): ?>
        <?php foreach ($zoneTransports as $transport): ?>
        <div class="col-md-6 col-lg-4 transport-item" 
             data-name="<?php echo strtolower(htmlspecialchars($transport['matricula'])); ?>"
             data-type="<?php echo htmlspecialchars($transport['tipo'] ?? 'Vehículo'); ?>"
             data-availability="<?php echo htmlspecialchars($transport['estado'] ?? 'Disponible'); ?>">
            <div class="transport-card">
                <div class="position-relative">
                    <?php if (!empty($transport['imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($transport['imagen']); ?>" 
                             class="transport-image w-100" 
                             alt="<?php echo htmlspecialchars($transport['matricula']); ?>">
                    <?php else: ?>
                        <div class="transport-image w-100 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(45deg, #219150, #1a7340);">
                            <i class="fas fa-car text-white" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="transport-type">
                        <?php echo htmlspecialchars($transport['tipo'] ?? 'Vehículo'); ?>
                    </div>
                    <div class="transport-license">
                        <?php echo htmlspecialchars($transport['matricula']); ?>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($transport['matricula']); ?></h5>
                    <p class="card-text">Vehículo de transporte disponible en la zona</p>
                    <div class="transport-contact">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($transport['telefono']); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlspecialchars($transport['correo']); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-info-circle"></i>
                            <span><?php echo htmlspecialchars($transport['estado'] ?? 'Disponible'); ?></span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="tel:<?php echo htmlspecialchars($transport['telefono']); ?>" 
                           class="btn btn-primary me-2">
                            <i class="fas fa-phone"></i> Llamar
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($transport['correo']); ?>" 
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
                <i class="fas fa-car"></i>
                <h4>No hay transporte registrado</h4>
                <p>Próximamente tendremos opciones de transporte disponibles en esta zona</p>
            </div>
        </div>
    <?php endif; ?>
</div> 