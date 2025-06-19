<?php
session_start();
require_once '../backend/classes/TourismZone.php';
require_once '../backend/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: zones.php');
    exit;
}

$page_title = 'Editar Zona Turística';
require_once 'includes/header.php';

$zoneObj = new TourismZone();
$zone = $zoneObj->getZoneById($_GET['id']);

if (!$zone) {
    $_SESSION['error'] = 'Zona turística no encontrada';
    header('Location: zones.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $image = $_FILES['image'] ?? null;
    
    if (empty($name) || empty($description) || empty($location)) {
        $error = 'Todos los campos son obligatorios';
    } else {
        $result = $zoneObj->updateZone($_GET['id'], $name, $description, $location, $image);
        if ($result === true) {
            $success = 'Zona turística actualizada exitosamente';
            $zone = $zoneObj->getZoneById($_GET['id']);
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
                    <i class="fas fa-edit me-2"></i>Editar Zona Turística
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
                                   value="<?php echo htmlspecialchars($zone['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" required><?php echo htmlspecialchars($zone['descripcion']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="<?php echo htmlspecialchars($zone['ubicacion']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <?php if (!empty($zone['main_image'])): ?>
                            <div class="mb-2">
                                <img src="<?php echo htmlspecialchars($zone['main_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($zone['nombre']); ?>"
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
                            <a href="zones.php" class="btn btn-outline-secondary">
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
.form-control {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}
.form-control:focus {
    border-color: #219150;
    box-shadow: 0 0 0 0.2rem rgba(33,145,80,0.25);
}
</style>

<?php require_once 'includes/footer.php'; ?> 