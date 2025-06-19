<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Hotel | Guinea Ecuatorial Turismo</title>
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
     <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-palm-tree me-2"></i>Guinea Ecuatorial Turismo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="hoteles.php">Hoteles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visa.php">Visa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transporte.php">Transporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vuelos.php">Vuelos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actividades.php">Actividades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="zonas.php">Zonas de Turismo</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Progreso de la Reserva -->
                    <div class="reservation-progress mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button onclick="window.history.back()" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </button>
                            <h4 class="mb-0">Reserva de Hotel</h4>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="badge bg-primary">1. Detalles</span>
                            <span class="badge bg-secondary">2. Pago</span>
                            <span class="badge bg-secondary">3. Confirmación</span>
                        </div>
                    </div>

                    <!-- Resumen de la Reserva -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Resumen de la Reserva</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-fluid rounded" alt="Sofitel Malabo">
                                </div>
                                <div class="col-md-8">
                                    <h5>Sofitel Malabo</h5>
                                    <p class="text-muted">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        Malabo, Bioko Norte, Guinea Ecuatorial
                                    </p>
                                    <div class="reservation-details">
                                        <p><strong>Habitación:</strong> Suite Ejecutiva</p>
                                        <p><strong>Llegada:</strong> <span id="check-in-date">15/03/2024</span></p>
                                        <p><strong>Salida:</strong> <span id="check-out-date">20/03/2024</span></p>
                                        <p><strong>Huéspedes:</strong> 2 Adultos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Reserva -->
                    <form id="reservation-form" class="needs-validation" novalidate>
                        <!-- Información Personal -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Información Personal</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese su nombre
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellidos *</label>
                                        <input type="text" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese sus apellidos
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un email válido
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono *</label>
                                        <input type="tel" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese su teléfono
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Pago -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Información de Pago</h4>
                                <div class="mb-3">
                                    <label class="form-label">Número de Tarjeta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                                        <span class="input-group-text">
                                            <i class="fab fa-cc-visa"></i>
                                            <i class="fab fa-cc-mastercard ms-2"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingrese un número de tarjeta válido
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha de Expiración *</label>
                                        <input type="text" class="form-control" placeholder="MM/AA" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese la fecha de expiración
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV *</label>
                                        <input type="text" class="form-control" placeholder="123" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese el CVV
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre en la Tarjeta *</label>
                                    <input type="text" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre en la tarjeta
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Acepto los términos y condiciones de la reserva
                                    </label>
                                    <div class="invalid-feedback">
                                        Debe aceptar los términos y condiciones
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        Acepto la política de privacidad
                                    </label>
                                    <div class="invalid-feedback">
                                        Debe aceptar la política de privacidad
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Proceder al Pago
                            <i class="fas fa-lock ms-2"></i>
                        </button>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="card sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Resumen del Pago</h4>
                            <div class="reservation-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Suite Ejecutiva (5 noches)</span>
                                    <span>1.250€</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Impuestos y cargos</span>
                                    <span>125€</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Total</strong>
                                    <strong class="text-primary">1.375€</strong>
                                </div>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    El pago se procesará de forma segura
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        // Validación del formulario
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html> 