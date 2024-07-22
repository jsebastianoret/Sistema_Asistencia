<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$cargo = $_POST['cargo'];

	$sql = "UPDATE position SET description = '$cargo' WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Cargo actualizado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../cargos.php');
?>