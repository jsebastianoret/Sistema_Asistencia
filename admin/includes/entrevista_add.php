<?php
include 'session.php';

if (isset($_POST['add'])) {
	$nombres = $_POST['nombres'];
	$apellidos = $_POST['apellidos'];
	$area = $_POST['area'];
	$unidad = $_POST['unidad'];

	$sql = "INSERT INTO entrevistas (firstname, lastname, unidad, area) VALUES ('$nombres', '$apellidos', '$unidad', '$area')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Entrevista añadida con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../entrevistas.php');
?>