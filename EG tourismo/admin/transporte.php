<?php
require_once '../backend/conexion.php';
$tipos = [];
$sql = "SELECT DISTINCT tipo_transporte FROM transporte";
$result = $conexion->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tipos[] = $row['tipo_transporte'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportes</title>
    <link rel="stylesheet" href="../SWEETALERT/sweetalert2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(41, 128, 185, 0.08);
            border: none;
            margin-bottom: 2rem;
        }
        .card-header {
            background: #2980b9;
            color: #fff;
            border-radius: 18px 18px 0 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .transport-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .table th {
            font-weight: 600;
            color: #2980b9;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #2980b9;
            box-shadow: 0 0 0 0.2rem rgba(41, 128, 185, 0.25);
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
                    <i class="fas fa-bus me-2"></i>Nuevo Transporte
                </div>
                <div class="card-body">
                    <form id="transportForm" method="POST" enctype="multipart/form-data">
                         <select class="form-select mb-3" id="transporte" name="tipo_transporte" required>
                            <option value="">Seleccione Tipo de Transporte</option>
                            <?php foreach ($tipos as $tipo): ?>
                                <option value="<?php echo htmlspecialchars($tipo); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mb-3">
                            <label for="provider" class="form-label">Proveedor</label>
                            <input type="email" class="form-control" name="correo" placeholder="agenciamiguel@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="provider" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="provider" class="form-label">Telefono</label>
                            <input type="name" class="form-control" name="telefono" placeholder="+240 222 453 765" required>
                        </div>
                        <div class="mb-3">
                            <label for="route" class="form-label">Ruta / Cobertura</label>
                            <input type="text" class="form-control" name="ruta" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" name="foto" accept="image/*" required>
                        </div>
                        <input type="submit" value="Registrar Transporte" class="btn btn-primary w-100 fas fa-save me-2 ">
                          <!-- <i class="fas fa-save me-2"></i>Guardar -->
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-2"></i>Transportes Registrados
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="transportTable">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Tipo</th>
                                    <th>Proveedor</th>
                                    <th>Ruta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="transportTableBody">
                                <!-- Transportes agregados dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="../SWEETALERT/sweetalert2.all.js"></script>
<script src="./js/transporte.js"></script>
 <!-- <script src="./js/trans.js"></script> -->
</body>
</html>
