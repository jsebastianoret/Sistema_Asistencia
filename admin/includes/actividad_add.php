<?php
include 'session.php';

if (isset($_POST['add'])) {
	$empleado_id = $_POST['id'];
	$fecha = $_POST['fecha'];
	$entrada = $_POST['entrada'];
	$salida = $_POST['salida'];
	$actividades = $_POST['actividades'];

	$sql = "INSERT INTO actividades (employee_id, fecha, entrada, salida, actividades) VALUES ('$empleado_id', '$fecha', '$entrada','$salida', '$actividades')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Registro añadido con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../practicantes.php');
?>