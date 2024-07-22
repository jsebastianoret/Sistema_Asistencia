<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "SELECT *, e.id as empid
	FROM employees e
	LEFT JOIN position p ON p.id = e.position_id
	LEFT JOIN schedules s ON s.id = e.schedule_id
	LEFT JOIN negocio n ON n.id = e.negocio_id
	LEFT JOIN grades g ON g.employee_id = e.id
	LEFT JOIN departamentos d ON d.id = e.departamento_id
	WHERE e.id = '$id'";
	$query = $conn->query($sql);
	$row = $query->fetch_assoc();

	echo json_encode($row);
}
?>