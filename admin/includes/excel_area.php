<?php header("Content-type: application/xls") ?>
<?php header("Content-Disposition: attachment; filename = Control de Asistencia NHL Áreas.xls") ?>
<?php include 'session.php' ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<body>
    <style>
        table,
        tr,
        th,
        td {
            border: #1422D2;
            text-align: center;
        }
    </style>
    <h2>Control de Asistencia Semanal</h2>
    <table border='1' id="example1 border-collapse: separate">
        <thead>
            <th scope='col' bgcolor='#00B0F0'>Nombre y Apellido</th>
            <th scope='col' bgcolor='#FF66FF'>Unidad de Negocio</th>
            <th scope='col' bgcolor='#9966FF'>Area</th>
            <th scope='col' bgcolor='#92D050'>Asistencias a Tiempo</th>
            <th scope='col' bgcolor='#00FF99'>Asistencias de Tardanzas</th>
            <th scope='col' bgcolor='#239B56'>Horas Realizadas Totales</th>
        </thead>
        <tbody>
            <?php
            $current_week = date('W');
            $current_year = date('Y');
            $current_date = date('Y-m-d');
            $current_date >= '2023-03-24'
                ? $add_time = '00:05:00'
                : $add_time = '00:15:00';
            $negocio = $_GET['negocio'];
            $sql = "SELECT attendance.*, employees.*, negocio.*, position.*, employees.employee_id AS empid,
                        CASE WHEN ADDTIME(schedules.time_in, '$add_time') >= attendance.time_in THEN 1
                            WHEN ADDTIME(schedules.time_in, '$add_time') <= attendance.time_in THEN 0
                        END AS status_v1, attendance.id AS attid
                        FROM attendance
                        RIGHT JOIN employees ON employees.id = attendance.employee_id
                        LEFT JOIN position ON position.id = employees.position_id
                        LEFT JOIN negocio ON negocio.id = employees.negocio_id
                        LEFT JOIN schedules ON schedules.id = employees.schedule_id
                        WHERE negocio.nombre_negocio = '$negocio' AND YEAR(attendance.date) = $current_year AND WEEK(attendance.date) = $current_week
                        ORDER BY attendance.date DESC, attendance.time_in DESC";
            $query = $conn->query($sql);
            $attendance_count = array();
            $total_num_hr = array();

            while ($row = $query->fetch_assoc()) {
                $employee_id = $row['employee_id'];
                if (isset($attendance_count[$employee_id])) {
                    if ($row['status_v1'] == 1) {
                        $attendance_count[$employee_id]['ontime']++;
                    } else {
                        $attendance_count[$employee_id]['late']++;
                    }
                    $total_num_hr[$employee_id] += $row['num_hr'];
                } else {
                    $attendance_count[$employee_id] = array(
                        'ontime' => 0,
                        'late' => 0,
                        'descripcion' => $row['description'],
                        'nombre_negocio' => $row['nombre_negocio'],
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'num_hr' => $row['num_hr']
                    );
                    if ($row['status_v1'] == 1) {
                        $attendance_count[$employee_id]['ontime'] = 1;
                    } else {
                        $attendance_count[$employee_id]['late'] = 1;
                    }
                    $total_num_hr[$employee_id] = $row['num_hr'];
                }
            }

            foreach ($attendance_count as $employee_id => $attendance) {
                echo "<tr>";
                echo "<td>" . $attendance['firstname'] . " " . $attendance['lastname'] . "</td>";
                echo "<td>" . $attendance['descripcion'] . "</td>";
                echo "<td>" . $attendance['nombre_negocio'] . "</td>";
                echo "<td>" . $attendance['ontime'] . "</td>";
                echo "<td>" . $attendance['late'] . "</td>";
                echo "<td>" . number_format($total_num_hr[$employee_id], 2) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <h2>Control de Asistencia</h2>
    <table border='1' id="example1 border-collapse: separate">
        <thead>
            <th scope='col' bgcolor='#00B0F0'>Nombre y Apellido</th>
            <th scope='col' bgcolor='#EB7A1D'>Codigo de Asistencia</th>
            <th scope='col' bgcolor='#FF66FF'>Unidad de Negocio</th>
            <th scope='col' bgcolor='#9966FF'>Area</th>
            <th scope='col' bgcolor='#92D050'>Asistencias a Tiempo</th>
            <th scope='col' bgcolor='#00FF99'>Asistencias de Tardanzas</th>
            <th scope='col' bgcolor='#239B56'>Horas Realizadas Totales</th>
        </thead>
        <tbody>
            <?php
            $negocio = $_GET['negocio'];
            $current_date = date('Y-m-d');
            $current_date >= '2023-03-24'
                ? $add_time = '00:05:00'
                : $add_time = '00:15:00';
            $sql = "SELECT attendance.*, employees.*, negocio.*, position.*, employees.employee_id AS empid,
                        CASE WHEN ADDTIME(schedules.time_in, '$add_time') >= attendance.time_in THEN 1
                            WHEN ADDTIME(schedules.time_in, '$add_time') <= attendance.time_in THEN 0
                        END AS status_v1, attendance.id AS attid
                        FROM attendance
                        RIGHT JOIN employees ON employees.id = attendance.employee_id
                        LEFT JOIN position ON position.id = employees.position_id
                        LEFT JOIN negocio ON negocio.id = employees.negocio_id
                        LEFT JOIN schedules ON schedules.id = employees.schedule_id
                        WHERE negocio.nombre_negocio = '$negocio'
                        ORDER BY attendance.date DESC, attendance.time_in DESC";
            $query = $conn->query($sql);
            $attendance_count = array();
            $total_num_hr = array();

            while ($row = $query->fetch_assoc()) {
                $employee_id = $row['employee_id'];
                if (isset($attendance_count[$employee_id])) {
                    $row['status_v1'] == 1
                        ? $attendance_count[$employee_id]['ontime']++
                        : $attendance_count[$employee_id]['late']++;
                    $total_num_hr[$employee_id] += $row['num_hr'];
                } else {
                    $attendance_count[$employee_id] = array(
                        'ontime' => 0,
                        'late' => 0,
                        'descripcion' => $row['description'],
                        'nombre_negocio' => $row['nombre_negocio'],
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'num_hr' => $row['num_hr']
                    );
                    $row['status_v1'] == 1
                        ? $attendance_count[$employee_id]['ontime'] = 1
                        : $attendance_count[$employee_id]['late'] = 1;
                    $total_num_hr[$employee_id] = $row['num_hr'];
                }
            }

            foreach ($attendance_count as $employee_id => $attendance) {
                echo "<tr>";
                echo "<td>" . $attendance['firstname'] . " " . $attendance['lastname'] . "</td>";
                echo "<td>" . $employee_id . "</td>";
                echo "<td>" . $attendance['descripcion'] . "</td>";
                echo "<td>" . $attendance['nombre_negocio'] . "</td>";
                echo "<td>" . $attendance['ontime'] . "</td>";
                echo "<td>" . $attendance['late'] . "</td>";
                isset($total_num_hr[$employee_id])
                    ? $total = number_format($total_num_hr[$employee_id], 2)
                    : $total = 0;
                echo "<td>" . $total . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>