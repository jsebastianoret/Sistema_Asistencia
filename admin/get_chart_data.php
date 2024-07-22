<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];

  $sql = "SELECT COUNT(*) AS cantidad_asistencia FROM attendance WHERE employee_id = '$employeeId' AND status = '1'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_asistencia = $row['cantidad_asistencia'];

  $sql = "SELECT COUNT(*) AS cantidad_faltas FROM attendance WHERE employee_id = '$employeeId' AND status = NULL";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_faltas = $row['cantidad_faltas'];

  $sql = "SELECT COUNT(*) AS cantidad_tardanzas FROM attendance WHERE employee_id = '$employeeId' AND status = '0'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_tardanzas = $row['cantidad_tardanzas'];

  echo json_encode(['cantidad_asistencia' => $cantidad_asistencia,
                    'cantidad_faltas' => $cantidad_faltas,
                    'cantidad_tardanzas' => $cantidad_tardanzas]);
}
?>