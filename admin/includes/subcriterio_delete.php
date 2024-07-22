<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id_subcriterio = $_POST['id'];

	$sql = "DELETE FROM subcriterios WHERE id = '$id_subcriterio'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Subcriterio eliminado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../subcriterios.php');
?>