<?php
$page_title = 'Dashboard';
require_once 'includes/header.php';

require_once '../backend/classes/TourismZone.php';
require_once '../backend/classes/Service.php';

$zoneObj = new TourismZone();
$serviceObj = new Service();

$zones = $zoneObj->getAllZones();
$services = $serviceObj->getAllServices();
if (!is_array($services)) $services = [];
$categories = $serviceObj->getAllCategories();
if (!is_array($categories)) $categories = [];
?>

<!-- Quick Stats -->
<div class="container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center dashboard-stat-card">
                <div class="card-body">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h5 class="card-title">Zonas Turísticas</h5>
                    <h2 class="stat-number mb-3"><?php echo count($zones); ?></h2>
                    <a href="zones.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Zona
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center dashboard-stat-card">
                <div class="card-body">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h5 class="card-title">Servicios</h5>
                    <h2 class="stat-number mb-3"><?php echo count($services); ?></h2>
                    <a href="services.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Servicio
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center dashboard-stat-card">
                <div class="card-body">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="card-title">Categorías</h5>
                    <h2 class="stat-number mb-3"><?php echo count($categories); ?></h2>
                    <a href="categories.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Categoría
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-map-marked-alt me-2"></i>Últimas Zonas
                </div>
                <div class="card-body">
                    <?php if (empty($zones)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay zonas turísticas registradas.</p>
                            <a href="zones.php" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Crear Primera Zona
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="recent-items">
                            <?php foreach (array_slice($zones, 0, 5) as $zone): ?>
                                <div class="recent-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-1"><?php echo htmlspecialchars($zone['nombre']); ?></h6>
                                            <p class="text-muted mb-1 small">
                                                <?php echo htmlspecialchars(substr($zone['descripcion'], 0, 100)) . '...'; ?>
                                            </p>
                                        </div>
                                        <small class="text-muted ms-2">
                                            <?php echo date('d/m/Y', strtotime($zone['created_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="zones.php" class="btn btn-outline-primary btn-sm">Ver Todas</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-concierge-bell me-2"></i>Últimos Servicios
                </div>
                <div class="card-body">
                    <?php if (empty($services)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay servicios registrados.</p>
                            <a href="services.php" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Crear Primer Servicio
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="recent-items">
                            <?php foreach (array_slice($services, 0, 5) as $service): ?>
                                <div class="recent-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-1"><?php echo htmlspecialchars($service['name']); ?></h6>
                                            <p class="text-muted mb-1 small">
                                                <?php echo htmlspecialchars(substr($service['description'], 0, 100)) . '...'; ?>
                                            </p>
                                            <span class="badge bg-success">$<?php echo number_format($service['price'], 2); ?></span>
                                        </div>
                                        <small class="text-muted ms-2">
                                            <?php echo date('d/m/Y', strtotime($service['created_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="services.php" class="btn btn-outline-primary btn-sm">Ver Todos</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .content {
        background-color: rgb(31, 103, 175);
        width: 100%;
        height: auto;
    }

    /* .apy{
    position:absolute;
    top: 100%;
   } */
    .dashboard-stat-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 1px solid rgba(33, 145, 80, 0.1);
        transition: all 0.3s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(33, 145, 80, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #219150, #1e7e34);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #219150;
        margin: 0;
    }

    .card-title {
        font-weight: 600;
        color: #219150;
        font-size: 1.1rem;
    }

    .recent-items {
        max-height: 400px;
        overflow-y: auto;
    }

    .recent-item {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .recent-item:hover {
        background: #e9f7ef;
        border-color: #219150;
    }

    .recent-item:last-child {
        margin-bottom: 0;
    }

    .badge {
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .stat-number {
            font-size: 2rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>

<?php require_once 'includes/footer.php'; ?>