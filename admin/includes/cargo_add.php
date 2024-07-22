<?php
include 'session.php';

if (isset($_POST['add'])) {
	$cargo = $_POST['cargo'];

	$sql = "INSERT INTO position (description) VALUES ('$cargo')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Cargo añadido con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../cargos.php');
?>