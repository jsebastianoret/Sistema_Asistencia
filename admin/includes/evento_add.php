<?php
include 'session.php';

if (isset($_POST["add"])) {
    $tipoPublicacion = $_POST["tipo_publicacion"];
    $idEmpleado = $_POST["empleado"] ?? null;
    $idNegocio = $_POST["negocio"] ?? null;
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $color = $_POST["color"];

    $carpeta_destino = '../../img-eventos/';

    $nombre_archivo = '';

    if (!empty($_FILES['imagen']['name'])) {
        $nombre_temporal = $_FILES['imagen']['tmp_name'];
        $nombre_archivo = $_FILES['imagen']['name'];

        if (move_uploaded_file($nombre_temporal, $carpeta_destino . $nombre_archivo)) {
        } else {
            echo "Error al subir la imagen.";
        }
    }

    $imagen_json = $nombre_archivo;

    $sql = "INSERT INTO eventos2 (tipo_publicacion, id_empleado, id_negocio, titulo, contenido, fecha, hora, color, imagen_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siissssss", $tipoPublicacion, $idEmpleado, $idNegocio, $titulo, $contenido, $fecha, $hora, $color, $imagen_json);
        session_start();
        if ($stmt->execute()) {
            $_SESSION['evento_guardado'] = true;
        } else {
            $_SESSION['evento_no_guardado'] = true;
        }
    } else {
        $_SESSION['evento_no_guardado'] = true;
    }

    $conn->close();
}

header('location: ../programacion-eventos.php');
?>