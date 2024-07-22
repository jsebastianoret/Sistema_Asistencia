<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM fondo WHERE id = '$id'";
    $query = $conn->query($sql);
    $imagen = $query->fetch_assoc();

    if (!$imagen) {
        $_SESSION['error'] = 'Imagen no encontrada.';
    }

    $rutaImagen = 'fondo-admin/' . $imagen['nombre'];
    if (file_exists($rutaImagen)) {
        unlink($rutaImagen);
    }

    $sql = "DELETE FROM fondo WHERE id = '$id'";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Imagen eliminada con éxito.';
    } else {
        $_SESSION['error'] = 'Ocurrió un error al eliminar la imagen.';
    }
}

header("Location: vista-asistencia.php");
?>