<?php
include 'session.php';

if (isset($_POST['edit'])) {
    $archivo_id = $_POST["archivo_id"];
    $conn->begin_transaction();

    try {
        $uploaded_documents = array();
        if (!empty($_FILES['documents']['name']) && is_array($_FILES['documents']['name'])) {
            $document_count = count($_FILES['documents']['name']);
            for ($i = 0; $i < $document_count; $i++) {
                $document_filename = $_FILES['documents']['name'][$i];
                $document_tmp_name = $_FILES['documents']['tmp_name'][$i];
                $document_target_path = '../../documents/' . $document_filename;

                if (move_uploaded_file($document_tmp_name, $document_target_path)) {
                    $uploaded_documents[] = $document_filename;
                }
            }
        }

        $select_sql = "SELECT images, archivos FROM archivos WHERE id = $archivo_id";
        $result = $conn->query($select_sql);
        $row = $result->fetch_assoc();
        $existing_images = json_decode($row["images"], true);
        $existing_documents = json_decode($row["archivos"], true);

        if (!empty($existing_images)) {
            $imageReference = $_POST['imageReference'];

            // Filtra los valores en blanco antes de agregarlos
            $filtered_images = array_filter($imageReference, function ($value) {
                return trim($value) !== '';
            });

            $existing_images = array_merge($existing_images, $filtered_images);
        } else {
            // Filtra los valores en blanco antes de agregarlos
            $filtered_images = array_filter($_POST['imageReference'], function ($value) {
                return trim($value) !== '';
            });

            $existing_images = $filtered_images;
        }

        $all_documents = array_merge($existing_documents, $uploaded_documents);

        $images_json = json_encode($existing_images);
        $documents_json = json_encode($all_documents);

        $sql_update_archivos = "UPDATE archivos SET images = '$images_json', archivos = '$documents_json' WHERE id = $archivo_id";
        if ($conn->query($sql_update_archivos)) {
            $_SESSION['success'] = 'Archivo(s) actualizado(s) con éxito';
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = 'Error al actualizar archivo(s)';
    }
}

header('location: ../archivos.php');
?>