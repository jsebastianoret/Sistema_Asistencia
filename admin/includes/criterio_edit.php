<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id_criterio = $_POST['id'];
	$criterio = $_POST['criterio'];

	$sql = "UPDATE criterios SET nombre_criterio = '$criterio' WHERE id = '$id_criterio'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Criterio actualizado satisfactoriamente';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../criterios.php');
?>