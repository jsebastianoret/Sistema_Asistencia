<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
  $employee_id = $_POST['employee_id'];

  $sql = "CREATE TEMPORARY TABLE temp_fechas(fecha DATE);

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
    
    //Faltas justificadas
    $sql2 = "SELECT COUNT(*) as numero_faltas_justificadas FROM faltas_justificadas WHERE employee_id= $employee_id;";
    $query = $conn->query($sql2);
    $row = $query->fetch_assoc();
    $faltas_justificadas = $row['numero_faltas_justificadas'];
    
    $num_faltas = 0;

    if ($conn->multi_query($sql)) {
        do {
            /* almacenar resultado de la primera consulta */
            if ($resultado = $conn->store_result()) {
                $rowHr = $resultado->fetch_assoc();
                $num_faltas = $rowHr["num_faltas"];
                $resultado->free_result();
            }
        } while ($conn->more_results() && $conn->next_result());
    }

    $faltas_injustificadas = $num_faltas - $faltas_justificadas;

  echo json_encode(['faltas_injustificadas' => $faltas_injustificadas, 'faltas_justificadas' => $faltas_justificadas]);
 
}




?>