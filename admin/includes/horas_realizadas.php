<?php
include "includes/conn.php";

// Asegúrate de que $row['id'] está definido correctamente
$employee_id = $row['id'];

// Obtener las horas programadas desde la tabla schedules
$sqlSchedule = "SELECT schedules.time_in, schedules.time_out 
                FROM schedules 
                JOIN employees ON employees.schedule_id = schedules.id 
                WHERE employees.id = ?";
$stmtSchedule = $conn->prepare($sqlSchedule);

if ($stmtSchedule === false) {
    die('Error en prepare: ' . $conn->error);
}

$stmtSchedule->bind_param("i", $employee_id);
$stmtSchedule->execute();
$resultSchedule = $stmtSchedule->get_result();

if ($resultSchedule->num_rows > 0) {
    $rowSchedule = $resultSchedule->fetch_assoc();
    $scheduled_time_in = $rowSchedule['time_in'];
    $scheduled_time_out = $rowSchedule['time_out'];
} else {
    echo "No se encontraron horarios programados para el empleado con ID = " . $employee_id;
    exit;
}

// Calcular las horas trabajadas ajustadas en la tabla attendance
$sqlHr = "
    SELECT 
        time_in,
        time_out
    FROM attendance 
    WHERE employee_id = ?
";

$stmtHr = $conn->prepare($sqlHr);

if ($stmtHr === false) {
    die('Error en prepare: ' . $conn->error);
}

$stmtHr->bind_param("i", $employee_id);
$stmtHr->execute();
$resultHr = $stmtHr->get_result();

$total_num_hr = 0;
while ($rowHr = $resultHr->fetch_assoc()) {
    $actual_time_in = new DateTime($rowHr['time_in']);
    $actual_time_out = new DateTime($rowHr['time_out']);

    // Ajustar la hora de entrada registrada para que no sea antes del horario programado
    $adjusted_time_in = max($actual_time_in, new DateTime($scheduled_time_in));

    // Asegurarse de que la hora de salida real no sea después de la hora de salida programada
    $adjusted_time_out = min($actual_time_out, new DateTime($scheduled_time_out));

    // Calcular solo si la hora ajustada de salida es después de la hora ajustada de entrada
    if ($adjusted_time_out > $adjusted_time_in) {
        $interval = $adjusted_time_in->diff($adjusted_time_out);
        $hours_worked = ($interval->h + ($interval->days * 24)) + ($interval->i / 60);
        $total_num_hr += $hours_worked;
    }
}

// Redondear el total de horas trabajadas hacia abajo al número entero más cercano
$total_num_hr = floor($total_num_hr);

if ($total_num_hr == 0) {
    echo "No se encontraron registros válidos para el empleado con ID = " . $employee_id;
    exit;
}

// Calcular el porcentaje
$percentage = $total_num_hr;

$total = 320; // Ajustar el total según corresponda
if ($row['time_practice'] == 3) {
    $total = 320;
} elseif ($row['time_practice'] == 4) {
    $total = 427;
}

$totalDeg = ($total != 0) ? $total / 100 : 1;
$CircularDeg = $percentage / $totalDeg;
$percentageDeg = 100 - $CircularDeg;

$stmtHr->close();
$stmtSchedule->close();
$conn->close();
?>
