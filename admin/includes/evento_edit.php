<?php
include 'session.php';

if (isset($_POST["edit"])) {
    $id_evento = $_POST["id_evento"];
    $tipo_publicacion = $_POST["tipo_publicacion"];
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $color = $_POST["color"];
    $id_empleado = $_POST["empleado"];
    $id_negocio = $_POST["negocio"];

    $carpeta_destino = '../../img-eventos/';

    $nombre_temporal = $_FILES['imagen']['tmp_name'];
    $nombre_archivo = $_FILES['imagen']['name'];

    if (!empty($nombre_archivo)) {
        $ruta_imagen = $carpeta_destino . $nombre_archivo;

        if (move_uploaded_file($nombre_temporal, $ruta_imagen)) {
            $sql_select = "SELECT imagen_url FROM eventos2 WHERE id = ?";
            $stmt_select = $conn->prepare($sql_select);
            $stmt_select->bind_param("i", $id_evento);
            $stmt_select->execute();
            $stmt_select->bind_result($imagen_antigua);
            $stmt_select->fetch();
            $stmt_select->close();

            if (!empty($imagen_antigua) && file_exists($imagen_antigua)) {
                unlink($imagen_antigua);
            }

            $sql_update = "UPDATE eventos2 SET tipo_publicacion=?, titulo=?, contenido=?, fecha=?, hora=?, color=?, id_empleado=?, id_negocio=?, imagen_url=? WHERE id=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssssssiisi", $tipo_publicacion, $titulo, $contenido, $fecha, $hora, $color, $id_empleado, $id_negocio, $nombre_archivo, $id_evento);

            if ($stmt_update->execute()) {
                $_SESSION['evento_actualizado'] = true;
            } else {
                $_SESSION['evento_no_actualizado'] = true;
            }
        } else {
            $_SESSION['evento_no_actualizado'] = true;
        }
    } else {
        $sql_update = "UPDATE eventos2 SET tipo_publicacion=?, titulo=?, contenido=?, fecha=?, hora=?, color=?, id_empleado=?, id_negocio=? WHERE id=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssiii", $tipo_publicacion, $titulo, $contenido, $fecha, $hora, $color, $id_empleado, $id_negocio, $id_evento);

        if ($stmt_update->execute()) {
            $_SESSION['evento_actualizado'] = true;
        } else {
            $_SESSION['evento_no_actualizado'] = true;
        }
    }

    $conn->close();
}

header('location: ../programacion-eventos.php');
?>