<?php
include 'session.php';

if (isset($_POST['add'])) {
    $subcriterio = $_POST['subcriterio'];
    $id_criterio = $_POST['id_criterio'];

    $sql = "INSERT INTO subcriterios (nombre_subcriterio, id_criterio) VALUES ('$subcriterio', '$id_criterio')";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Subcriterio añadido con éxito';
    } else {
        $_SESSION['error'] = $conn->error;
    }
}

header('location: ../subcriterios.php');
?>