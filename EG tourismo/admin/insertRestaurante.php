<?php

include '../backend/conexion.php';

// Validar que todos los campos requeridos estén presentes
if (
    empty($_POST["nombre"]) ||
    empty($_POST["descripcion"]) ||
    empty($_POST["ubicacion"]) ||
    empty($_POST["telefono"]) ||
    empty($_POST["correo"]) ||
    empty($_FILES['foto']['name'])
) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

$nom = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$ubicacion = $_POST["ubicacion"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];

$nomfoto = $_FILES['foto']['name'];
$ruta = './img/';
$dirtemp = $_FILES['foto']['tmp_name'];

$arreglo = explode('.', $nomfoto);
$extension_img = strtolower(end($arreglo));
$extension_array_img = array('jpg', 'png', 'jpeg', 'gif');

if (in_array($extension_img, $extension_array_img)) {
    // Evitar sobrescribir archivos con el mismo nombre
    $nuevo_nombre = uniqid('restaurantes_', true) . '.' . $extension_img;
    if (move_uploaded_file($dirtemp, $ruta . $nuevo_nombre)) {
        $insert = "INSERT INTO restaurantes (nombre, descripcion, direccion, telefono, correo)
                   VALUES ('$nom', '$descripcion', '$ubicacion', '$telefono', '$correo')";
        $resultado = $conexion->query($insert);
        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Transporte registrado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar en la base de datos.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Formato de imagen no permitido.']);
}
?>