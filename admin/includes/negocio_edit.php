<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$negocio = $_POST['negocio'];

	$sql = "UPDATE negocio SET nombre_negocio = '$negocio' WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Unidad de Negocio actualizado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../negocio.php');
?>