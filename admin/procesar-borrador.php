<?php
$jsonFile = "usuarios.json";
$sugerencia_id = $_POST['sugerencia_id'];
$employee_id = $_POST['employee_id'];

$existingData = json_decode(file_get_contents($jsonFile), true);

if (!empty($existingData) && is_array($existingData)) {
    foreach ($existingData as $data) {
        if ($data['id'] == $sugerencia_id) {
            $sugerencia_nombre = urlencode($data['nombre']);
            $sugerencia_asunto = urlencode($data['asunto']);
            $sugerencia_fecha = urlencode($data['fecha']);
            $sugerencia_tipo = urlencode($data['tipo']);
            $sugerencia_unidad = urlencode($data['unidad']);
            $sugerencia_contenido = urlencode($data['sugerencia']);

            $redirectUrl = "enviar-borrador.php?sugerencia_id=$sugerencia_id&employee_id=$employee_id&nombre=$sugerencia_nombre&asunto=$sugerencia_asunto&fecha=$sugerencia_fecha&tipo=$sugerencia_tipo&unidad=$sugerencia_unidad&sugerencia=$sugerencia_contenido";

            header("Location: $redirectUrl");
            exit;
        }
    }
}
?>