<?php
include 'session.php';

if (isset($_POST['add'])) {
    $marcar_fecha_asistencia = $_POST['marcar_fecha_asistencia'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $employee_id = $_POST['employee_id2'];
    $entrada = DateTime::createFromFormat('H:i', $hora_entrada);
    $salida = DateTime::createFromFormat('H:i', $hora_salida);

    $diferencia = $salida->diff($entrada);
    $horas = $diferencia->h + ($diferencia->i / 60);

    $sql = "INSERT INTO attendance (employee_id, date, status, time_in, time_out, num_hr, hr_pen_recu) VALUES ('$employee_id', '$marcar_fecha_asistencia', 1 ,
            '$hora_entrada', '$hora_salida', '$horas', 0)";
        
        if ($conn->query($sql)) {
		$_SESSION['success'] = 'Fecha añadida con éxito';
	    } else {
		$_SESSION['error'] = $conn->error;
	    }
}

header('location: ../resumen.php');

?>
