<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$username = $_POST['usuario'];
	$password = $_POST['password'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$rango = $_POST['rango'];

	// Verificar si se proporcionó una nueva contraseña
	if (!empty($password)) {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "UPDATE admin SET username = '$username', password = '$hash', firstname = '$nombre', lastname = '$apellido', id_rango = '$rango' WHERE id = '$id'";
	} else {
		$sql = "UPDATE admin SET username = '$username', firstname = '$nombre', lastname = '$apellido', id_rango = '$rango' WHERE id = '$id'";
	}

	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Usuario actualizado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../usuarios.php');
?>