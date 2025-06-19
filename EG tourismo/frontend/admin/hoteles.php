    <!-- Add Hotel Modal -->
    <div class="modal fade" id="addHotelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addHotelForm" action="actions/crear_hotel.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Hotel</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ubicación</label>
                                <input type="text" name="ubicacion" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Habitaciones</label>
                                <input type="number" name="habitaciones" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio por Noche</label>
                                <input type="number" name="precio" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Características</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="wifi" id="wifi">
                                        <label class="form-check-label" for="wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="pool" id="pool">
                                        <label class="form-check-label" for="pool">Piscina</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="parking" id="parking">
                                        <label class="form-check-label" for="parking">Estacionamiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imágenes</label>
                            <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="addHotelForm" class="btn btn-primary">Guardar Hotel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Hotel Modal -->
    <div class="modal fade" id="editHotelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editHotelForm" action="actions/actualizar_hotel.php" method="POST" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="hotel_id" id="edit_hotel_id"> -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Hotel</label>
                                <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ubicación</label>
                                <input type="text" name="ubicacion" id="edit_ubicacion" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Habitaciones</label>
                                <input type="number" name="habitaciones" id="edit_habitaciones" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio por Noche</label>
                                <input type="number" name="precio" id="edit_precio" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Características</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="wifi" id="edit_wifi">
                                        <label class="form-check-label" for="edit_wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="pool" id="edit_pool">
                                        <label class="form-check-label" for="edit_pool">Piscina</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" value="parking" id="edit_parking">
                                        <label class="form-check-label" for="edit_parking">Estacionamiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imágenes Actuales</label>
                            <div id="currentImages" class="row mb-2"></div>
                            <label class="form-label">Nuevas Imágenes</label>
                            <input type="file" name="nuevas_imagenes[]" class="form-control" multiple accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="editHotelForm" class="btn btn-primary">Actualizar Hotel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('col-md-3');
            document.querySelector('.sidebar').classList.toggle('col-md-1');
            document.querySelector('.main-content').classList.toggle('col-md-9');
            document.querySelector('.main-content').classList.toggle('col-md-11');
        });

        // Función para cargar los datos del hotel en el modal de edición
        function loadHotelData(hotelId) {
            fetch(`actions/obtener_hotel.php?id=${hotelId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_hotel_id').value = data.id;
                    document.getElementById('edit_nombre').value = data.nombre;
                    document.getElementById('edit_ubicacion').value = data.ubicacion;
                    document.getElementById('edit_habitaciones').value = data.habitaciones;
                    document.getElementById('edit_precio').value = data.precio;
                    document.getElementById('edit_descripcion').value = data.descripcion;
                    
                    // Marcar características
                    document.getElementById('edit_wifi').checked = data.caracteristicas.includes('wifi');
                    document.getElementById('edit_pool').checked = data.caracteristicas.includes('pool');
                    document.getElementById('edit_parking').checked = data.caracteristicas.includes('parking');
                    
                    // Mostrar imágenes actuales
                    const currentImages = document.getElementById('currentImages');
                    currentImages.innerHTML = '';
                    data.imagenes.forEach(imagen => {
                        currentImages.innerHTML += `
                            <div class="col-md-4 mb-2">
                                <img src="${imagen}" class="img-fluid rounded" alt="Imagen del hotel">
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para eliminar hotel
        function deleteHotel(hotelId) {
            if (confirm('¿Estás seguro de que deseas eliminar este hotel?')) {
                fetch('actions/eliminar_hotel.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: hotelId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(`[data-hotel-id="${hotelId}"]`);
                        animateCardExit(card);
                    } else {
                        alert('Error al eliminar el hotel');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Función para animar la salida de las tarjetas
        function animateCardExit(card) {
            const cardElement = card.closest('.hotel-card');
            cardElement.style.opacity = '0';
            cardElement.style.transform = 'translateX(-100%)';
            setTimeout(() => {
                cardElement.remove();
            }, 500);
        }

        // Agregar eventos a los botones de editar y eliminar
        document.querySelectorAll('.dropdown-item').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.hotel-card');
                const hotelId = card.dataset.hotelId;

                if (this.classList.contains('text-danger')) {
                    deleteHotel(hotelId);
                } else if (this.querySelector('.fa-edit')) {
                    loadHotelData(hotelId);
                    new bootstrap.Modal(document.getElementById('editHotelModal')).show();
                }
            });
        });

        // Manejar el envío del formulario de edición
        document.getElementById('editHotelForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('actions/actualizar_hotel.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar el hotel');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script> 