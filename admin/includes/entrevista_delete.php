<?php
include 'session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM entrevistas WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Entrevista eliminada con éxito';
    } else {
        $_SESSION['error'] = $conn->error;
    }
}

header('location: ../entrevistas.php');
?>