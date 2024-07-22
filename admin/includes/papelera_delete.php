<?php
include 'session.php';

if (isset($_POST['delete'])) {
    $idEmpleado = $_POST['paid'];

    $sql = "DELETE FROM papelera WHERE id = $idEmpleado";
    $conn->query($sql)
        ? $_SESSION['success'] = "Practicante eliminado definitivamente"
        : $_SESSION['error'] = "Error al eliminar practicante";

    $conn->close();
}

header("Location: ../papelera.php");
?>