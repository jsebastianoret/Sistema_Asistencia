<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id_criterio = $_POST['id'];

	$sql = "DELETE FROM criterios WHERE id = '$id_criterio'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Criterio eliminado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../criterios.php');
?>