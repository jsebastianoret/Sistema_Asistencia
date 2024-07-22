<?php
if (isset($_GET['id'])) {
    include 'conn.php';
    $id = $_GET['id'];

    $sql_select = "SELECT imagen_url FROM eventos2 WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $stmt_select->bind_result($imagen_url);
    $stmt_select->fetch();
    $stmt_select->close();

    $ruta_imagen = '../../img-eventos/' . $imagen_url;

    $sql_delete = "DELETE FROM eventos2 WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }

        header("Location: ../programacion-eventos.php");
        exit();
    } else {
        echo "Error al eliminar el registro: " . $stmt_delete->error;
    }
    $stmt_delete->close();

    $conn->close();
} else {
    echo "ID de registro no proporcionado.";
}
?>








<?php
include "includes/conn.php";

$employee_id = $row['id'];

$sqlHr = "WITH RECURSIVE Fechas AS (
    SELECT date_in AS fecha FROM employees WHERE id = ?
    UNION ALL
    SELECT fecha + INTERVAL 1 DAY
    FROM Fechas
    WHERE fecha < (CASE
    	WHEN (SELECT date_out FROM employees WHERE id = ?) > CURRENT_DATE THEN CURRENT_DATE
    	ELSE (SELECT date_out FROM employees WHERE id = ?)
    END)
    )

    SELECT COUNT(*) AS num_faltas
    FROM (
        SELECT f.fecha, a.employee_id, a.date
        FROM Fechas f
        LEFT JOIN attendance a
        ON f.fecha = a.date AND a.employee_id = ?
        WHERE WEEKDAY(f.fecha) BETWEEN 0 AND 5 ORDER BY f.fecha
    ) AS subconsulta
    WHERE date IS NULL";
$stmtHr = $conn->prepare($sqlHr);
$stmtHr->bind_param("iiii", $employee_id, $employee_id, $employee_id, $employee_id);
$stmtHr->execute();
$resultHr = $stmtHr->get_result();

if ($resultHr->num_rows > 0) {
    $rowHr = $resultHr->fetch_assoc();
    $num_faltas = $rowHr["num_faltas"];
} else {
    echo "No se encontraron registros para employee_id = " . $employee_id;
}

$percentage = $num_faltas;
$totalDeg = 10 / 100;
$CircularDeg = $percentage / $totalDeg;
$percentageDeg = 100 - $CircularDeg;

$stmtHr->close();
$conn->close();
?>