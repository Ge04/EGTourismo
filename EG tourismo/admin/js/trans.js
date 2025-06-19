document.getElementById('transportForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const type = document.getElementById('tipo').value;
    const provider = document.getElementById('correo').value;
    const route = document.getElementById('ruta').value;
    const imageInput = document.getElementById('image');

    const tableBody = document.querySelector('#transportTable tbody');
    const newRow = document.createElement('tr');

    const imageCell = document.createElement('td');
    const image = document.createElement('img');
    image.className = 'transport-thumbnail';
    image.src = URL.createObjectURL(imageInput.files[0]);
    image.onload = () => URL.revokeObjectURL(image.src);
    imageCell.appendChild(image);

    const typeCell = document.createElement('td');
    typeCell.textContent = type;

    const providerCell = document.createElement('td');
    providerCell.textContent = provider;

    const routeCell = document.createElement('td');
    routeCell.textContent = route;

    const actionCell = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-sm btn-outline-danger';
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    deleteButton.onclick = () => newRow.remove();
    actionCell.appendChild(deleteButton);

    newRow.appendChild(imageCell);
    newRow.appendChild(typeCell);
    newRow.appendChild(providerCell);
    newRow.appendChild(routeCell);
    newRow.appendChild(actionCell);

    tableBody.appendChild(newRow);

    document.getElementById('transportForm').reset();
});