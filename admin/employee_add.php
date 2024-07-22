<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		//$address = $_POST['address'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$negocio = $_POST['negocio'];
		$position = $_POST['position'];
		$schedule = $_POST['schedule'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		//creating employeeid
		$letters = '';
		$numbers = '';
		foreach (range('A', 'Z') as $char) {
		    $letters .= $char;
		}
		for($i = 0; $i < 10; $i++){
			$numbers .= $i;
		}
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
		$employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);
		//
		$sql = "INSERT INTO employees (employee_id, firstname, lastname, contact_info, gender, negocio_id, position_id,
		 schedule_id, photo, created_on, date_in, date_out, time_practice, type_practice,birthday, dni, personal_email,
		 institutional_email,university,career) VALUES ('$employee_id', '$firstname', '$lastname', '$contact', '$gender',
		  '$negocio', '$position', '$schedule', '$filename', NOW(), '$date_in' , '$date_out','$time_practice','$type_practice','$birthday',
		  '$dni','$personal_email','$institutional_email','$university','$career')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Empleado añadido satisfactoriamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: employee.php');
?>