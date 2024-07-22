<?php
include 'session.php';
date_default_timezone_set('America/Lima');

if (isset($_POST['add'])) {
    $title = $_POST["title"];
    $content = $_POST["contentHidden"];
    $publication_date = date("Y-m-d H:i:s");
    $type = $_POST["type"];
    $tipo_evento = $_POST["tipo_evento"];
    $privacy = '';
    $negocio_id = null;
    $employee_id = null;

    if ($tipo_evento === 'GENERAL') {
        $privacy = 'GENERAL';
    } elseif ($tipo_evento === 'UNIDAD') {
        $unidad_id = $_POST["unidad"];
        $negocio_id = $unidad_id;
        $privacy = 'UNIDAD';
    } elseif ($tipo_evento === 'PERSONA') {
        $unidad_id = $_POST["unidad"];
        $empleado_id = $_POST["persona"];
        $negocio_id = $unidad_id;
        $employee_id = $empleado_id;
        $privacy = 'PERSONA';
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
    } else {
        $image_count = 0;
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
    } else {
        $document_count = 0;
    }

    $images_json = json_encode($uploaded_images);
    $documents_json = json_encode($uploaded_documents);

    $sql = "INSERT INTO publications (title, content, publication_date, type, privacy, images, documents, negocio_id, employee_id)
                VALUES ('$title', '$content', '$publication_date', '$type', '$privacy', '$images_json', '$documents_json', '$negocio_id', '$employee_id')";

    if ($conn->query($sql)) {
        $_SESSION['alert_post'] = 'Publicación creada con éxito';
    } else {
        $_SESSION['alert_post'] = 'Error al crear la publicación';
    }
}

header('location: ../publicaciones.php');
?>