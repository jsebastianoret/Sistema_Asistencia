<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$empid = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		//$address = $_POST['address'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$negocio = $_POST['negocio'];
		$position = $_POST['position'];
		$schedule = $_POST['schedule'];
		//campos nuevos agregados a la BD
		$date_in = $_POST['date_in'];
		$date_out= $_POST['date_out'];
		$time_practice = $_POST['time_practice'];
		$type_practice = $_POST['type_practice'];
		$birthday = $_POST['birthday'];
		$dni = $_POST['dni'];
		$personal_email= $_POST['personal_email'];
		$institutional_email = $_POST['institutional_email'];
		$university = $_POST['university'];
		$career = $_POST['career'];
		//
		
		$sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', contact_info = '$contact',
		 gender = '$gender', negocio_id = '$negocio', position_id = '$position', schedule_id = '$schedule' , date_in= '$date_in',
		 date_out ='$date_out', time_practice='$time_practice' , type_practice= '$type_practice', birthday ='$birthday', dni='$dni', 
		 personal_email= '$personal_email', institutional_email='$institutional_email', university= '$university', career = '$career'
		 WHERE id = '$empid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Empleado actualizado con éxito';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Seleccionar empleado para editar primero';
	}

	header('location: employee.php');
?>