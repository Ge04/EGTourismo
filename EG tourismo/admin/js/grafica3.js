 window.addEventListener('load', function() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', './tipotransporte.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let datos = JSON.parse(xhr.responseText);
                console.log(datos);
                // Extraer los meses y totales de reservas
                let transporte = datos.map(elemento => elemento.tipo_transporte);
                let totales = datos.map(elemento => elemento.cantidad);
    
                let ctx = document.getElementById('transporteChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: transporte,
                        datasets: [{
                            label:'Preferencias',
                            data: totales,
                            fill: false,
                            borderColor: ['#8e44ad', '#3498db', '#e74c3c', '#2ecc71'],
                            backgroundColor: ["#2980b9", "#f39c12", "#27ae60"],
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
