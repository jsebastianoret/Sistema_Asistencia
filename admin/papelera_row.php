<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "SELECT *, pa.id as paid
	FROM papelera pa
	LEFT JOIN position po ON po.id = pa.position_id
	LEFT JOIN schedules s ON s.id = pa.schedule_id
	LEFT JOIN negocio n ON n.id = pa.negocio_id
	LEFT JOIN grades g ON g.employee_id = pa.id
	WHERE pa.id = '$id'";
	$query = $conn->query($sql);
	$row = $query->fetch_assoc();

	echo json_encode($row);
}
?>