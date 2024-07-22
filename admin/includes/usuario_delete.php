<?php
include 'session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];
	$sql = "DELETE FROM `admin` WHERE id='$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Usuario eliminado con éxito';
	} else {
		$_SESSION['error'] = $conn->error;
	}
}

header('location: ../usuarios.php');
?>