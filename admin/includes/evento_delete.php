<?php
include 'session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['evento_id'];

    $sql_select = "SELECT imagen_url FROM eventos2 WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $stmt_select->bind_result($imagen_url);
    $stmt_select->fetch();
    $stmt_select->close();

    $ruta_imagen = '../../img-eventos/' . $imagen_url;

    $sql_delete = "DELETE FROM eventos2 WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);

    session_start();
    if ($stmt_delete->execute()) {
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }
        $_SESSION['evento_eliminado'] = true;
    } else {
        $_SESSION['evento_no_eliminado'] = true;
    }
}

header("Location: ../programacion-eventos.php");
?>