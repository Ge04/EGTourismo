


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estadísticas Turísticas</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card {
      border-radius: 18px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      border: none;
      margin-bottom: 2rem;
    }
    .card-header {
      background: #2c3e50;
      color: #fff;
      border-radius: 18px 18px 0 0;
      font-weight: 600;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
    <?php include "./includes/header.php"; ?>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-chart-bar me-2"></i>Visitas por Zona Turística
          </div>
          <div class="card-body">
            <canvas id="zonaChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-chart-pie me-2"></i>Tipos de Transporte Utilizados
          </div>
          <div class="card-body">
            <canvas id="transporteChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-chart-line me-2"></i>Reservas de Hoteles por Mes
          </div>
          <div class="card-body">
            <canvas id="hotelesChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/grafica.js"></script>
  <script src="./js/grafica2.js"></script>
  <script src="./js/grafica3.js"></script>
</body>
</html>
