<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Zone.php';
require_once '../../backend/classes/City.php';

$zone = new Zone();
$city = new City();

$zones = $zone->getAllZones();
$selectedZoneId = isset($_GET['zone']) ? intval($_GET['zone']) : ($zones[0]['id'] ?? null);
$selectedCityId = isset($_GET['city']) ? intval($_GET['city']) : null;

$zoneData = null;
$cityData = null;
$cityServices = null;

if ($selectedZoneId) {
    $zoneData = $zone->getZoneById($selectedZoneId);
    $cities = $city->getCitiesByZone($selectedZoneId);
    
    if ($selectedCityId) {
        $cityData = $city->getCityById($selectedCityId);
        $cityServices = $city->getCityServices($selectedCityId);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas de Turismo - EG Turismo</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../frontend/assets/css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }
        
        .zone-filter-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 0;
            margin-bottom: 3rem;
        }
        
        .zone-filter-btns {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .zone-btn {
            background: white;
            border: 2px solid #219150;
            color: #219150;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(33, 145, 80, 0.1);
        }
        
        .zone-btn:hover {
            background: #219150;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 145, 80, 0.2);
        }
        
        .zone-btn.active {
            background: #219150;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 145, 80, 0.3);
        }
        
        .city-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
        }
        
        .city-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .city-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .city-card .card-body {
            padding: 1.5rem;
        }
        
        .city-title {
            color: #219150;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .city-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .city-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .btn-explore {
            background: #219150;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-explore:hover {
            background: #1a7340;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-map {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-map:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-1px);
        }
        
        .service-filter {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .service-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .service-tab {
            background: #f8f9fa;
            border: none;
            color: #666;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .service-tab:hover {
            background: #e9ecef;
            color: #219150;
        }
        
        .service-tab.active {
            background: #219150;
            color: white;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .service-card .card-body {
            padding: 1.5rem;
        }
        
        .service-title {
            color: #219150;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .service-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .service-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .service-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Descubre Guinea Ecuatorial</h1>
            <p class="lead">Explora las maravillosas zonas y ciudades turísticas</p>
        </div>
    </div>
    <div class="zone-filter-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark mb-3">Selecciona una Zona</h2>
                <p class="text-muted">Explora las ciudades y sus servicios turísticos</p>
            </div>
            <div class="zone-filter-btns">
                <?php foreach ($zones as $zoneItem): ?>
                    <a href="#" 
                       class="zone-btn<?php if ($zoneItem['id'] == $selectedZoneId) echo ' active'; ?>" 
                       data-zone="<?php echo $zoneItem['id']; ?>">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <?php echo htmlspecialchars($zoneItem['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="zone-content">
            <?php if ($zoneData): ?>
                <div class="text-center mb-4 fade-in">
                    <h1 class="zone-title"><?php echo htmlspecialchars($zoneData['name']); ?></h1>
                    <p class="zone-description"><?php echo htmlspecialchars($zoneData['description']); ?></p>
                </div>
                
                <div class="row g-4">
                    <?php foreach ($cities as $cityItem): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="city-card">
                            <?php if (!empty($cityItem['image'])): ?>
                                <img src="<?php echo htmlspecialchars($cityItem['image']); ?>" 
                                     class="city-image" 
                                     alt="<?php echo htmlspecialchars($cityItem['name']); ?>">
                            <?php else: ?>
                                <div class="city-image d-flex align-items-center justify-content-center" 
                                     style="background: linear-gradient(45deg, #219150, #1a7340);">
                                    <i class="fas fa-city text-white" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h3 class="city-title"><?php echo htmlspecialchars($cityItem['name']); ?></h3>
                                <p class="city-description"><?php echo htmlspecialchars($cityItem['description']); ?></p>
                                <div class="city-actions">
                                    <a href="#" class="btn btn-explore" data-city="<?php echo $cityItem['id']; ?>">
                                        <i class="fas fa-compass me-2"></i>Explorar más
                                    </a>
                                    <?php if ($cityItem['latitude'] && $cityItem['longitude']): ?>
                                    <a href="https://www.google.com/maps?q=<?php echo $cityItem['latitude']; ?>,<?php echo $cityItem['longitude']; ?>" 
                                       target="_blank" class="btn btn-map">
                                        <i class="fas fa-map me-2"></i>Ver mapa
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div id="city-services" style="display: none;">
            <div class="service-filter">
                <h3 id="city-name" class="mb-3"></h3>
                <div class="service-tabs">
                    <button class="service-tab active" data-type="hotels">
                        <i class="fas fa-hotel me-2"></i>Hoteles
                    </button>
                    <button class="service-tab" data-type="restaurants">
                        <i class="fas fa-utensils me-2"></i>Restaurantes
                    </button>
                    <button class="service-tab" data-type="transport">
                        <i class="fas fa-car me-2"></i>Transporte
                    </button>
                    <button class="service-tab" data-type="activities">
                        <i class="fas fa-hiking me-2"></i>Actividades
                    </button>
                    <button class="service-tab" data-type="gallery">
                        <i class="fas fa-images me-2"></i>Galería
                    </button>
                </div>
            </div>
            
            <div id="services-content"></div>
        </div>
        
        <div id="loading-spinner" class="loading-spinner">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando información...</p>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    
    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const zoneButtons = document.querySelectorAll('.zone-btn');
            const zoneContent = document.getElementById('zone-content');
            const cityServices = document.getElementById('city-services');
            const loadingSpinner = document.getElementById('loading-spinner');
            const cityName = document.getElementById('city-name');
            const servicesContent = document.getElementById('services-content');
            const serviceTabs = document.querySelectorAll('.service-tab');
            
            let currentCityId = null;
            
            // Zone filter
            zoneButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const zoneId = this.getAttribute('data-zone');
                    
                    // Update active button
                    zoneButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show loading
                    zoneContent.style.display = 'none';
                    cityServices.style.display = 'none';
                    loadingSpinner.style.display = 'block';
                    
                    // Fetch zone data
                    fetch(`get_zone_data.php?zone=${zoneId}`)
                        .then(response => response.text())
                        .then(html => {
                            zoneContent.innerHTML = html;
                            zoneContent.style.display = 'block';
                            loadingSpinner.style.display = 'none';
                            
                            // Add fade-in animation
                            zoneContent.classList.add('fade-in');
                            
                            // Update URL without page reload
                            const url = new URL(window.location);
                            url.searchParams.set('zone', zoneId);
                            url.searchParams.delete('city');
                            window.history.pushState({}, '', url);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            loadingSpinner.style.display = 'none';
                            zoneContent.style.display = 'block';
                        });
                });
            });
            
            // City explore buttons
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-explore')) {
                    e.preventDefault();
                    const cityId = e.target.closest('.btn-explore').getAttribute('data-city');
                    loadCityServices(cityId);
                }
            });
            
            // Service tabs
            serviceTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const serviceType = this.getAttribute('data-type');
                    
                    // Update active tab
                    serviceTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (currentCityId) {
                        loadServicesByType(currentCityId, serviceType);
                    }
                });
            });
            
            function loadCityServices(cityId) {
                currentCityId = cityId;
                
                // Show loading
                loadingSpinner.style.display = 'block';
                
                fetch(`get_city_services.php?city_id=${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        cityName.textContent = data.city.name;
                        cityServices.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                        
                        // Load hotels by default
                        loadServicesByType(cityId, 'hotels');
                        
                        // Update URL
                        const url = new URL(window.location);
                        url.searchParams.set('city', cityId);
                        window.history.pushState({}, '', url);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingSpinner.style.display = 'none';
                    });
            }
            
            function loadServicesByType(cityId, serviceType) {
                loadingSpinner.style.display = 'block';
                
                fetch(`get_city_services.php?city_id=${cityId}&type=${serviceType}`)
                    .then(response => response.json())
                    .then(data => {
                        const services = data.services;
                        let html = '';
                        
                        if (Array.isArray(services) && services.length > 0) {
                            html = '<div class="row g-4">';
                            services.forEach(service => {
                                html += createServiceCard(service, serviceType);
                            });
                            html += '</div>';
                        } else {
                            html = createEmptyState(serviceType);
                        }
                        
                        servicesContent.innerHTML = html;
                        loadingSpinner.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingSpinner.style.display = 'none';
                    });
            }
            
            function createServiceCard(service, type) {
                const icons = {
                    hotels: 'fas fa-hotel',
                    restaurants: 'fas fa-utensils',
                    transport: 'fas fa-car',
                    activities: 'fas fa-hiking',
                    gallery: 'fas fa-images'
                };
                
                const badges = {
                    hotels: service.price_range || 'Disponible',
                    restaurants: service.cuisine_type || 'Disponible',
                    transport: service.transport_type || 'Disponible',
                    activities: service.category || 'Disponible',
                    gallery: 'Imagen'
                };
                
                const badgeColors = {
                    hotels: 'bg-primary',
                    restaurants: 'bg-warning text-dark',
                    transport: 'bg-secondary',
                    activities: 'bg-info',
                    gallery: 'bg-success'
                };
                
                return `
                    <div class="col-md-6 col-lg-4">
                        <div class="service-card">
                            <div class="card-body">
                                <h5 class="service-title">
                                    <i class="${icons[type]} me-2"></i>
                                    ${service.name}
                                </h5>
                                <p class="service-description">${service.description || 'Sin descripción disponible'}</p>
                                <span class="service-badge ${badgeColors[type]}">${badges[type]}</span>
                                <div class="service-actions">
                                    <button class="btn btn-explore btn-sm" onclick="viewGallery(${service.id}, '${type}')">
                                        <i class="fas fa-images me-1"></i>Ver Galería
                                    </button>
                                    ${service.latitude && service.longitude ? 
                                        `<a href="https://www.google.com/maps?q=${service.latitude},${service.longitude}" target="_blank" class="btn btn-map btn-sm">
                                            <i class="fas fa-map me-1"></i>Ver Mapa
                                        </a>` : ''
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            function createEmptyState(type) {
                const messages = {
                    hotels: 'No hay hoteles registrados en esta ciudad',
                    restaurants: 'No hay restaurantes registrados en esta ciudad',
                    transport: 'No hay servicios de transporte registrados en esta ciudad',
                    activities: 'No hay actividades registradas en esta ciudad',
                    gallery: 'No hay imágenes en la galería de esta ciudad'
                };
                
                return `
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-${type === 'gallery' ? 'images' : type.slice(0, -1)}"></i>
                            <h4>${messages[type]}</h4>
                            <p>Próximamente tendremos más opciones disponibles</p>
                        </div>
                    </div>
                `;
            }
        });
        
        function viewGallery(serviceId, type) {
            // This would open a modal or navigate to a gallery page
            alert(`Galería de ${type} - ID: ${serviceId}`);
        }
    </script>
</body>
</html> 