<?php
// require '../backend/conexion.php';


// Escapar datos y preparar la consulta
$tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$precio = mysqli_real_escape_string($conexion, $_POST['precio']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$ruta = mysqli_real_escape_string($conexion, $_POST['ruta']);


// Manejo de la imagen
$nomfoto = $_FILES['foto']['name'];
$dirtemp = $_FILES['foto']['tmp_name'];
$ruta = './img/';

 $arreglo = explode('.', $nomfoto);
$extension_img = strtolower(end($arreglo));
$extension_array_img = array('jpg', 'png', 'jpeg', 'gif');

if (in_array($extension_img, $extension_array_img)) {
    if (move_uploaded_file($dirtemp, $ruta . $nomfoto)) {
        if (
            empty($nom) && empty($ape)
            && empty($edad) && empty($tutor) && empty($telf_tutor)
            && empty($ubicacion) && empty($email)
        ) {
            // header('Location:../otros/centros.php');
            // echo 'error';
        } else {
            $insert = "INSERT INTO transporte (telefono,correo,tipo_transporte,precio,ruta,
            imag)
            VALUES ('$telefono','$correo','$tipo','$precio','$ruta','$nomfoto')";
            $resultado = $conexion->query($insert);
            echo json_encode($resultado);
        }
    }
};

?>