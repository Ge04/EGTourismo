<?php
session_start();
require_once '../backend/classes/Service.php';
require_once '../backend/config/config.php';

$page_title = 'Categorías';
require_once 'includes/header.php';

$serviceObj = new Service();
// $categories = $serviceObj->getAllCategories();
// if (!is_array($categories)) $categories = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $name));
    
    if (empty($name) || empty($icon)) {
        $error = 'El nombre y el icono son obligatorios';
    } else {
        $data = [
            'name' => $name,
            'slug' => $slug,
            'icon' => $icon
        ];
        $result = $serviceObj->createCategory($data);
        if ($result === true) {
            $success = 'Categoría creada exitosamente';
            // $categories = $serviceObj->getAllCategories();
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
                    <i class="fas fa-plus me-2"></i>Nueva Categoría
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
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icono (Font Awesome)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" class="form-control" id="icon" name="icon" 
                                       placeholder="Ej: fa-hotel" required>
                            </div>
                            <small class="text-muted">
                                Ingrese el nombre de la clase de Font Awesome (ej: fa-hotel, fa-utensils)
                            </small>
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
                    <i class="fas fa-tags me-2"></i>Categorías
                </div>
                <div class="card-body">
                    <?php if (empty($categories)): ?>
                    <p class="text-muted">No hay categorías registradas.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Icono</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td>
                                        <i class="fas <?php echo htmlspecialchars($category['icon']); ?> fa-2x text-primary"></i>
                                    </td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['slug']); ?></td>
                                    <td>
                                        <a href="edit_category.php?id=<?php echo $category['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteCategory(<?php echo $category['id']; ?>)">
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
    box-shadow: 0 4px 16px rgba(33,145,80,0.08);
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

<script>
    // function deleteCategory(id) {
    //     if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
    //         window.location.href = `delete_category.php?id=${id}`;
    //     }
    // }
</script>

<?php require_once 'includes/footer.php'; ?> 