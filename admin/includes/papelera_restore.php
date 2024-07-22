<?php
include 'session.php';

if (isset($_POST['restore'])) {
	$id = $_POST['paid'];

	$sqlSelect = "SELECT * FROM papelera WHERE id = '$id'";
	$resultSelect = $conn->query($sqlSelect);
	if ($resultSelect->num_rows > 0) {
		$sqlInsert = "INSERT INTO employees SELECT * FROM papelera WHERE id = '$id'";
		$conn->query($sqlInsert)
			? $_SESSION['success'] = "Empleado restaurado con éxito"
			: $_SESSION['error'] = $conn->error;

		$sqlDelete = "DELETE FROM papelera WHERE id = '$id'";
		$conn->query($sqlDelete)
			? $_SESSION['success'] = "Practicante restaurado con éxito"
			: $_SESSION['error'] = 'Error al restaurar practicante';
	} else {
		$_SESSION['error'] = 'Error al restaurar practicante';
	}
}

header("location: ../papelera.php");
?>