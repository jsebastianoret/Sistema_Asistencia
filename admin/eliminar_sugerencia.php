<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $jsonFile = "usuarios.json";

    $existingData = file_get_contents($jsonFile);
    $existingData = json_decode($existingData, true);

    $lastId = end($existingData)["id"];
    $newId = $lastId + 1;

    $newData = array(
        "id" => $newId,
        "employee_id" => $_POST["employee_id"],
        "nombre" => $_POST["nombre"],
        "fecha" => $_POST["fecha"],
        "asunto" => $_POST["asunto"],
        "tipo" => $_POST["tipo"],
        "unidad" => $_POST["unidad"],
        "sugerencia" => $_POST["sugerencia"]
    );

    $existingData[] = $newData;

    $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);

    file_put_contents($jsonFile, $jsonData);
}
?>
