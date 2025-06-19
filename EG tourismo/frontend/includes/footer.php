<?php
$prefix = (basename($_SERVER['SCRIPT_NAME']) === 'index.php') ? 'pages/' : '';
?>
<footer class="footer" style="background: linear-gradient(135deg, #007A33, #004D26); color: #fff; padding: 3rem 0 1rem 0;">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-4 mb-4">
                <h4 class="footer-heading fw-bold">Guinea Ecuatorial Turismo</h4>
                <p>Tu guía oficial para descubrir las maravillas de Guinea Ecuatorial, el paraíso tropical de África Central.</p>
                <div class="social-icons mt-3">
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <h4 class="footer-heading fw-bold">Enlaces Rápidos</h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $prefix; ?>visa.php" class="text-white text-decoration-none">Visa</a></li>
                    <li><a href="<?php echo $prefix; ?>vuelos.php" class="text-white text-decoration-none">Vuelos</a></li>
                    <li><a href="<?php echo $prefix; ?>hoteles.php" class="text-white text-decoration-none">Hoteles</a></li>
                    <li><a href="<?php echo $prefix; ?>transporte.php" class="text-white text-decoration-none">Transporte</a></li>
                    <li><a href="<?php echo $prefix; ?>restaurantes.php" class="text-white text-decoration-none">Restaurantes</a></li>
                    <li><a href="<?php echo $prefix; ?>actividades.php" class="text-white text-decoration-none">Actividades</a></li>
                    <li><a href="<?php echo $prefix; ?>zonas.php" class="text-white text-decoration-none">Zonas de Turismo</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h4 class="footer-heading fw-bold">Destinos Populares</h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $prefix; ?>zonas.php#malabo" class="text-white text-decoration-none">Malabo</a></li>
                    <li><a href="<?php echo $prefix; ?>zonas.php#bata" class="text-white text-decoration-none">Bata</a></li>
                    <li><a href="<?php echo $prefix; ?>zonas.php#moca" class="text-white text-decoration-none">Moca</a></li>
                    <li><a href="<?php echo $prefix; ?>zonas.php#ureca" class="text-white text-decoration-none">Ureca</a></li>
                    <li><a href="<?php echo $prefix; ?>zonas.php#annobon" class="text-white text-decoration-none">Annobón</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h4 class="footer-heading fw-bold">Contacto</h4>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Ministerio de Turismo, Malabo, Guinea Ecuatorial</li>
                    <li><i class="fas fa-phone me-2"></i> +240 123 456 789</li>
                    <li><i class="fas fa-envelope me-2"></i> info@turismo-ge.com</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-4 pt-4 border-top border-light">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Ministerio de Turismo de Guinea Ecuatorial. Todos los derechos reservados.</p>
        </div>
    </div>
</footer> 