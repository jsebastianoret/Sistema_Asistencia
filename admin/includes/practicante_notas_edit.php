<?php
session_start();
include 'conn.php';

if (isset($_POST['edit_nota'])) {
    $id = $_POST["id"];
    $nota = $_POST["nota"];

    $sql = "UPDATE grades SET nota = $nota WHERE id = $id";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Notas actualizadas con éxito';
    } else {
        $_SESSION['error'] = 'Error al actualizar notas: ' . $conn->error;
    }

    $conn->close();
}
?>
<script>
    history.back();
</script>