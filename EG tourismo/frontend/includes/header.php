<?php
$prefix = (basename($_SERVER['SCRIPT_NAME']) === 'index.php') ? 'pages/' : '';
?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo ($prefix ? '../' : ''); ?>index.php">
            <i class="fas fa-palm-tree me-2"></i>Guinea Ecuatorial Turismo
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>index.php">Inicio</a>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>visa.php">Visa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>vuelos.php">Vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>hoteles.php">Hoteles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>transporte.php">Transporte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>restaurantes.php">Restaurantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>actividades.php">Actividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $prefix; ?>zonas.php">Zonas de Turismo</a>
                </li>
            </ul>
        </div>
    </div>
</nav> 