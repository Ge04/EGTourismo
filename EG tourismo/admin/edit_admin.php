<?php
session_start();
require_once '../backend/classes/Admin.php';
require_once '../backend/config/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admins.php');
    exit;
}

$page_title = 'Editar Administrador';
require_once 'includes/header.php';

$adminObj = new Admin();
$admin = $adminObj->getAdminById($_GET['id']);

if (!$admin) {
    $_SESSION['error'] = 'Administrador no encontrado';
    header('Location: admins.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if (empty($name) || empty($email)) {
        $error = 'El nombre y el correo electrónico son obligatorios';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido';
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } else {
        $result = $adminObj->updateAdmin($_GET['id'], $name, $email, $password);
        if ($result === true) {
            $success = 'Administrador actualizado exitosamente';
            $admin = $adminObj->getAdminById($_GET['id']);
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
                    <i class="fas fa-edit me-2"></i>Editar Administrador
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
                                   value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Deja vacío para mantener la contraseña actual</small>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="admins.php" class="btn btn-outline-secondary">
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