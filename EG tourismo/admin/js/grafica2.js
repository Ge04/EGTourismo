window.addEventListener('load', function() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', './visitantesZonaTuris.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let datos = JSON.parse(xhr.responseText);
                console.log(datos);
                // Extraer los meses y totales de reservas
                let zonas = datos.map(elemento => elemento.zona);
                let totales = datos.map(elemento => elemento.total_visitantes);
    
                let ctx = document.getElementById('zonaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: zonas,
                        datasets: [{
                            label: 'Visitantes Zona Turística',
                            data: totales,
                            fill: false,
                            borderColor: ['#8e44ad', '#3498db', '#e74c3c', '#2ecc71'],
                            backgroundColor: ['#8e44ad', '#3498db', '#e74c3c', '#2ecc71'],
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            }
        };
        xhr.send();
    });