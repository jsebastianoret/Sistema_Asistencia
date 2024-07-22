<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];

  $sql = "SELECT COUNT(*) AS cantidad_asistencia FROM attendance WHERE employee_id = '$employeeId' AND status = '1'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_asistencia = $row['cantidad_asistencia'];

  echo json_encode(['cantidad_asistencia' => $cantidad_asistencia]);
}
?>