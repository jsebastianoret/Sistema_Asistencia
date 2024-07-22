<?php
$conn = new mysqli('localhost', 'root', 'kado12', 'asistencia');
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>