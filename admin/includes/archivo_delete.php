<?php
include 'session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Obtener la lista de nombres de imágenes asociadas a la publicación
    $sql_select_images = "SELECT images FROM archivos WHERE id = '$id'";
    $result_images = $conn->query($sql_select_images);

    if ($result_images->num_rows > 0) {
        $row_images = $result_images->fetch_assoc();
        $images_json = $row_images['images'];
        $images_array = json_decode($images_json);

        // Eliminar físicamente las imágenes de la carpeta
        foreach ($images_array as $image_filename) {
            $image_path = '../../images/' . $image_filename;
            if (file_exists($image_path)) {
                unlink($image_path); // Eliminar el archivo
            }
        }
    }

    // Obtener la lista de nombres de documentos asociados a la publicación
    $sql_select_documents = "SELECT archivos FROM archivos WHERE id = '$id'";
    $result_documents = $conn->query($sql_select_documents);

    if ($result_documents->num_rows > 0) {
        $row_documents = $result_documents->fetch_assoc();
        $documents_json = $row_documents['archivos']; // Cambio aquí, usar 'archivos' en lugar de 'documents'
        $documents_array = json_decode($documents_json);

        // Eliminar físicamente los documentos de la carpeta
        foreach ($documents_array as $document_filename) {
            $document_path = '../../documents/' . $document_filename;
            if (file_exists($document_path)) {
                unlink($document_path); // Eliminar el archivo
            }
        }
    }

    // Eliminar la publicación de la base de datos
    $sql = "DELETE FROM archivos WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Archivo eliminado con éxito';
    } else {
        $_SESSION['error'] = 'Error al eliminar el archivo';
    }
}

header('location: ../archivos.php');
