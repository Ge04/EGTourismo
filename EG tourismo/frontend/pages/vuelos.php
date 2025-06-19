<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuelos a Guinea Ecuatorial - EG Turismo</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <!-- Hero Section -->
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1>Vuelos a Guinea Ecuatorial</h1>
            <p>Encuentra los mejores precios y horarios para tu viaje</p>
        </div>
    </section>
    <!-- Main Content -->
    <section class="section">
        <div class="container">
            <div class="row">
                <!-- Flight Search -->
                <div class="col-lg-4">
                    <div class="flight-search">
                        <h3 class="mb-4"><i class="fas fa-search me-2"></i>Buscar Vuelos</h3>
                        <form id="flightSearchForm">
                            <div class="mb-3">
                                <label class="form-label">Origen</label>
                                <input type="text" class="form-control" id="origin" placeholder="Ciudad de origen" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Destino</label>
                                <select class="form-control" id="destination" required>
                                    <option value="SSG">Malabo (SSG)</option>
                                    <option value="BSG">Bata (BSG)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha de Ida</label>
                                <input type="date" class="form-control" id="departureDate" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha de Vuelta</label>
                                <input type="date" class="form-control" id="returnDate">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pasajeros</label>
                                <select class="form-control" id="passengers">
                                    <option value="1">1 Pasajero</option>
                                    <option value="2">2 Pasajeros</option>
                                    <option value="3">3 Pasajeros</option>
                                    <option value="4">4 Pasajeros</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Buscar Vuelos
                            </button>
                        </form>
                    </div>
                    <!-- Travel Tips -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-info-circle me-2"></i>Consejos de Vuelo</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Reserva con anticipación</li>
                                <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Verifica requisitos de visa</li>
                                <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Llega 3 horas antes</li>
                                <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Revisa restricciones de equipaje</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Flight Results -->
                <div class="col-lg-8">
                    <div id="flightResults" class="flight-results">
                        <!-- Results will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>

    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Amadeus API Integration
        const API_KEY = 'YOUR_AMADEUS_API_KEY';
        const API_SECRET = 'YOUR_AMADEUS_API_SECRET';

        async function getAmadeusToken() {
            const response = await fetch('https://test.api.amadeus.com/v1/security/oauth2/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `grant_type=client_credentials&client_id=${API_KEY}&client_secret=${API_SECRET}`
            });
            const data = await response.json();
            return data.access_token;
        }

        async function searchFlights(origin, destination, departureDate, returnDate, adults) {
            const token = await getAmadeusToken();
            const response = await fetch(`https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=${origin}&destinationLocationCode=${destination}&departureDate=${departureDate}&returnDate=${returnDate}&adults=${adults}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            return await response.json();
        }

        document.getElementById('flightSearchForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            const departureDate = document.getElementById('departureDate').value;
            const returnDate = document.getElementById('returnDate').value;
            const passengers = document.getElementById('passengers').value;

            try {
                const results = await searchFlights(origin, destination, departureDate, returnDate, passengers);
                displayResults(results);
            } catch (error) {
                console.error('Error searching flights:', error);
                alert('Error al buscar vuelos. Por favor, intente nuevamente.');
            }
        });

        function displayResults(results) {
            const resultsContainer = document.getElementById('flightResults');
            resultsContainer.innerHTML = '';

            if (!results.data || results.data.length === 0) {
                resultsContainer.innerHTML = '<div class="alert alert-info">No se encontraron vuelos disponibles.</div>';
                return;
            }

            results.data.forEach(flight => {
                const flightCard = document.createElement('div');
                flightCard.className = 'flight-card';
                flightCard.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5>${flight.itineraries[0].segments[0].carrierCode}</h5>
                            <p class="mb-0">${flight.itineraries[0].segments[0].number}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Salida</h6>
                                    <p>${flight.itineraries[0].segments[0].departure.iataCode}</p>
                                    <p>${flight.itineraries[0].segments[0].departure.at}</p>
                                </div>
                                <div>
                                    <h6>Llegada</h6>
                                    <p>${flight.itineraries[0].segments[0].arrival.iataCode}</p>
                                    <p>${flight.itineraries[0].segments[0].arrival.at}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-primary">${flight.price.total} ${flight.price.currency}</h5>
                            <p class="mb-0">${flight.numberOfBookableSeats} asientos disponibles</p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" onclick="selectFlight('${flight.id}')">
                                Seleccionar
                            </button>
                        </div>
                    </div>
                `;
                resultsContainer.appendChild(flightCard);
            });
        }

        function selectFlight(flightId) {
            // Implement flight selection logic
            alert('Vuelo seleccionado: ' + flightId);
        }
    </script>
</body>
</html> 