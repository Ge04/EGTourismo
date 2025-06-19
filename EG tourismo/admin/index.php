<?php
session_start();
require_once '../backend/classes/Admin.php';
require_once '../backend/conexion.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Login form submitted");
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    error_log("Email: " . $email);
    error_log("Password length: " . strlen($password));
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor complete todos los campos.';
        error_log("Empty fields error");
    } else {
        $admin = new Admin();
        $result = $admin->login($email, $password);
        error_log("Login result: " . print_r($result, true));
        
        if ($result['success']) {
            $_SESSION['admin_id'] = $result['admin']['id'];
            $_SESSION['admin_name'] = $result['admin']['name'];
            $_SESSION['success'] = 'Bienvenido al panel de administración.';
            error_log("Login successful, redirecting to dashboard");
            header('Location: dashboard.php');
            exit;
        } else {
            $error = $result['message'];
            error_log("Login failed: " . $error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - EG Turismo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
     <!-- <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #219150;
            --secondary-color: #1e7e34;
            --accent-color: #43b36a;
            --text-color: #2c3e50;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #666;
            margin: 0;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 0.8rem 1rem;
            border: 1px solid #e0e0e0;
            font-size: 1rem;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(33, 145, 80, 0.25);
            border-color: var(--primary-color);
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 500;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-login:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .form-floating label {
            padding-left: 1rem;
        }
        
        .form-floating > .form-control {
            padding-left: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>EG Turismo</h1>
                <p>Panel de Administración</p>
            </div>
            
            <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
                    <label for="email">Correo electrónico</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    <label for="password">Contraseña</label>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 