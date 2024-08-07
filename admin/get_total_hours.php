<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];

  $sql = "SELECT SUM(num_hr) AS total_hours FROM attendance WHERE employee_id = '$employeeId'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $totalHours = $row['total_hours'];

  if ($totalHours === null) {
    $totalHours = 0;
  }

  echo json_encode(['total_hours' => $totalHours]);
}
?>