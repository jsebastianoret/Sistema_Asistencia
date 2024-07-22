<?php
include 'includes/session.php';

if (isset($_GET['type']) && $_GET['type'] === 'document' && isset($_GET['filename']) && isset($_GET['id'])) {
    $document_filename = $_GET['filename'];
    $id_archivo = $_GET['id'];

    $document_path = '../documents/' . $document_filename;
    if (file_exists($document_path)) {

        if (unlink($document_path)) {

            $sql_select_documents = "SELECT archivos, images FROM archivos WHERE id = '$id_archivo'";
            $result_documents = $conn->query($sql_select_documents);

            if ($result_documents->num_rows > 0) {
                $row_documents = $result_documents->fetch_assoc();
                $documents_json = $row_documents['archivos'];
                $documents_array = json_decode($documents_json);

                $images_json = $row_documents['images'];
                $images_array = json_decode($images_json);

                $key = array_search($document_filename, $documents_array);
                if ($key !== false) {
                    unset($documents_array[$key]);
                    unset($images_array[$key]);

                    $updated_documents_json = json_encode(array_values($documents_array));
                    $updated_images_json = json_encode(array_values($images_array));

                    $sql_update_documents = "UPDATE archivos SET archivos = '$updated_documents_json', images = '$updated_images_json' WHERE id = '$id_archivo'";
                    if ($conn->query($sql_update_documents)) {
                        echo 'El documento ha sido eliminado exitosamente.';
                    } else {
                        echo 'Error al actualizar la lista de documentos en la base de datos: ' . $conn->error;
                    }
                } else {
                    echo 'El archivo de documento no se encontró en la lista.';
                }
            } else {
                echo 'No se encontró la publicación en la base de datos.';
            }
        } else {
            echo 'Error al eliminar el documento físicamente.';
        }
    } else {
        echo 'El archivo de documento no existe.';
    }
} else {
    echo 'Solicitud incorrecta.';
}
?>
