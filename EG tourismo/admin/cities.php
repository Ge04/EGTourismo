<?php
session_start();
require_once '../backend/classes/City.php';
require_once '../backend/classes/Zone.php';
require_once 'includes/header.php';

$cityObj = new City();
$zoneObj = new Zone();
$zones = $zoneObj->getAllZones();
$cities = $cityObj->getAllCities();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zoneId = intval($_POST['zone_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $latitude = trim($_POST['latitude'] ?? '');
    $longitude = trim($_POST['longitude'] ?? '');
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'img/cities/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $imageName = uniqid('city_') . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $targetFile;
        }
    }
    if ($zoneId && $name && $description) {
        $cityObj->createCity($zoneId, $name, $description, $latitude, $longitude, $image);
        header('Location: cities.php?success=1');
        exit;
    } else {
        $error = 'Todos los campos obligatorios deben ser completados.';
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-plus me-2"></i>Nueva Ciudad
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Ciudad creada exitosamente.</div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="zone_id" class="form-label">Zona</label>
                            <select class="form-select" id="zone_id" name="zone_id" required>
                                <option value="">Seleccione una zona</option>
                                <?php foreach ($zones as $zone): ?>
                                    <option value="<?php echo $zone['id']; ?>"><?php echo htmlspecialchars($zone['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitud (opcional)</label>
                            <input type="text" class="form-control" id="latitude" name="latitude">
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitud (opcional)</label>
                            <input type="text" class="form-control" id="longitude" name="longitude">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen (opcional)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-city me-2"></i>Ciudades
                </div>
                <div class="card-body">
                    <?php if (empty($cities)): ?>
                        <p class="text-muted">No hay ciudades registradas.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Zona</th>
                                        <th>Latitud</th>
                                        <th>Longitud</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cities as $city): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($city['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($city['image']); ?>" class="zone-thumbnail" alt="<?php echo htmlspecialchars($city['name']); ?>">
                                                <?php else: ?>
                                                    <div class="zone-thumbnail bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($city['name']); ?></td>
                                            <td><?php echo htmlspecialchars($city['zone_name']); ?></td>
                                            <td><?php echo htmlspecialchars($city['latitude']); ?></td>
                                            <td><?php echo htmlspecialchars($city['longitude']); ?></td>
                                            <td>
                                                <a href="edit_city.php?id=<?php echo $city['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteCity(<?php echo $city['id']; ?>)">
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
    .card { border-radius: 18px; box-shadow: 0 4px 16px rgba(33, 145, 80, 0.08); border: none; margin-bottom: 2rem; }
    .card-header { background: #219150; color: #fff; border-radius: 18px 18px 0 0; font-weight: 600; font-size: 1.1rem; }
    .zone-thumbnail { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    .table { margin-bottom: 0; }
    .table th { font-weight: 600; color: #219150; }
    .btn { border-radius: 8px; font-weight: 500; }
    .form-control { border-radius: 8px; border: 1px solid #e0e0e0; }
    .form-control:focus { border-color: #219150; box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25); }
</style>
<script>
function deleteCity(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta ciudad?')) {
        window.location.href = `delete_city.php?id=${id}`;
    }
}
</script>
<?php require_once 'includes/footer.php'; ?> 