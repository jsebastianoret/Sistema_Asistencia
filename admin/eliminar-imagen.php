<?php
include 'includes/session.php';

if (isset($_GET['type']) && $_GET['type'] === 'image' && isset($_GET['filename']) && isset($_GET['id'])) {
    $image_filename = $_GET['filename'];
    $id_publicacion = $_GET['id'];

    $image_path = '../images/' . $image_filename;
    if (file_exists($image_path)) {

        if (unlink($image_path)) {

            $sql_select_images = "SELECT images FROM publications WHERE id = '$id_publicacion'";
            $result_images = $conn->query($sql_select_images);

            if ($result_images->num_rows > 0) {
                $row_images = $result_images->fetch_assoc();
                $images_json = $row_images['images'];
                $images_array = json_decode($images_json);

                $key = array_search($image_filename, $images_array);
                if ($key !== false) {
                    unset($images_array[$key]);

                    $updated_images_json = json_encode(array_values($images_array));
                    $sql_update_images = "UPDATE publications SET images = '$updated_images_json' WHERE id = '$id_publicacion'";
                    if ($conn->query($sql_update_images)) {
                        echo 'La imagen ha sido eliminada exitosamente.';
                    } else {
                        echo 'Error al actualizar la lista de imágenes en la base de datos: ' . $conn->error;
                    }
                } else {
                    echo 'El archivo de imagen no se encontró en la lista.';
                }
            } else {
                echo 'No se encontró la publicación en la base de datos.';
            }
        } else {
            echo 'Error al eliminar la imagen físicamente.';
        }
    } else {
        echo 'El archivo de imagen no existe.';
    }
} else {
    echo 'Solicitud incorrecta.';
}
?>
