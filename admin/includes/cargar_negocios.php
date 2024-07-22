<?php
include 'conn.php';

$sql = "SELECT id, nombre_negocio FROM negocio";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $selectNegocios = '<option selected disabled value="">SELECCIONA UNA UNIDAD</option>';
    while ($row = $result->fetch_assoc()) {
        $selectNegocios .= '<option value="' . $row["id"] . '">' . $row["nombre_negocio"] . '</option>';
    }
    echo $selectNegocios;
} else {
    echo "No se encontraron negocios.";
}

$conn->close();
?>