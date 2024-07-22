<?php
$jsonFile = "usuarios.json";
$sugerenciaId = $_POST['sugerencia_id'];

$existingData = json_decode(file_get_contents($jsonFile), true);

if (!empty($existingData) && is_array($existingData)) {
    foreach ($existingData as $key => $data) {
        if ($data['id'] == $sugerenciaId) {
            unset($existingData[$key]);

            if (file_put_contents($jsonFile, json_encode($existingData))) {
                echo "success";
                exit;
            } else {
                echo "error";
                exit;
            }
        }
    }
}
echo "error";
?>