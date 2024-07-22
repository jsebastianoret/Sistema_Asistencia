<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
	$id_subcriterio = $_POST['id'];
	$sql = "SELECT * FROM subcriterios WHERE id = '$id_subcriterio'";
	$query = $conn->query($sql);
	$row = $query->fetch_assoc();

	echo json_encode($row);
}
?>