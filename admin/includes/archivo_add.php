<?php
include 'session.php';

if (isset($_POST['add'])) {
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

        $imageReference = $_POST['imageReference'];
        $documents_json = json_encode($uploaded_documents);

        $sql_insert_archivos = "INSERT INTO archivos (images, archivos) VALUES ('$imageReference', '$documents_json')";
        if ($conn->query($sql_insert_archivos)) {
            $_SESSION['success'] = 'Archivo(s) subido(s) con éxito';
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = 'Error al subir archivo(s)';
    }
}

header('location: ../archivos.php');
?>