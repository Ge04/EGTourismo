<?php

include '../backend/conexion.php';

// Validar que todos los campos requeridos estén presentes
if (
    empty($_POST["correo"]) ||
    empty($_POST["precio"]) ||
    empty($_POST["telefono"]) ||
    empty($_POST["ruta"]) ||
    empty($_POST["tipo_transporte"]) ||
    empty($_FILES['foto']['name'])
) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

$correo = $_POST["correo"];
$precio = $_POST["precio"];
$telefono = $_POST["telefono"];
$rutas = $_POST["ruta"];
$tipo_transporte = $_POST["tipo_transporte"];

$nomfoto = $_FILES['foto']['name'];
$ruta = './img/';
$dirtemp = $_FILES['foto']['tmp_name'];

$arreglo = explode('.', $nomfoto);
$extension_img = strtolower(end($arreglo));
$extension_array_img = array('jpg', 'png', 'jpeg', 'gif');

if (in_array($extension_img, $extension_array_img)) {
    // Evitar sobrescribir archivos con el mismo nombre
    $nuevo_nombre = uniqid('transporte_', true) . '.' . $extension_img;
    if (move_uploaded_file($dirtemp, $ruta . $nuevo_nombre)) {
        $insert = "INSERT INTO transporte (telefono, correo, tipo_transporte, precio, ruta, imag)
                   VALUES ('$telefono', '$correo', '$tipo_transporte', '$precio', '$rutas', '$nuevo_nombre')";
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