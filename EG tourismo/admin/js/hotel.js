const formularioRestaurante = document.querySelector("#hotelForm");
formularioRestaurante.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(formularioRestaurante);
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./insertarHotel.php", true);

    xhr.onload = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            formularioRestaurante.reset(); // Usar === para comparación
            const response = JSON.parse(xhr.responseText);
            // console.log(xhr.response);
            if (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Hotel registrado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                formularioRestaurante.reset(); // Reset the form
                CargarDatos(); // Reload the data
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar el Hotel',
                    text: 'Por favor, inténtelo de nuevo.'
                });
            }
        } else if (xhr.readyState === 4) {
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar al servidor.'
            });
        }
    };

    xhr.send(formData);
});
function CargarDatos() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', './mostrarHotel.php', true);
    xhr.onload = function () {
        let datos = JSON.parse(xhr.response);
        let tabla = document.getElementById('hotelTableBody');
        tabla.innerHTML = '';   // Clear the table body before adding new rows

        for (let data of datos) {
            tabla.innerHTML += `
             <tr>
             <td><img src="../img/${data.imagen}" alt="Restaurante" style="width: 50px; height: 60px; border-radius:50%;background:black;"></td>
             <td>${data.nom_hotel.substring(0,10)}</td>
             <td>${data.ubicacion.substring(0,10)}</td> 
             <td>${data.estrellas.substring(0,10)}</td> 
             <td>
                <button class="btn btn-danger" onclick="EliminarTransporte(${data.id})"><i class="fas fa-trash"></i></button>
             </td>
             <td>
                 <button class="btn btn-primary" onclick="EditarTransporte(${data.id})"><i class="fas fa-pen"></i></button>
            </td>
             </tr>`
        }
    };
    xhr.send();
}
// setInterval(CargarDatos,6000); // Refresh data every 3 seconds
CargarDatos();

// function EliminarTransporte(id) {
//     Swal.fire({
//         title: '¿Estás seguro?',
//         text: "¡No podrás revertir esto!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Sí, eliminar'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             let xhr = new XMLHttpRequest();
//             xhr.open('POST', './eliminarTransporte.php', true);
//             xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//             xhr.onload = function () {
//                 if (xhr.status == 200) {
//                     Swal.fire('Eliminado', 'El transporte ha sido eliminado.', 'success');
//                     CargarDatos();
//                 } else {
//                     Swal.fire('Error', 'No se pudo eliminar.', 'error');
//                 }
//             };
//             xhr.send('id=' + id);
//         }
//     });
// }

// function EditarRestaurante(id) {
//     // Buscar los datos actuales del transporte
//     let xhr = new XMLHttpRequest();
//     xhr.open('GET', './obtenerTransporte.php?id=' + id, true);
//     xhr.onload = function () {
//         if (xhr.status == 200) {
//             let data = JSON.parse(xhr.responseText);
//             Swal.fire({
//                 title: 'Editar Transporte',
//                 html:
//                     `<input id="swal-correo" class="swal2-input" placeholder="Correo" value="${data.correo}">
//                      <input id="swal-precio" class="swal2-input" placeholder="Precio" value="${data.precio}">
//                      <input id="swal-telefono" class="swal2-input" placeholder="Teléfono" value="${data.telefono}">
//                      <input id="swal-ruta" class="swal2-input" placeholder="Ruta" value="${data.ruta}">
//                      <input id="swal-tipo" class="swal2-input" placeholder="Tipo" value="${data.tipo_transporte}">`,
//                 focusConfirm: false,
//                 preConfirm: () => {
//                     return {
//                         correo: document.getElementById('swal-correo').value,
//                         precio: document.getElementById('swal-precio').value,
//                         telefono: document.getElementById('swal-telefono').value,
//                         ruta: document.getElementById('swal-ruta').value,
//                         tipo_transporte: document.getElementById('swal-tipo').value
//                     }
//                 }
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     let datos = result.value;
//                     let xhr2 = new XMLHttpRequest();
//                     xhr2.open('POST', './actualizarTransporte.php', true);
//                     xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//                     xhr2.onload = function () {
//                         if (xhr2.status == 200) {
//                             Swal.fire('Actualizado', 'El transporte ha sido actualizado.', 'success');
//                             CargarDatos();
//                         } else {
//                             Swal.fire('Error', 'No se pudo actualizar.', 'error');
//                         }
//                     };
//                     xhr2.send(`id=${id}&correo=${encodeURIComponent(datos.correo)}&precio=${encodeURIComponent(datos.precio)}&telefono=${encodeURIComponent(datos.telefono)}&ruta=${encodeURIComponent(datos.ruta)}&tipo_transporte=${encodeURIComponent(datos.tipo_transporte)}`);
//                 }
//             });
//         }
//     };
//     xhr.send();
// }