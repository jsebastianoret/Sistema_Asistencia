<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id_subcriterio = $_POST['id'];
	$subcriterio = $_POST['subcriterio'];
	$id_criterio = $_POST['id_criterio'];

	$sql = "UPDATE subcriterios SET nombre_subcriterio = '$subcriterio', id_criterio = '$id_criterio' WHERE id = '$id_subcriterio'";

	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Subcriterio actualizado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../subcriterios.php');
?>