<?php
session_start();
require_once '../backend/classes/TourismZone.php';
require_once '../backend/config/config.php';

$page_title = 'Zonas Turísticas';
require_once 'includes/header.php';

$zoneObj = new TourismZone();
$zones = $zoneObj->getAllZones();
if (!is_array($zones)) $zones = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $image = $_FILES['image'] ?? null;

    if (empty($name) || empty($description) || empty($location)) {
        $error = 'Todos los campos son obligatorios';
    } else {
        $result = $zoneObj->createZone($name, $description, $location, $image);
        if ($result === true) {
            $success = 'Zona turística creada exitosamente';
            $zones = $zoneObj->getAllZones();
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
                    <i class="fas fa-plus me-2"></i>Nueva Zona Turística
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
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <select class="form-select mb-3" id="zone_id" name="zone_id" required>
                            <option value="">Seleccione Hotel</option>
                            <option value="hilton">
                                <i class="fas fa-hotel me-2"></i>
                                Hilton Malabo
                            <option value="sofitel">
                                <i class="fas fa-hotel me-2"></i>
                                Sofitel de Malabo
                            </option>
                        </select>
                        <select class="form-select mb-3" id="zone_id" name="zone_id" required>
                            <option value="">Seleccione Actividad</option>
                            <option value="Turismo en Kayack">
                                <i class="fas fa-hotel me-2"></i>
                                Turismo en Kayack
                            </option>
                            <option value="Senderismo">
                                <i class="fas fa-hotel me-2"></i>
                                Senderismo
                            </option>
                        </select>
                        <select class="form-select mb-3" id="zone_id" name="zone_id" required>
                            <option value="">Seleccione Transporte</option>
                            <option value="hilton">
                                <i class="fas fa-hotel me-2"></i>
                                Bus
                            <option value="sofitel">
                                <i class="fas fa-hotel me-2"></i>
                                Taxi
                            </option>
                        </select>
                        <select class="form-select mb-3" id="zone_id" name="zone_id" required>
                            <option value="">Restaurante</option>
                            <option value="Turismo en Kayack">
                                <i class="fas fa-hotel me-2"></i>
                                Candy Vista Lago
                            </option>
                            <option value="Senderismo">
                                <i class="fas fa-hotel me-2"></i>
                                Restaurante La Perla
                            </option>
                        </select>
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
                    <i class="fas fa-map-marked-alt me-2"></i>Zonas Turísticas
                </div>
                <div class="card-body">
                    <?php if (empty($zones)): ?>
                        <p class="text-muted">No hay zonas turísticas registradas.</p>
                    <?php else: ?>
<<<<<<< HEAD
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Ubicación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($zones as $zone): ?>
                                        <tr>
                                            <td>

                                            </td>
                                            <td><?php echo htmlspecialchars(substr($zone['nombre'], 0, 14)); ?></td>
                                            <td><?php echo htmlspecialchars($zone['ubicacion']); ?></td>
                                            <td>
                                                <a href="edit_zone.php?id=<?php echo $zone['id']; ?>"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteZone(<?php echo $zone['id']; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
=======
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($zones as $zone): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($zone['main_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($zone['main_image']); ?>" 
                                             class="zone-thumbnail" 
                                             alt="<?php echo htmlspecialchars($zone['nombre']); ?>">
                                        <?php else: ?>
                                        <div class="zone-thumbnail bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars(substr($zone['nombre'],0,14)); ?></td>
                                    <td><?php echo htmlspecialchars($zone['ubicacion']); ?></td>
                                    <td>
                                        <a href="edit_zone.php?id=<?php echo $zone['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteZone(<?php echo $zone['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
>>>>>>> 3d99578d491a5d13935035343f2b1f70c5f8fd22
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

    .zone-thumbnail {
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

    .form-control {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #219150;
        box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25);
    }
</style>

<script>
    function deleteZone(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta zona turística?')) {
            window.location.href = `delete_zone.php?id=${id}`;
        }
    }
</script>

<?php require_once 'includes/footer.php'; ?>