<?php
include 'session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$state_entrevista = "";
	$agendar = "";
	$asistencia = "";
	if (isset($_POST['state_entrevista'])) {
		$state_entrevista = "estado_entrevista = {$_POST['state_entrevista']}";
	}
	if (isset($_POST['date_entrevista']) && isset($_POST['hour_entrevista'])) {
		$agendar = ",fecha_entrevista = '{$_POST['date_entrevista']}', hora_entrevista = '{$_POST['hour_entrevista']}'";
	}
	if (isset($_POST['asistencia'])) {
		$asistencia = "asistencia = '{$_POST['asistencia']}'";
	}
	if (isset($_POST['state_asistencia'])) {
		$asistencia = ",asistencia = '{$_POST['state_asistencia']}'";
	}

	$sql = "UPDATE entrevistas SET $state_entrevista $agendar $asistencia WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Entrevista actualizada con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../entrevistas.php');
?>