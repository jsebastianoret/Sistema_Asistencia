<?php
include 'conn.php';

$sql = "SELECT eventos2.*, negocio.nombre_negocio FROM eventos2
        LEFT JOIN negocio ON eventos2.id_negocio = negocio.id";

$result = $conn->query($sql);

$eventos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
}

$json_eventos = json_encode($eventos);

$conn->close();

header('Content-Type: application/json');
echo $json_eventos;
?>