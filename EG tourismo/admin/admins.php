<?php
session_start();
require_once '../backend/classes/Admin.php';
require_once '../backend/config/config.php';

$page_title = 'Administradores';
require_once 'includes/header.php';

$adminObj = new Admin();
$admins = $adminObj->getAllAdmins();
if (!is_array($admins)) $admins = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $username = strtolower(str_replace(' ', '.', $name));
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido';
    } else {
        $result = $adminObj->register($username, $password, $name, $email);
        if ($result === true) {
            $success = 'Administrador creado exitosamente';
            $admins = $adminObj->getAllAdmins();
        } else {
            $error = 'El nombre de usuario o correo electrónico ya está en uso';
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-2"></i>Nuevo Administrador
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
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
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
                    <i class="fas fa-users-cog me-2"></i>Administradores
                </div>
                <div class="card-body">
                    <?php if (empty($admins)): ?>
                    <p class="text-muted">No hay administradores registrados.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Correo Electrónico</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($admin['full_name'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($admin['username'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($admin['email'] ?? ''); ?></td>
                                    <td>
                                        <?php 
                                        echo isset($admin['created_at']) 
                                            ? date('d/m/Y H:i', strtotime($admin['created_at']))
                                            : 'N/A';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="edit_admin.php?id=<?php echo $admin['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($admin['id'] !== $_SESSION['admin_id']): ?>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteAdmin(<?php echo $admin['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <?php endif; ?>
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
</style>

<script>
function deleteAdmin(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este administrador?')) {
        window.location.href = `delete_admin.php?id=${id}`;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?> 