<?php
require_once '../backend/conexion.php';
$tipos = [];
$sql = "SELECT DISTINCT tipo FROM actividad";
$result = $conexion->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tipos[] = $row['tipo'];
    }
}

$servicios = [];
$sqlServicios = "SELECT DISTINCT nombre FROM servicios";
$resultServicios = $conexion->query($sqlServicios);
if ($resultServicios) {
    while ($row = $resultServicios->fetch_assoc()) {
        $servicios[] = $row['nombre'];
    }
}

$estrellas = [];
$sqlEstrellas = "SELECT DISTINCT estrellas FROM hotel";
$resultEstrellas = $conexion->query($sqlEstrellas);
if ($resultEstrellas) {
    while ($row = $resultEstrellas->fetch_assoc()) {
        $estrellas[] = $row['estrellas'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(241, 196, 15, 0.08);
            border: none;
            margin-bottom: 2rem;
        }
        .card-header {
            background: #f1c40f;
            color: #fff;
            border-radius: 18px 18px 0 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .hotel-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .table th {
            font-weight: 600;
            color: #f1c40f;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #f1c40f;
            box-shadow: 0 0 0 0.2rem rgba(241, 196, 15, 0.25);
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<?php include "./includes/header.php" ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-hotel me-2"></i>Nuevo Hotel
                </div>
                <div class="card-body">
                    <form id="hotelForm" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Hotel</label>
                            <input type="text" class="form-control" id="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicacion</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="stars" class="form-label">Servicios</label>
                            <select class="form-control" id="stars" name="servicios" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($servicios as $servicio): ?>
                                    <option value="<?php echo htmlspecialchars($servicio); ?>"><?php echo htmlspecialchars($servicio); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stars" class="form-label">Actividades</label>
                            <select class="form-control" id="stars" name="actividad" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stars" class="form-label">Estrellas</label>
                            <select class="form-control" id="stars" name="estrellas" required>
                                <?php foreach ($estrellas as $estrella): ?>
                                    <option value="<?php echo htmlspecialchars($estrella); ?>"><?php echo htmlspecialchars($estrella); ?> estrellas</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" name="foto" accept="image/*" required>
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
                    <i class="fas fa-bed me-2"></i>Hoteles Registrados
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="hotelTable">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Estrellas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="hotelTableBody">
                                <!-- Hoteles agregados dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('hotelForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const location = document.getElementById('location').value;
        const stars = document.getElementById('stars').value;
        const imageInput = document.getElementById('image');

        const tableBody = document.querySelector('#hotelTable tbody');
        const newRow = document.createElement('tr');

        const imageCell = document.createElement('td');
        const image = document.createElement('img');
        image.className = 'hotel-thumbnail';
        image.src = URL.createObjectURL(imageInput.files[0]);
        image.onload = () => URL.revokeObjectURL(image.src);
        imageCell.appendChild(image);

        const nameCell = document.createElement('td');
        nameCell.textContent = name;

        const locationCell = document.createElement('td');
        locationCell.textContent = location;

        const starsCell = document.createElement('td');
        starsCell.textContent = stars + ' ★';

        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-sm btn-outline-danger';
        deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
        deleteButton.onclick = () => newRow.remove();
        actionCell.appendChild(deleteButton);

        newRow.appendChild(imageCell);
        newRow.appendChild(nameCell);
        newRow.appendChild(locationCell);
        newRow.appendChild(starsCell);
        newRow.appendChild(actionCell);

        tableBody.appendChild(newRow);

        document.getElementById('hotelForm').reset();
    });
</script>
<script src="./js/hotel.js"></script>
</body>
</html>
