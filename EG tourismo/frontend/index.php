<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo en Guinea Ecuatorial - Descubre el paraíso tropical</title>
    
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
  
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .chat-header {
            background: #219150;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-header h5 {
            margin: 0;
            font-size: 1.1rem;
        }
        .chat-toggle {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .message {
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 15px;
            margin-bottom: 5px;
        }
        .message.user {
            background: #e9ecef;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }
        .message.bot {
            background: #219150;
            color: white;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
        }
        .chat-input {
            padding: 15px;
            border-top: 1px solid #dee2e6;
            display: flex;
            gap: 10px;
        }
        .chat-input input {
            flex-grow: 1;
            padding: 8px 15px;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            outline: none;
        }
        .chat-input button {
            background: #219150;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .chat-input button:hover {
            background: #1a7340;
        }
        .chat-container.minimized {
            height: 60px;
        }
        .chat-container.minimized .chat-messages,
        .chat-container.minimized .chat-input {
            display: none;
        }
        .typing-indicator {
            display: none;
            align-self: flex-start;
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 15px;
            margin-bottom: 5px;
        }
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #219150;
            border-radius: 50%;
            margin-right: 3px;
            animation: typing 1s infinite;
        }
        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typing {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1504214208698-ea1916a2195a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1>Descubre Guinea Ecuatorial</h1>
            <p>Un paraíso tropical en el corazón de África, donde la naturaleza exuberante se encuentra con una rica cultura y playas vírgenes</p>
            <a href="#descubrir" class="btn btn-primary btn-lg">Explorar</a>
        </div>
    </section>
    <section id="descubrir" class="section">
        <div class="container">
            <h2 class="section-title">¿Qué es Guinea Ecuatorial?</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>Guinea Ecuatorial, situada en el Golfo de Guinea en la costa oeste de África Central, es un país de extraordinaria belleza natural y rica diversidad cultural. Con una historia fascinante y un patrimonio único, este pequeño país ofrece una experiencia turística incomparable.</p>
                    <p>Compuesto por una región continental (Río Muni) y cinco islas, incluyendo Bioko (donde se encuentra la capital, Malabo) y Annobón, Guinea Ecuatorial es el único país de habla hispana en África, lo que le da un carácter distintivo y multicultural.</p>
                    <p>Desde sus playas de arena blanca hasta sus densas selvas tropicales, Guinea Ecuatorial invita a los viajeros a descubrir sus tesoros naturales y culturales.</p>
                    <div class="mt-4">
                        <a href="pages/zonas.php" class="btn btn-primary me-2">Explorar Regiones</a>
                        <a href="pages/actividades.php" class="btn btn-outline-secondary">Ver Actividades</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow">
                        <iframe src="https://www.youtube.com/embed/example" title="Guinea Ecuatorial Video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-light">
        <div class="container">
            <h2 class="section-title">Destacados de Guinea Ecuatorial</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1505881502353-a1986add3762?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Playas">
                        <div class="card-body">
                            <h5 class="card-title">Playas Paradisíacas</h5>
                            <p class="card-text">Disfruta de las playas vírgenes de arena blanca y negra en la isla de Bioko, perfectas para relajarse y observar tortugas marinas.</p>
                            <a href="pages/zonas.php" class="btn btn-sm btn-outline-primary">Explorar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Selva Tropical">
                        <div class="card-body">
                            <h5 class="card-title">Biodiversidad Única</h5>
                            <p class="card-text">Explora los parques nacionales con una increíble variedad de especies endémicas, incluyendo primates, aves exóticas y flora tropical.</p>
                            <a href="pages/actividades.php" class="btn btn-sm btn-outline-primary">Descubrir</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Cultura local">
                        <div class="card-body">
                            <h5 class="card-title">Cultura Vibrante</h5>
                            <p class="card-text">Sumérgete en la rica mezcla cultural de influencias españolas y africanas a través de su música, danza, gastronomía y festivales tradicionales.</p>
                            <a href="pages/actividades.php" class="btn btn-sm btn-outline-primary">Conocer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h2 class="section-title">Zonas de Turismo</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-5">
                                <img src="https://images.unsplash.com/photo-1580060839134-75a5edca2e99?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-fluid h-100" style="object-fit: cover;" alt="Isla de Bioko">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title">Isla de Bioko</h5>
                                    <p class="card-text">Hogar de la capital Malabo, con impresionantes playas, volcanes y reservas naturales. Disfruta de su ambiente urbano y natural.</p>
                                    <a href="pages/zonas.php#bioko" class="btn btn-primary mt-auto align-self-start">Descubrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-5">
                                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="img-fluid h-100" style="object-fit: cover;" alt="Río Muni">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title">Río Muni</h5>
                                    <p class="card-text">La región continental ofrece selvas tropicales, ríos caudalosos y la ciudad de Bata. Ideal para ecoturismo y aventuras.</p>
                                    <a href="pages/zonas.php#riomuni" class="btn btn-primary mt-auto align-self-start">Explorar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="pages/zonas.php" class="btn btn-primary">Ver Todas las Zonas</a>
            </div>
        </div>
    </section>
    <section class="section bg-light">
        <div class="container">
            <h2 class="section-title">Actividades Populares</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-hiking"></i>
                        </div>
                        <h5>Senderismo</h5>
                        <p>Explora rutas a través de selvas tropicales y montañas volcánicas.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <h5>Playas</h5>
                        <p>Relaja en playas vírgenes y disfruta de deportes acuáticos.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h5>Gastronomía</h5>
                        <p>Prueba platos tradicionales con influencias africanas y españolas.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-drum"></i>
                        </div>
                        <h5>Cultura</h5>
                        <p>Conoce las tradiciones, música y danzas de las diferentes etnias.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="pages/actividades.php" class="btn btn-primary">Descubrir Más Actividades</a>
            </div>
        </div>
    </section>
    <section class="cta-section">
        <div class="container">
            <h2>¿Listo para visitar Guinea Ecuatorial?</h2>
            <p class="mb-4">Planifica tu viaje ahora y descubre uno de los destinos más fascinantes de África</p>
            <a href="pages/visa.php" class="btn btn-light btn-lg me-3">Información de Visa</a>
            <a href="pages/hoteles.php" class="btn btn-outline-light btn-lg">Reservar Alojamiento</a>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <!-- AI Chat Widget -->
    <div class="chat-container">
        <div class="chat-header">
            <h5><i class="fas fa-robot me-2"></i>Asistente Virtual</h5>
            <button class="chat-toggle" onclick="toggleChat()">
                <i class="fas fa-minus"></i>
            </button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                ¡Hola! Soy tu asistente virtual para Guinea Ecuatorial. ¿En qué puedo ayudarte hoy?
            </div>
        </div>
        <div class="typing-indicator" id="typingIndicator">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Escribe tu pregunta..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <script src="assets/js/main.js"></script>
    <script>
        let isMinimized = false;

        function toggleChat() {
            const container = document.querySelector('.chat-container');
            const toggleBtn = document.querySelector('.chat-toggle i');
            isMinimized = !isMinimized;
            
            container.classList.toggle('minimized');
            toggleBtn.classList.toggle('fa-minus');
            toggleBtn.classList.toggle('fa-plus');
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function showTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            indicator.style.display = 'block';
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            indicator.style.display = 'none';
        }

        async function sendMessage() {
            const input = document.getElementById('userInput');
            const message = input.value.trim();
            
            if (!message) return;
            
            // Add user message to chat
            addMessage(message, 'user');
            input.value = '';
            
            // Show typing indicator
            showTypingIndicator();
            
            try {
                const response = await fetch('../../backend/api/chat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Hide typing indicator and add bot response
                hideTypingIndicator();
                addMessage(data.response, 'bot');
                
            } catch (error) {
                console.error('Error:', error);
                hideTypingIndicator();
                addMessage('Lo siento, ha ocurrido un error. Por favor, intenta de nuevo más tarde.', 'bot');
            }
        }

        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            messageDiv.textContent = text;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    </script>
</body>
</html>