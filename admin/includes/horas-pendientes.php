<?php
include "includes/conn.php";

$employee_id = $row['id'];

$sqlHr = "SELECT ROUND(SUM(hr_pen_recu), 1) AS total_hr_rec FROM attendance WHERE employee_id = '$employee_id'";
$query = $conn->query($sqlHr);

if ($query->num_rows > 0) {
    $rowHr = $query->fetch_assoc();
    $total_hr_rec = $rowHr["total_hr_rec"];
} else {
    echo "No se encontraron registros para employee_id = " . $employee_id;
}

$percentage = $total_hr_rec > 13.5 ? 13.5 : (!is_null($total_hr_rec) ? $total_hr_rec : 0);
$totalDeg = 13.5 / 100;
$CircularDeg = $percentage / $totalDeg;
$percentageDeg = 100 - $CircularDeg;

$conn->close();
?>