<?php
session_start();
require_once '../backend/classes/Service.php';
require_once '../backend/classes/TourismZone.php';
require_once '../backend/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: services.php');
    exit;
}

$page_title = 'Editar Servicio';
require_once 'includes/header.php';

$serviceObj = new Service();
$zoneObj = new TourismZone();

$service = $serviceObj->getServiceById($_GET['id']);
if (!$service) {
    $_SESSION['error'] = 'Servicio no encontrado';
    header('Location: services.php');
    exit;
}

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
        $result = $serviceObj->updateService($_GET['id'], $name, $description, $price, $zone_id, $category_id, $image);
        if ($result === true) {
            $success = 'Servicio actualizado exitosamente';
            $service = $serviceObj->getServiceById($_GET['id']);
        } else {
            $error = $result;
        }
    }
}
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Editar Servicio
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
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($service['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       step="0.01" min="0" value="<?php echo $service['price']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zone_id" class="form-label">Zona Turística</label>
                            <select class="form-select" id="zone_id" name="zone_id" required>
                                <option value="">Seleccione una zona</option>
                                <?php foreach ($zones as $zone): ?>
                                <option value="<?php echo $zone['id']; ?>" 
                                        <?php echo $zone['id'] == $service['zone_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($zone['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoría</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"
                                        <?php echo $category['id'] == $service['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <?php if ($service['image_url']): ?>
                            <div class="mb-2">
                                <img src="<?php echo htmlspecialchars($service['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($service['name']); ?>"
                                     class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Deja vacío para mantener la imagen actual</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="services.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(33,145,80,0.08);
    border: none;
    margin-top: 2rem;
}
.card-header {
    background: #219150;
    color: #fff;
    border-radius: 18px 18px 0 0;
    font-weight: 600;
    font-size: 1.1rem;
}
.btn {
    border-radius: 8px;
    font-weight: 500;
}
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}
.form-control:focus, .form-select:focus {
    border-color: #219150;
    box-shadow: 0 0 0 0.2rem rgba(33,145,80,0.25);
}
.input-group-text {
    border-radius: 8px 0 0 8px;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
}
</style>

<?php require_once 'includes/footer.php'; ?> 