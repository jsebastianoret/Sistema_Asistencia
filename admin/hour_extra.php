<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "SELECT concat(firstname,' ',lastname) AS 'fullname' ,IFNULL(extra_hour, 0) AS 'extra_hour' FROM asistencia.employees where id='$id'";
	$query = $conn->query($sql);
	$row = $query->fetch_assoc();

	echo json_encode($row);
}
?>