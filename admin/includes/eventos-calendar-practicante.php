<?php
include 'conn.php';

$sql = "SELECT * FROM eventos";
$result = $conn->query($sql);

$eventos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
}

// Convertir los datos en formato JSON
$json_eventos = json_encode($eventos);

// Cierra la conexión
$conn->close();

// Imprime los datos JSON
header('Content-Type: application/json');
echo $json_eventos;
?>