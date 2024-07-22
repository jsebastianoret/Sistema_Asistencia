<?php
session_start();
include 'conn.php';

if (isset($_POST['delete_nota'])) {
    $id = $_POST['id'];
    $fecha_fin_semana = $_POST['fecha_fin_semana'];

    $sql = "DELETE FROM grades WHERE fecha_fin_semana = '$fecha_fin_semana' AND employee_id = '$id'";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Notas eliminadas con éxito';
    } else {
        $_SESSION['error'] = 'Error al eliminar notas: ' . $conn->error;
    }
}
?>
<script>
    history.back();
</script>