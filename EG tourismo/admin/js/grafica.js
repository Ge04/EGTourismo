window.addEventListener('load', function() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', './cantReservas.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let datos = JSON.parse(xhr.responseText);
                // console.log(datos);
                // Extraer los meses y totales de reservas
                let meses = datos.map(elemento => elemento.mes);
                let totales = datos.map(elemento => elemento.total);
    
                let ctx = document.getElementById('hotelesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Reservas por mes',
                            data: totales,
                            fill: false,
                            borderColor: '#8e44ad',
                            backgroundColor: '#8e44ad',
                            borderWidth: 2,
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