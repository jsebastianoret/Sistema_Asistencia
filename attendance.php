<?php 
	date_default_timezone_set('America/Lima');
	include 'admin/function_count_justified_and_unjustified_absences.php';
	include 'conn.php';
	
	if (isset($_POST['employee'])) {
		$output = array('error' => false);
		$employee = $_POST['employee'];
		$status = $_POST['status'];

		$sql = "SELECT id,firstname,lastname,schedule_id,date_out,date_out_new FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);

		if ($query->num_rows > 0) {
			$row = $query->fetch_assoc();
			$id = $row['id'];
			$date_out = $row['date_out'];
			$firstname=$row['firstname'];
			$lastname=$row['lastname'];
			$date_out_new = $row['date_out_new'];
			$sched = $row['schedule_id'];
			$date_now = date('Y-m-d');
			$lognow = date('H:i:s');
			$day = date('l');
			$date_out_aux;
			$frase = "";

			actualizarSalida($id,$date_out,$conn);
			$frase=mejorColaborador($conn,$id,$frase);

			$date_out_aux = empty($date_out_new) ? $date_out : $date_out_new;

			if ($date_now > $date_out_aux) {
				//Enviar a papelera al finalizar su fecha de salida.
				moverPapelera($conn,$id,$output);
			}else{
				//Marcar entrada del practicante
				if ($status == 'in') {
					$sql = "SELECT time_in,time_out FROM schedules WHERE id = '$sched'";
					$squery = $conn->query($sql);
					$srow = $squery->fetch_assoc();
					$fechaEntrada = $srow['time_in']; 
					$fechaSalida = $srow['time_out'];

					//Condicional para el horario flexible
					if ($sched == 4) {
						if ($lognow >= '08:55:00' && $lognow <= '13:24:00') {
							$fechaEntrada = '09:00:00';
							$fechaSalida = '13:30:00';
						} elseif ($lognow >= '13:25:00' && $lognow <= '18:05:00') {
							$fechaEntrada = '13:30:00';
							$fechaSalida = '18:00:00';
						}
					}

					$lognowDateTime = new DateTime($lognow);
					$fechaEntradaDateTime = new DateTime($fechaEntrada);
					$fechaSalidaDateTime = new DateTime($fechaSalida);
					$minPermitido = clone $fechaEntradaDateTime;
					$minPermitido->modify('-6 minutes');
					
					//Condicional para los días sábados
					if($day == 'Saturday'){
						$fechaEntrada='09:00:00';
						$fechaSalida='12:00:00'; 
					}

					//Validar si es horario laborable
					if ($lognowDateTime < $minPermitido || $lognowDateTime > $fechaSalidaDateTime || $day=='Sunday') {
						$output['error'] = true;
						$output['message'] = 'Este no es el horario adecuado para marcar asistencia.';
					} else {
						//Comprobar si ya marcado asistencia
						$sql = "SELECT * FROM attendance WHERE employee_id = $id AND date = '$date_now' AND time_in IS NOT NULL";
						$query = $conn->query($sql);
						if ($query->num_rows > 0) {
							$output['error'] = true;
							$output['message'] = 'Ya has marcado tu entrada para hoy.';
						} else {
							$maxPermitido = clone $fechaEntradaDateTime;
							$maxPermitido->modify('+6 minute');
							$maxPermitido = $maxPermitido->format("H:i:s");
							
							$logstatus = ($lognow > $maxPermitido) ? 0 : 1;
							if ($logstatus == 1) $lognow = $fechaEntrada;
							
							$sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', '$lognow', '$logstatus')";
	
							if ($conn->query($sql)) {
								if (!$logstatus) {
									$alert=sweetAlert('Se ha registrado tu ingreso tarde','warning');
								} else {
									$alert=sweetAlert('Felicitaciones por tu puntualidad!🎉','success');
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
				
				//Marcar salida del practicante
				if ($status == 'out') {
					$sql="SELECT a.time_in,a.time_out,a.employee_id,e.lastname,e.firstname
						FROM attendance a INNER JOIN employees e
						ON e.id=a.employee_id 
						WHERE a.employee_id = '$id' AND date = '$date_now'";
					$query = $conn->query($sql);
					if ($query->num_rows < 1) {
						$output['error'] = true;
						$output['message'] = 'No se puede registrar tu salida, sin previamente registrar tu entrada.';
					} else {
						$row = $query->fetch_assoc();
						$time_in=$row['time_in'];
						$time_out=$row['time_out'];
						$employe_id=$row['employee_id'];
						$firstname=$row['firstname'];
						$lastname=$row['lastname'];

						if ($time_out!= '00:00:00') {
							$output['error'] = true;
							$output['message'] = 'Ya has marcado tu salida por hoy.';
						} else {
							$sql = "SELECT time_out FROM schedules WHERE id = '$sched'";
							$squery = $conn->query($sql);
							$srow = $squery->fetch_assoc();
							$horaSalida = $srow['time_out'];

							if($sched==4){
								if ('08:55:00' <= $time_in && $time_in <= '13:24:00') {
									$horaSalida='13:30:00'; 
									
								}else if('13:25:00' <= $time_in && $time_in <= '18:05:00'){
									$horaSalida='18:00:00'; 
								}
							}
							
							if($day == 'Saturday')$horaSalida='12:00:00';
							$logstatus = ($lognow > $horaSalida) ? 0 : 1;
							if ($logstatus === 0) $lognow = $horaSalida;
	
							$sql = "UPDATE attendance SET time_out = '$lognow' WHERE employee_id = '$employe_id' AND DATE='$date_now' ";
	
							if ($conn->query($sql)) {

								$output['message'] = $frase . '<p class="bienvenida">¡Adios, ' . $firstname . ' ' . $lastname. '!</p> <p class="registro__exitoso">Se ha registrado tu salida</p>';
	
								
								$sql = "SELECT time_in,time_out FROM attendance WHERE employee_id = '$employe_id' AND DATE='$date_now'";
								$query = $conn->query($sql);
								$urow = $query->fetch_assoc();
								$time_in = $urow['time_in'];
								$time_out = $urow['time_out'];

								$time_in = new DateTime($time_in);
								$time_out = new DateTime($time_out); 
	
								$interval = $time_in->diff($time_out);
								$hrs = $interval->format('%h');
								$mins = $interval->format('%i');
								$result = $hrs.'.'.$mins;
								$int = (double)$result;
	
								$sql = "UPDATE attendance SET num_hr = '$int' WHERE employee_id = '$employe_id' AND DATE='$date_now'";
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
					$output['message'] = $frase . '<p class="bienvenida">¡Hola, ' . $firstname . ' ' . $lastname.
										 '!</p> <p class="registro__exitoso">¿A qué sección de tu perfil quieres ingresar?</p>';
				}
			}
		}else {
			$output['error'] = true;
			$output['message'] = 'ID de empleado no encontrado';
		}
	}

	function actualizarSalida($id,$date_out,$conn){
		$resultado_json = cantFaltas($id);
		$resultado_array = json_decode($resultado_json, true);
		$faltas_injustificadas = $resultado_array['faltas_injustificadas'];
		$date_out_obj = new DateTime($date_out);
		$date_out_obj->modify('+' . $faltas_injustificadas . ' days');
		$new_date_out = $date_out_obj->format('Y-m-d');
		$update_sql = "UPDATE employees SET date_out_new = '$new_date_out' WHERE id = $id";
		$conn->query($update_sql);
	}

	function mejorColaborador($conn,$id,$frase){
		$sql = "SELECT employee_id FROM mejor_colaborador ORDER BY id DESC LIMIT 3";
		$query = $conn->query($sql);
		while ($row2 = $query->fetch_assoc()) {
			if ($row2['employee_id'] == $id) {
				$sql = "SELECT frase FROM frase_colaborador ORDER BY RAND() LIMIT 1";
				$result = $conn->query($sql);
				$row3 = $result->fetch_assoc();
				$frase = "<script>$('#frase').text('" . $row3['frase'] . "')</script>";
			}
		}
		return $frase;
	}
	
	function moverPapelera($conn,$id,&$output){
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
	}
	
	function sweetAlert($title, $icon) {
		$alert='';
		$alert = '<script>
			Swal.fire({
				title: "' . $title . '",
				icon: "' . $icon . '",
				width: "400px"
			})
		</script>';
		return $alert;
	}
	echo json_encode($output);
?>