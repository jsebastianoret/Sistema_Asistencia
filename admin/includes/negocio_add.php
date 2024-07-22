<?php
include 'session.php';

if (isset($_POST['add'])) {
	$negocio = $_POST['negocio'];

	$sql = "INSERT INTO negocio (nombre_negocio) VALUES ('$negocio')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Unidad de Negocio añadido con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../negocio.php');
?>