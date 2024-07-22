<?php
include 'includes/conn.php';

$dias_semana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

$sql = "SELECT fecha, titulo FROM eventos2 WHERE tipo_publicacion = 'GENERAL' ORDER BY id DESC LIMIT 2";

$result = $conn->query($sql);
$conn->close();
?>