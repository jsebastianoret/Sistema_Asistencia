<?php
include 'includes/conn.php';
if(isset($_POST['comment_id']) && isset($_POST['new_content'])) {
    $commentId = $_POST['comment_id'];
    $newContent = $_POST['new_content'];

    $updateQuery = "UPDATE coments SET comentario = '$newContent' WHERE id = '$commentId'";
    if ($conn->query($updateQuery)) {
        echo "Comentario editado exitosamente";
    } else {
        echo "Error al editar el comentario: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se proporcionó el ID del comentario o el nuevo contenido";
}
?>
