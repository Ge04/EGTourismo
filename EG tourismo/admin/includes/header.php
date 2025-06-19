<?php
require_once '../backend/classes/Admin.php';
require_once __DIR__ . '/../../backend/config/config.php';

if (!isset($_SESSION['admin_id']) && basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'register.php') {
    header('Location: index.php');
    exit;
}

$admin = new Admin();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - EG Turismo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #219150;
            --secondary-color: #1e7e34;
            --accent-color: #43b36a;
            --text-color: #2c3e50;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            /* min-height: 100vh; */
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 245px;
            background: var(--primary-color);
            padding: 20px 0;
            color: #fff;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            padding: 0 1rem;
            text-align: center;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            display: block;
            border-radius: 8px;
            margin: 0.3rem 1rem;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--secondary-color);
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid #e0e0e0;
        }

        .content-area {
            flex: 1;
            padding: 2rem;
            background: var(--light-bg);
        }

        /* Remove conflicting container styles */
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            max-width: none !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25);
            border-color: var(--primary-color);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px 0 0 8px;
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .content-area {
                padding: 1rem;
            }

            .admin-header {
                padding: 1rem;
            }

            .mobile-toggle {
                display: block;
            }
        }

        .mobile-toggle {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        <div class="sidebar" id="sidebar">
            <h3>Admin Panel</h3>
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a href="zones.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'zones.php' ? 'active' : ''; ?>">
                <i class="fas fa-map-marked-alt"></i>Zonas Turísticas
            </a>
            <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
                <i class="fas fa-concierge-bell"></i>Servicios
            </a>
            <a href="estadisticas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'estadisticas.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>Estadísticas
            </a>
            <a href="admins.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admins.php' ? 'active' : ''; ?>">
                <i class="fas fa-users-cog"></i>Administradores
            </a>
            <a href="hoteles.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'hoteles.php' ? 'active' : ''; ?>">
                <i class="fas fa-hotel"></i>Hoteles
            </a>
            <a href="restaurantes.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'restaurantes.php' ? 'active' : ''; ?>">
                <i class="fas fa-wine-glass"></i>Restaurantes
            </a>
            <a href="transporte.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transporte.php' ? 'active' : ''; ?>">
                <i class="fas fa-car"></i>Transporte
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
            </a>
        </div>

        <div class="main-content">
            <div class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="mobile-toggle me-3" onclick="toggleSidebar()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h4 class="mb-0"><?php echo $page_title ?? 'Panel de Administración'; ?></h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-3">
                            <i class="fas fa-user me-2"></i>
                            <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- <div class="alert-container">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?> -->
            <!-- </div>
    </div>
</div> -->

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>