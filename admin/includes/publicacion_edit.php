<?php
include 'session.php';
date_default_timezone_set('America/Lima');

if (isset($_POST['edit'])) {
    $publication_id = $_POST["publication_id"];
    $title = $_POST["title"];
    $content = $_POST["contentHidden"];
    $publication_date = date("Y-m-d H:i:s");
    $type = $_POST["type"];
    $privacy = $_POST["tipo_evento"];

    $select_sql = "SELECT images, documents FROM publications WHERE id = $publication_id";
    $result = $conn->query($select_sql);
    $row = $result->fetch_assoc();
    $existing_images = json_decode($row["images"], true);
    $existing_documents = json_decode($row["documents"], true);

    if (empty($content)) {
        $select_sql_content = "SELECT content FROM publications WHERE id = $publication_id";
        $result_content = $conn->query($select_sql_content);
        $row_content = $result_content->fetch_assoc();
        $content = $row_content["content"];
    }

    $uploaded_images = array();
    if (!empty($_FILES['images']['name']) && is_array($_FILES['images']['name'])) {
        $image_count = count($_FILES['images']['name']);
        for ($i = 0; $i < $image_count; $i++) {
            $image_filename = $_FILES['images']['name'][$i];
            $image_tmp_name = $_FILES['images']['tmp_name'][$i];
            $image_target_path = '/home3/ghxumdmy/public_html/administracion-neonhouseled-com/asistencia/images/' . $image_filename;

            if (move_uploaded_file($image_tmp_name, $image_target_path)) {
                $uploaded_images[] = $image_filename;
            }
        }
        $all_images = array_merge($existing_images, $uploaded_images);
    } else {
        $all_images = $existing_images;
    }

    $uploaded_documents = array();
    if (!empty($_FILES['documents']['name']) && is_array($_FILES['documents']['name'])) {
        $document_count = count($_FILES['documents']['name']);
        for ($i = 0; $i < $document_count; $i++) {
            $document_filename = $_FILES['documents']['name'][$i];
            $document_tmp_name = $_FILES['documents']['tmp_name'][$i];
            $document_target_path = '/home3/ghxumdmy/public_html/administracion-neonhouseled-com/asistencia/documents/' . $document_filename;

            if (move_uploaded_file($document_tmp_name, $document_target_path)) {
                $uploaded_documents[] = $document_filename;
            }
        }
        $all_documents = array_merge($existing_documents, $uploaded_documents);
    } else {
        $all_documents = $existing_documents;
    }

    $negocio_id = null;
    $employee_id = null;

    if ($privacy === "UNIDAD") {
        $negocio_id = $_POST["unidad-unidad"];
    } elseif ($privacy === "PERSONA") {
        $negocio_id = $_POST["unidad"];
        $employee_id = $_POST["persona"];
    }

    $images_json = json_encode($all_images);
    $documents_json = json_encode($all_documents);
    $sql = "UPDATE publications SET title = '$title', content = '$content', type = '$type', privacy = '$privacy', images = '$images_json', documents = '$documents_json', negocio_id = '$negocio_id', employee_id = '$employee_id' WHERE id = $publication_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['alert_update'] = 'Publicación actualizada con éxito';
    } else {
        $_SESSION['alert_update'] = 'Error al actualizar la publicación';
    }
}

header('location: ../publicaciones.php');
?>