<?php
session_start();
require_once '../backend/classes/Service.php';
require_once '../backend/classes/TourismZone.php';
require_once '../backend/config/config.php';

$page_title = 'Servicios';
require_once 'includes/header.php';

$serviceObj = new Service();
$zoneObj = new TourismZone();

$services = $serviceObj->getAllServices();
if (!is_array($services)) $services = [];
$zones = $zoneObj->getAllZones();
if (!is_array($zones)) $zones = [];
$categories = $serviceObj->getAllCategories();
if (!is_array($categories)) $categories = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $zone_id = intval($_POST['zone_id'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $image = $_FILES['image'] ?? null;

    if (empty($name) || empty($description) || $price <= 0 || $zone_id <= 0 || $category_id <= 0) {
        $error = 'Todos los campos son obligatorios y el precio debe ser mayor a 0';
    } else {
        $result = $serviceObj->createService($name, $description, $price, $zone_id, $category_id, $image);
        if ($result === true) {
            $success = 'Servicio creado exitosamente';
            $services = $serviceObj->getAllServices();
        } else {
            $error = $result;
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-2"></i>Nuevo Servicio
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="guia" class="form-label">Guia Turistico</label>
                            <input type="text" class="form-control" id="guia" name="guia" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telf" name="telf" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telf" name="telf" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-concierge-bell me-2"></i>Servicios
                </div>
                <div class="card-body">
                    <?php if (empty($services)): ?>
                        <p class="text-muted">No hay servicios registrados.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Zona</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($service['image_url']); ?>"
                                                    alt="<?php echo htmlspecialchars($service['name']); ?>"
                                                    class="service-thumbnail">
                                            </td>
                                            <td><?php echo htmlspecialchars($service['name']); ?></td>
                                            <td><?php echo htmlspecialchars($service['zone_name']); ?></td>
                                            <td><?php echo htmlspecialchars($service['category_name']); ?></td>
                                            <td>$<?php echo number_format($service['price'], 2); ?></td>
                                            <td>
                                                <a href="edit_service.php?id=<?php echo $service['id']; ?>"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteService(<?php echo $service['id']; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(33, 145, 80, 0.08);
        border: none;
        margin-bottom: 2rem;
    }

    .card-header {
        background: #219150;
        color: #fff;
        border-radius: 18px 18px 0 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .service-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: #219150;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #219150;
        box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
    }
</style>

<script>
    function deleteService(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este servicio?')) {
            window.location.href = `delete_service.php?id=${id}`;
        }
    }
</script>

<?php require_once 'includes/footer.php'; ?>