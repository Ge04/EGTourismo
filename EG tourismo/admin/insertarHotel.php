<?php

include '../backend/conexion.php';

// Validar que todos los campos requeridos estén presentes
if (
    empty($_POST["nom"]) ||
    empty($_POST["correo"]) ||
    empty($_POST["telefono"]) ||
    empty($_POST["ubicacion"]) ||
    empty($_POST["servicios"]) ||
    empty($_POST["actividad"]) ||
    empty($_POST["estrellas"]) ||
    empty($_FILES['foto']['name'])
) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

$nombre_hotel = $_POST["nom"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$ubicacion = $_POST["ubicacion"];
$sevicio = $_POST["servicios"];
$actividad = $_POST["actividad"];
$estrellas = $_POST["estrellas"];

$nomfoto = $_FILES['foto']['name'];
$ruta = './img/';
$dirtemp = $_FILES['foto']['tmp_name'];

$arreglo = explode('.', $nomfoto);
$extension_img = strtolower(end($arreglo));
$extension_array_img = array('jpg', 'png', 'jpeg', 'gif');

if (in_array($extension_img, $extension_array_img)) {
    // Evitar sobrescribir archivos con el mismo nombre
    $nuevo_nombre = uniqid('correo', true) . '.' . $extension_img;
    if (move_uploaded_file($dirtemp, $ruta . $nuevo_nombre)) {
        $insert = "INSERT INTO hotel (nom_hotel, correo, telefono,imagen, ubicacion, servicios,actividad, estrellas)
                   VALUES ('$nombre_hotel', '$correo', '$telefono',$nomfoto, '$ubicacion', '$servicio', '$actividad', '$estrellas')";
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