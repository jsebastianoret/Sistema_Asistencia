<?php
include 'session.php';

if (isset($_POST['add'])) {
	$criterio = $_POST['criterio'];

	$sql = "INSERT INTO criterios (nombre_criterio) VALUES ('$criterio')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Criterio añadido con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../criterios.php');
?>