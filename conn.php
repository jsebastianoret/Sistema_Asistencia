<?php
$conn = new mysqli('localhost', 'root', 'T3csup2405', 'ghxumdmy_asistencia');

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>