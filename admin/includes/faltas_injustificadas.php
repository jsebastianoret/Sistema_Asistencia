<?php
include "includes/conn.php";

$employee_id = $row['id'];

$sqlHr = "CREATE TEMPORARY TABLE temp_fechas(fecha DATE);

    -- Obtener las fechas de entrada y salida en variables
    SET @current_date = (SELECT date_in FROM employees WHERE id = '$employee_id');
    SET @date_out = (SELECT CASE
                                WHEN date_out > CURRENT_DATE
                                THEN CURRENT_DATE
                                ELSE date_out
                            END AS date_out
                    FROM employees WHERE id = '$employee_id');

    -- Insertar fechas en la tabla temporal
    INSERT INTO temp_fechas(fecha)
    SELECT DATE_ADD(@current_date, INTERVAL n DAY)
    FROM (
        SELECT n
        FROM (
            SELECT a.N + b.N * 10 AS n
            FROM (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
                (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 					UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14) b
        ) numbers
        WHERE DATE_ADD(@current_date, INTERVAL n DAY) <= STR_TO_DATE(@date_out, '%Y-%m-%d') AND DATE_ADD(@current_date, INTERVAL n DAY) NOT IN ('2023-11-01', '2023-12-08', '2023-12-09', '2023-12-25', '2024-01-01', '2024-02-20', '2024-03-28', '2024-03-29', '2024-05-01', '2024-05-30', '2024-06-24', '2024-06-29', '2024-07-29', '2024-08-30', '2024-10-8', '2024-11-01', '2024-12-25')
    ) dates;

    -- Obtener el número de faltas
    SELECT COUNT(*) AS num_faltas
    FROM (
        SELECT f.fecha, a.employee_id, a.date
        FROM temp_fechas f
        LEFT JOIN attendance a
        ON f.fecha = a.date AND a.employee_id = '$employee_id'
        WHERE WEEKDAY(f.fecha) BETWEEN 0 AND 5 ORDER BY f.fecha
    ) AS subconsulta
    WHERE date IS NULL;";

if ($conn->multi_query($sqlHr)) {
    do {
        /* almacenar resultado de la primera consulta */
        if ($resultado = $conn->store_result()) {
            $rowHr = $resultado->fetch_assoc();
            $num_faltas = $rowHr["num_faltas"];
            $resultado->free_result();
        }
    } while ($conn->more_results() && $conn->next_result());
}

// $conn->query("CREATE TEMPORARY TABLE temp_fechas (fecha DATE)");

// $current_date = $conn->query("SELECT date_in FROM employees WHERE id = '$employee_id'")->fetch_assoc()['date_in'];
// $date_out = $conn->query("SELECT
//     CASE
//         WHEN date_out > CURRENT_DATE THEN CURRENT_DATE
//         ELSE date_out
//     END
//     AS date_out
//     FROM employees WHERE id = '$employee_id'")->fetch_assoc()['date_out'];

// $conn->query("INSERT INTO temp_fechas (fecha)
// SELECT DATE_ADD('$current_date', INTERVAL n DAY)
// FROM (
//     SELECT n
//     FROM (
//         SELECT a.N + b.N * 10 + c.N * 100 AS n
//         FROM (
//             SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
//         ) a,
//         (
//             SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
//         ) b,
//         (
//             SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
//         ) c
//     ) numbers
//     WHERE DATE_ADD('$current_date', INTERVAL n DAY) <= '$date_out'
// ) dates");

// $resultHr = $conn->query("SELECT COUNT(*) AS num_faltas
//     FROM (
//         SELECT f.fecha, a.employee_id, a.date
//         FROM temp_fechas f
//         LEFT JOIN attendance a
//         ON f.fecha = a.date AND a.employee_id = '$employee_id'
//         WHERE WEEKDAY(f.fecha) BETWEEN 0 AND 5 ORDER BY f.fecha
//     ) AS subconsulta
//     WHERE date IS NULL");

// $rowHr = $resultHr->fetch_assoc();
// $num_faltas = $rowHr['num_faltas'];

$percentage = $num_faltas;
$totalDeg = 10 / 100;
$CircularDeg = $percentage / $totalDeg;
$percentageDeg = 100 - $CircularDeg;

$conn->close();
?>