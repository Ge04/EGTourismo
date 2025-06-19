<?php
session_start();
require_once '../backend/classes/Service.php';
require_once '../backend/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: categories.php');
    exit;
}

$page_title = 'Editar Categoría';
require_once 'includes/header.php';

$serviceObj = new Service();
$category = $serviceObj->getCategoryById($_GET['id']);

if (!$category) {
    $_SESSION['error'] = 'Categoría no encontrada';
    header('Location: categories.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    
    if (empty($name) || empty($description)) {
        $error = 'El nombre y la descripción son obligatorios';
    } else {
        $result = $serviceObj->updateCategory($_GET['id'], $name, $description, $icon);
        if ($result === true) {
            $success = 'Categoría actualizada exitosamente';
            $category = $serviceObj->getCategoryById($_GET['id']);
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
                    <i class="fas fa-edit me-2"></i>Editar Categoría
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($category['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icono (Font Awesome)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas <?php echo htmlspecialchars($category['icon']); ?>"></i>
                                </span>
                                <input type="text" class="form-control" id="icon" name="icon" 
                                       value="<?php echo htmlspecialchars($category['icon']); ?>" 
                                       placeholder="Ej: fa-hotel" required>
                            </div>
                            <small class="text-muted">
                                Ingrese el nombre de la clase de Font Awesome (ej: fa-hotel, fa-utensils)
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="categories.php" class="btn btn-outline-secondary">
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
.input-group-text {
    border-radius: 8px 0 0 8px;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
}
</style>

<?php require_once 'includes/footer.php'; ?> 