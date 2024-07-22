<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];

  $sql = "SELECT COUNT(*) AS cantidad_tardanzas FROM attendance WHERE employee_id = '$employeeId' AND status = '0'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_tardanzas = $row['cantidad_tardanzas'];


  echo json_encode(['cantidad_tardanzas' => $cantidad_tardanzas]);
}
?>