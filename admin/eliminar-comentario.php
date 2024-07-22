<?php
include 'includes/conn.php';

if(isset($_POST['comment_id'])) {
    $commentId = $_POST['comment_id'];

    $deleteQuery = "DELETE FROM coments WHERE id = '$commentId'";
    if ($conn->query($deleteQuery)) {
        echo "Comentario eliminado exitosamente";
    } else {
        echo "Error al eliminar el comentario: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se proporcionó el ID del comentario";
}
?>
