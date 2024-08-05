<?php

date_default_timezone_set('America/Lima');
include 'admin/function_count_justified_and_unjustified_absences.php';
include 'conn.php';

if (isset($_POST['employee'])) {
	$output = array('error' => false);
	$employee = $_POST['employee'];
	$status = $_POST['status'];

	$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		$id = $row['id'];
		$date_out = $row['date_out'];
		$date_out_new = $row['date_out_new'];

		//Actualizar la nueva fecha de salida según las faltas.
		$resultado_json = cantFaltas($id);
		$resultado_array = json_decode($resultado_json, true);
		$faltas_injustificadas = $resultado_array['faltas_injustificadas'];
		$date_out_obj = new DateTime($date_out);
		$date_out_obj->modify('+' . $faltas_injustificadas . ' days');
		$new_date_out = $date_out_obj->format('Y-m-d');
		$update_sql = "UPDATE employees SET date_out_new = '$new_date_out' WHERE id = $id";
		$conn->query($update_sql);

		$sql = "SELECT * FROM mejor_colaborador ORDER BY id DESC LIMIT 3";
		$query = $conn->query($sql);
		$frase = "";
		while ($row2 = $query->fetch_assoc()) {
			// Consulta si el empleado es uno de los 3 mejores colaboradores y si es así, se le muestra una frase motivadora aleatoria
			if ($row2['employee_id'] == $id) {
				$sql = "SELECT * FROM frase_colaborador ORDER BY RAND() LIMIT 1";
				$result = $conn->query($sql);
				$row3 = $result->fetch_assoc();
				$frase = "<script>$('#frase').text('" . $row3['frase'] . "')</script>";
			}
		}


		$date_now = date('Y-m-d');

		// Mover a papelera si la nueva fecha de salida es mayor a la fecha actual o si tiene más de 10 faltas
		$date_out_aux;
		if (empty($date_out_new)) {
			$date_out_aux = $date_out;
		} else {
			$date_out_aux = $date_out_new;
		}
		if ($date_now > $date_out_aux) {
			$sql = "INSERT INTO papelera SELECT * FROM employees WHERE id = '$id'";
			if ($conn->query($sql)) {
				$sql = "DELETE FROM employees WHERE id = '$id'";
				if ($conn->query($sql)) {
					$output['error'] = true;
					$output['message'] = 'Tu usuario ha sido suspendido por haber superado tu fecha de prácticas o límite de faltas';
				} else {
					$output['error'] = true;
					$output['message'] = $conn->error;
				}
			} else {
				$output['error'] = true;
				$output['message'] = $conn->error;
			}
		} else {
			if ($status == 'in') {

				$sched = $row['schedule_id'];
				$sql = "SELECT * FROM schedules WHERE id = '$sched'";
				$squery = $conn->query($sql);
				$srow = $squery->fetch_assoc();
				$fechaEntrada = $srow['time_in'];
				$fechaSalida = $srow['time_out'];
				$day = date('l');
				$lognow = date('H:i:s');
				$lognowDateTime = new DateTime($lognow);

				if($day == 'Saturday'){
					$fechaSalida='12:00:00'; 
					$fechaEntrada='09:00:00';
				}

				$fechaEntradaDateTime = new DateTime($fechaEntrada);
				$fechaSalidaDateTime = new DateTime($fechaSalida);
				$permiteMarcarDateTime = clone $fechaEntradaDateTime;
				$permiteMarcarDateTime->modify('-6 minutes');
				
				
				if ($lognowDateTime < $permiteMarcarDateTime || $lognowDateTime > $fechaSalidaDateTime || $day=='Sunday') {
					$output['error'] = true;
					$output['message'] = 'Este no es el horario adecuado para marcar asistencia.';
				} else {
					$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
					$query = $conn->query($sql);
					if ($query->num_rows > 0) {
						$output['error'] = true;
						$output['message'] = 'Ya has marcado tu entrada para hoy.';
					} else {
						
						$NuevaFechas = new DateTime($fechaEntrada);
						$NuevaFechas->modify('+6 minute');
						$NuevaFechas = $NuevaFechas->format("H:i:s");

						$logstatus = ($lognow > $NuevaFechas) ? 0 : 1;

						if ($logstatus == 1) {
							$lognow = $fechaEntrada;
						}

						$sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', '$lognow', '$logstatus')";

						if ($conn->query($sql)) {
							if (!$logstatus) {
								$alert = '<script>
								Swal.fire({
									title: "Se ha registrado tu ingreso tarde",
									icon: "warning",
									width: "400px"
								})
							</script>';
							} else {
								$alert = '<script>
								Swal.fire({
									title: "Felicitaciones por tu puntualidad!🎉",
									icon: "success",
									width: "400px"
								})
							</script>';
							}

							$output['message'] = $frase . $alert . '<p class="bienvenida">¡Hola, ' . $row['firstname'] . ' ' . $row['lastname'] . '!</p>
						<p class="registro__exitoso">Se ha registrado tu ingreso</p>';
						} else {
							$output['error'] = true;
							$output['message'] = $conn->error;
						}
					}
				}
			}

			if ($status == 'out') {
				$sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
				$query = $conn->query($sql);
				if ($query->num_rows < 1) {
					$output['error'] = true;
					$output['message'] = 'No se puede registrar tu salida, sin previamente registrar tu entrada.';
				} else {
					$row = $query->fetch_assoc();
					if ($row['time_out'] != '00:00:00') {
						$output['error'] = true;
						$output['message'] = 'Ya has marcado tu salida por hoy.';
					} else {
						//updates
						$sched = $row['schedule_id'];
						$lognow1 = date('H:i:s');
						$day = date('l');
						$sql = "SELECT * FROM schedules WHERE id = '$sched'";
						$squery = $conn->query($sql);
						$srow = $squery->fetch_assoc();
						$horaSalida = $srow['time_out'];
						
						if($day == 'Saturday'){
							$horaSalida='12:00:00';
						}
						
						$logstatus = ($lognow1 > $horaSalida) ? 0 : 1;


						if ($logstatus === 0) {
							$lognow1 = $horaSalida;
						}

						$sql = "UPDATE attendance SET time_out = '$lognow1' WHERE id = '" . $row['uid'] . "'";

						if ($conn->query($sql)) {
							$output['message'] = $frase . '<p class="bienvenida">¡Adios, ' . $row['firstname'] . ' ' . $row['lastname'] . '!</p> <p class="registro__exitoso">Se ha registrado tu salida</p>';

							$sql = "SELECT * FROM attendance WHERE id = '" . $row['uid'] . "'";
							$query = $conn->query($sql);
							$urow = $query->fetch_assoc();

							$time_in = $urow['time_in'];
							$time_out = $urow['time_out'];

							$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
							$query = $conn->query($sql);
							$srow = $query->fetch_assoc();

							if ($srow['time_in'] > $urow['time_in']) {
								$time_in = $srow['time_in'];
							}

							if ($srow['time_out'] < $urow['time_in']) {
								$time_out = $srow['time_out'];
							}

					
							$time_in = new DateTime($time_in);
							$time_out = new DateTime($time_out);
							$interval = $time_in->diff($time_out);
							$hrs = $interval->format('%h');
							$mins = $interval->format('%i');
							$result = $hrs.'.'.$mins;
							$int = (double)$result;
							// $mins = $mins / 60; 
							// $int = $hrs + $mins

							$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '" . $row['uid'] . "'";
							$conn->query($sql);
						} else {
							$output['error'] = true;
							$output['message'] = $conn->error;
						}
					}
				}
			}

			if ($status == 'perfil') {
				$output['error'] = false;
				$output['message'] = $frase . '<p class="bienvenida">¡Hola, ' . $row['firstname'] . ' ' . $row['lastname'] . '!</p> <p class="registro__exitoso">¿A qué sección de tu perfil quieres ingresar?</p>';
			}
		}
	} else {
		$output['error'] = true;
		$output['message'] = 'ID de empleado no encontrado';
	}
}

echo json_encode($output);
