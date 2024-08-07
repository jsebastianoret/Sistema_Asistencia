<?php
include "includes/conn.php";

$employee_id = $row['id'];

$sqlHr = "SELECT ROUND(SUM(num_hr)) AS total_num_hr FROM attendance WHERE employee_id = ?";
$stmtHr = $conn->prepare($sqlHr);
$stmtHr->bind_param("i", $employee_id);
$stmtHr->execute();
$resultHr = $stmtHr->get_result();

if ($resultHr->num_rows > 0) {
    $rowHr = $resultHr->fetch_assoc();
    $total_num_hr = $rowHr["total_num_hr"];
} else {
    echo "No se encontraron registros para employee_id = " . $employee_id;
}

$percentage = $total_num_hr;

$total = 320;

if ($row['time_practice'] == 3) {
    $total = 320;
} elseif ($row['time_practice'] == 4) {
    $total = 427;
}

$totalDeg = ($total != 0) ? $total / 100 : 1;
$CircularDeg = $percentage / $totalDeg;
$percentageDeg = 100 - $CircularDeg;


$stmtHr->close();
$conn->close();
?>