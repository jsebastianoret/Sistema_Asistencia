<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];
	// Sentencia SQL para seleccionar los datos que deseas insertar en la tabla papelera
	$sqlSelect = "SELECT * FROM employees WHERE id = '$id'";
	// Ejecutar la consulta de selección
	$resultSelect = $conn->query($sqlSelect);
	// Verificar si se obtuvieron resultados
	if ($resultSelect->num_rows > 0) {
		// Sentencia SQL para insertar los datos seleccionados en la tabla papelera
		$sqlInsert = "INSERT INTO papelera SELECT * FROM employees WHERE id = '$id'";
		// Ejecutar la consulta de inserción
		if ($conn->query($sqlInsert) === true) {
			$_SESSION['success'] = 'Empleado eliminado con éxito';
		} else {
			$_SESSION['error'] = $conn->error;
		}
		// Sentencia SQL para eliminar los datos de la tabla employees
		$sqlDeleteSchedule = "DELETE FROM papelera WHERE employee_id = '$id'";
		if ($conn->query($sqlDeleteSchedule) === TRUE) {
			// Continuar con la eliminación del empleado de la tabla employees
			$sqlDeleteEmployee = "DELETE FROM employees WHERE id = '$id'";
			if ($conn->query($sqlDeleteEmployee) === TRUE) {
				$_SESSION['success'] = 'Practicante eliminado con éxito';
			} else {
				$_SESSION['error'] = $conn->error;
			}
		} else {
			$_SESSION['error'] = $conn->error;
		}
	} else {
		$_SESSION['error'] = 'No se encontraron datos en la tabla employees con el ID ' . $id;
	}
}

header('location: ../practicantes.php');
?>