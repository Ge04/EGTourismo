<?php
require_once '../backend/config/config.php';
require_once '../backend/classes/Restaurant.php';

// Initialize Restaurant object
$restaurant = new Restaurant();

// Get all restaurants
$restaurants = $restaurant->getAllRestaurants();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(33,145,80,0.08);
            border: none;
            margin-bottom: 2rem;
        }
        .card-header {
            background: #d35400;
            color: #fff;
            border-radius: 18px 18px 0 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .restaurant-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .table th {
            font-weight: 600;
            color: #d35400;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #d35400;
            box-shadow: 0 0 0 0.2rem rgba(211, 84, 0, 0.25);
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
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
                    <div class="header-actions">
                        <div>
                            <i class="fas fa-utensils me-2"></i>Nuevo Restaurante
                        </div>
                        <a href="../frontend/pages/restaurantes.php" class="btn btn-light btn-sm" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Ver en Frontend
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="restaurantForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="header-actions">
                        <div>
                            <i class="fas fa-list me-2"></i>Restaurantes Registrados
                        </div>
                        <a href="../frontend/pages/restaurantes.php" class="btn btn-light btn-sm" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Ver en Frontend
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="restaurantTable">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRestaurante">
                                <!-- Los restaurantes aparecerán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Add Restaurant Modal -->
    <div class="modal fade" id="addRestaurantModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Restaurante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addRestaurantForm" action="actions/crear_restaurante.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Restaurante</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ubicación</label>
                                <input type="text" name="ubicacion" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Cocina</label>
                                <select name="tipo_cocina" class="form-control" required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="internacional">Internacional</option>
                                    <option value="local">Local</option>
                                    <option value="italiana">Italiana</option>
                                    <option value="japonesa">Japonesa</option>
                                    <option value="mexicana">Mexicana</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio Promedio</label>
                                <input type="text" name="precio_promedio" class="form-control" placeholder="Ej: $25-50" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Restaurant Modal -->
    <div class="modal fade" id="editRestaurantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Restaurante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="actions/actualizar_restaurante.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="edit_ubicacion" name="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tipo_cocina" class="form-label">Tipo de Cocina</label>
                            <input type="text" class="form-control" id="edit_tipo_cocina" name="tipo_cocina" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_precio_medio" class="form-label">Precio Medio</label>
                            <input type="text" class="form-control" id="edit_precio_medio" name="precio_medio" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_horario" class="form-label">Horario</label>
                            <input type="text" class="form-control" id="edit_horario" name="horario">
                        </div>
                        <div class="mb-3">
                            <label for="edit_imagen" class="form-label">Nueva Imagen</label>
                            <input type="file" class="form-control" id="edit_imagen" name="imagen" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar en móvil
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Función para editar restaurante
        function editRestaurant(id) {
            // Fetch restaurant data and populate modal
            $.get('actions/obtener_restaurante.php', {id: id}, function(data) {
                $('#edit_id').val(data.id);
                $('#edit_nombre').val(data.nombre);
                $('#edit_ubicacion').val(data.ubicacion);
                $('#edit_tipo_cocina').val(data.tipo_cocina);
                $('#edit_precio_medio').val(data.precio_medio);
                $('#edit_descripcion').val(data.descripcion);
                $('#edit_horario').val(data.horario);
                $('#editRestaurantModal').modal('show');
            });
        }

        // Función para eliminar restaurante
        function deleteRestaurant(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este restaurante?')) {
                $.post('actions/eliminar_restaurante.php', {id: id}, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el restaurante');
                    }
                });
            }
        }
    </script>
    <script src="./js/restaurantes.js"></script>
</body>
</html>
