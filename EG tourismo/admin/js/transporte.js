let formularioTransporte = document.querySelector("#transportForm");

formularioTransporte.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission
    let xhr = new XMLHttpRequest();
    let formData = new FormData(formularioTransporte);
    xhr.open("POST", "insertarTransporte.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
             CargarDatos(); // Refresh the data after submission
            console.log(xhr.responseText);
     
            // try {
            //     response = JSON.parse(xhr.responseText);
            // } catch (e) {
            //     Swal.fire({
            //         title: 'Error',
            //         text: 'Respuesta inesperada del servidor.',
            //         icon: 'error',
            //         confirmButtonText: 'Aceptar'
            //     });
            //     return;
            // }
            // if (response && response.success) {
            //     Swal.fire({
            //         title: 'Éxito',
            //         text: 'Transporte añadido correctamente',
            //         icon: 'success',
            //         confirmButtonText: 'Aceptar'
            //     });
            //     formularioTransporte.reset(); // Reset the form after successful submission
            // } else {
            //     Swal.fire({
            //         title: 'Error',
            //         text: response && response.message ? response.message : 'No se pudo añadir el transporte',
            //         icon: 'error',
            //         confirmButtonText: 'Aceptar'
            //     });
            // }
        }
    };
    xhr.send(formData);
});


function CargarDatos() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../mostrarTransporte.php', true);
    xhr.onload = function () {
        let datos = JSON.parse(xhr.response);
        let tabla = document.getElementById('transportTableBody');
        tabla.innerHTML = ''; // Clear the table body before adding new rows

        for (let data of datos) {
            tabla.innerHTML += `
            <tr>
            <td>${data.id}</td>
            <td>${data.telefono}</td>   
            <td>${data.correo}</td>
            <td>${data.tipo_transporte}</td>
            <td>${data.precio}</td>
            <td>${data.ruta}</td>
            <td><img src="../img/${data.imag}" alt="Imagen de transporte" style="width: 100px; height: auto;"></td>
            <td>
                <button class="btn btn-danger" onclick="EliminarTransporte(${data.id})">Eliminar</button>
                <button class="btn btn-primary" onclick="EditarTransporte(${data.id})">Editar</button>
                </td>
            </tr>`
        }
    };
    xhr.send();
}
CargarDatos();