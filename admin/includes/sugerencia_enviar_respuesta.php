<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sugerencia_id = $_POST['sugerencia_id'];
    $respuesta = $_POST['mensaje'];

    $consulta_insertar = "INSERT INTO respuesta_sugerencias (sugerencia_id, respuesta) VALUES ('$sugerencia_id', '$respuesta')";

    if ($conn->query($consulta_insertar) === TRUE) {
        header("Location: ../sugerencia-respondida.php");
    } else {
        header("Location: ../buzon-sugerencias.php");
    }
} else {
    header("Location: ../buzon-sugerencias.php");
}
?>