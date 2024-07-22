<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = $_POST['frase'];

    $imagen = $_FILES['imagen'];

    // Obtener información de la imagen
    $nombreImagen = $imagen['name'];
    $tipoImagen = $imagen['type'];
    $tamañoImagen = $imagen['size'];
    $rutaImagen = 'img/' . $nombreImagen;

    // Verificar si el archivo es una imagen válida
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = pathinfo($rutaImagen, PATHINFO_EXTENSION);

    if (!in_array(strtolower($extension), $extensionesPermitidas)) {
        $_SESSION['error'] = 'Solo se permiten archivos de imagen JPG, JPEG, PNG o GIF.';
    }

    // Mover la imagen a la carpeta destino
    if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        // Insertar la imagen en la base de datos
        $sql = "INSERT INTO imagen_frase (nombre, frase_motivacional) VALUES ('$nombreImagen', '$frase')";

        if ($conn->query($sql)) {
            $_SESSION['success'] = 'Imagen guardada con éxito.';
        } else {
            $_SESSION['error'] = 'Ocurrió un error al guardar la imagen.';
        }
    } else {
        $_SESSION['error'] = 'Ocurrió un error al guardar la imagen.';
    }
}

header("Location: vista-asistencia.php");
?>