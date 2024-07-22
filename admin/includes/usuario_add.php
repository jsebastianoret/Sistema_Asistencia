<?php
include 'session.php';

if (isset($_POST['add'])) {
	$username = $_POST['usuario'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$rango = $_POST['rango'];

	$sql = "INSERT INTO admin (username, password, firstname, lastname, id_rango) VALUES ('$username', '$password', '$nombre', '$apellido', '$rango')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Usuario añadido con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../usuarios.php');
?>