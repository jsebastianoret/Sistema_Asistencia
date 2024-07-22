<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];

	$sql = "DELETE FROM negocio WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Unidad de Negocio eliminado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../negocio.php');
?>