<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM imagen_frase WHERE id = '$id'";
    $query = $conn->query($sql);
    $imagen = $query->fetch_assoc();

    if (!$imagen) {
        $_SESSION['error'] = 'Imagen no encontrada.';
    }

    $sql = "DELETE FROM imagen_frase WHERE id = '$id'";
    if ($conn->query($sql)) {
        unlink('img/' . $imagen['nombre']);
        $_SESSION['success'] = 'Imagen eliminada correctamente';
    } else {
        $_SESSION['error'] = 'Error al eliminar la imagen';
    }
}

header("Location: vista-asistencia.php");