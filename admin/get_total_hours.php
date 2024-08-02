<?php
include 'includes/conn.php';

if (isset($_POST['employee_id'])) {
    $employeeId = $_POST['employee_id'];

    // Obtener horario programado
    $sqlSchedule = "SELECT time_in, time_out FROM schedules
                    JOIN employees ON employees.schedule_id = schedules.id
                    WHERE employees.id = ?";
    $stmtSchedule = $conn->prepare($sqlSchedule);
    $stmtSchedule->bind_param("i", $employeeId);
    $stmtSchedule->execute();
    $resultSchedule = $stmtSchedule->get_result();

    if ($resultSchedule->num_rows > 0) {
        $schedule = $resultSchedule->fetch_assoc();
        $scheduledTimeIn = new DateTime($schedule['time_in']);
        $scheduledTimeOut = new DateTime($schedule['time_out']);
    } else {
        echo json_encode(['total_hours' => 0]);
        exit;
    }

    // Obtener asistencia
    $sqlAttendance = "SELECT time_in, time_out FROM attendance WHERE employee_id = ?";
    $stmtAttendance = $conn->prepare($sqlAttendance);
    $stmtAttendance->bind_param("i", $employeeId);
    $stmtAttendance->execute();
    $resultAttendance = $stmtAttendance->get_result();

    $totalHours = 0;
    while ($attendance = $resultAttendance->fetch_assoc()) {
        $actualTimeIn = new DateTime($attendance['time_in']);
        $actualTimeOut = new DateTime($attendance['time_out']);

        // Ajustar la hora de entrada registrada para que no sea antes del horario programado
        $adjustedTimeIn = max($actualTimeIn, $scheduledTimeIn);

        // Asegurarse de que la hora de salida real no sea después de la hora de salida programada
        $adjustedTimeOut = min($actualTimeOut, $scheduledTimeOut);

        // Calcular solo si la hora ajustada de salida es después de la hora ajustada de entrada
        if ($adjustedTimeOut > $adjustedTimeIn) {
            $interval = $adjustedTimeIn->diff($adjustedTimeOut);
            $hoursWorked = ($interval->h + ($interval->days * 24)) + ($interval->i / 60);
            $totalHours += $hoursWorked;
        }
    }

    echo json_encode(['total_hours' => round($totalHours, 2)]);
}

$conn->close();
?>
