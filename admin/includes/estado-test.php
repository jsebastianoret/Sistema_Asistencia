<?php 
include '../../conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$estado = $data['estado'];

$sql = 'UPDATE preguntas_test SET estado = ?';

$stm = $conn->prepare($sql);
$stm->bind_param('i', $estado);

if ($stm->execute()) {
    echo json_encode("ok");
} else{
    echo json_encode("error");
}
$conn->close();
?>