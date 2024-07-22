<?php
include '../../conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$preguntaId = $data['preguntaId'];
$empleadoId = $data['empleadoId'];
$admId = $data['admId'];
$negocioId = $data['negocioId'];
$valor = $data['valor'];
$fechaRespuesta = date('Y-m-d H:i:s');

if (count($preguntaId) == count($valor)) {
    $sql = "INSERT INTO respuestas_test (pregunta_id, employee_id, adm_id, negocio_id, valor, fecha_respuesta) VALUES (?, ?, ?, ?, ?, ?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param("iiiiis", $pregunta_id, $empleadoId, $admId, $negocioId, $valor_respuesta, $fechaRespuesta);

    foreach ($preguntaId as $indice => $pregunta_id) {

        $pregunta_id = $preguntaId[$indice];
        $valor_respuesta = $valor[$indice];

        $stm->execute();
    }

    $stm->close();

    echo json_encode("ok");
} else {
    echo json_encode("error");
}
$conn->close();
?>