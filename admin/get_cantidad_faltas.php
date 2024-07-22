<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];


  $sql = "SELECT 
                FLOOR(
                    (SELECT COUNT(*) FROM attendance WHERE employee_id = '$employeeId' AND status = 0) / 3
                ) + (SELECT COUNT(*) FROM attendance WHERE employee_id = '$employeeId' AND status IS NULL) AS cantidad_faltas";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $cantidad_faltas = $row['cantidad_faltas'];


  echo json_encode(['cantidad_faltas' => $cantidad_faltas]);
}
?>