<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
	$id_criterio = $_POST['id'];
	$sql = "SELECT * FROM criterios WHERE id = '$id_criterio'";
	$query = $conn->query($sql);
	$row = $query->fetch_assoc();

	echo json_encode($row);
}
?>