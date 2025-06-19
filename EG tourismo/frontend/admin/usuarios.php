        .user-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            transition: transform 0.3s, opacity 1s;
            opacity: 1;
        }
        .user-card:hover {
            transform: translateY(-5px);
        }
        .user-card.exit {
            opacity: 0;
            transform: translateX(-100%);
        }
        .visa-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            transition: transform 0.3s, opacity 1s;
            opacity: 1;
        }
        .visa-card:hover {
            transform: translateY(-5px);
        }
        .visa-card.exit {
            opacity: 0;
            transform: translateX(100%);
        }

    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('col-md-3');
            document.querySelector('.sidebar').classList.toggle('col-md-1');
            document.querySelector('.main-content').classList.toggle('col-md-9');
            document.querySelector('.main-content').classList.toggle('col-md-11');
        });

        // Función para animar la salida de las tarjetas
        function animateCardExit(card, isVisa = false) {
            const cardElement = card.closest(isVisa ? '.visa-card' : '.user-card');
            cardElement.classList.add('exit');
            setTimeout(() => {
                cardElement.remove();
            }, 1000);
        }

        // Agregar eventos a los botones de eliminar/desactivar
        document.querySelectorAll('.dropdown-item.text-danger').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.card');
                const isVisa = card.classList.contains('visa-card');
                animateCardExit(this, isVisa);
            });
        });
    </script> 