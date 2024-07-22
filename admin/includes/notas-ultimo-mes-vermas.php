<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mes_a_mostrar = $_POST['mes_a_mostrar'];
    $employee_id = $_POST['employee_id'];
}
setlocale(LC_TIME, 'es_ES.UTF-8');

$meses_en_espanol = array(
    'January' => 'ENERO',
    'February' => 'FEBRERO',
    'March' => 'MARZO',
    'April' => 'ABRIL',
    'May' => 'MAYO',
    'June' => 'JUNIO',
    'July' => 'JULIO',
    'August' => 'AGOSTO',
    'September' => 'SEPTIEMBRE',
    'October' => 'OCTUBRE',
    'November' => 'NOVIEMBRE',
    'December' => 'DICIEMBRE',
);

include 'includes/conn.php';
$employeeId = $row['id'];

$sql_last_month = "SELECT MAX(fecha_fin_semana) AS last_month FROM grades WHERE employee_id = $employeeId";
$result_last_month = $conn->query($sql_last_month);
$last_month_row = $result_last_month->fetch_assoc();
$last_month = $last_month_row['last_month'];

$primer_dia_mes_actual = date('Y-m-01', strtotime($last_month));
$primer_dia_mes_siguiente = date('Y-m-01', strtotime('+1 month', strtotime($last_month)));

// Filtrar por el mes de julio
$primer_dia_mes_a_mostrar = date('Y-m-01', strtotime(date('Y') . '-' . $mes_a_mostrar . '-1'));
$ultimo_dia_mes_a_mostrar = date('Y-m-t', strtotime(date('Y') . '-' . $mes_a_mostrar . '-1'));

$sql = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana >= '$primer_dia_mes_a_mostrar' AND fecha_fin_semana <= '$ultimo_dia_mes_a_mostrar' ORDER BY fecha_fin_semana ASC";
$result = $conn->query($sql);

$notas_por_semana = array();
$mes = '';

if ($result->num_rows > 0) {
    $semana_actual = null;

    while ($row1 = $result->fetch_assoc()) {
        $semana = date('W', strtotime($row1['fecha_fin_semana']));
        $mes = $meses_en_espanol[strftime('%B', strtotime($row1['fecha_fin_semana']))];

        if ($semana != $semana_actual) {
            $notas_por_semana[$semana] = array(
                'criterio_1' => array(),
                'criterio_2' => array(),
                'criterio_3' => array(),
                'fecha_promedio' => $row1['fecha_fin_semana'],
                'nombre_mes' => $mes,
            );

            $semana_actual = $semana;
        }

        if ($row1["id_criterio"] == 1) {
            $notas_por_semana[$semana]['criterio_1'][] = $row1["nota"];
        } elseif ($row1["id_criterio"] == 2) {
            $notas_por_semana[$semana]['criterio_2'][] = $row1["nota"];
        } elseif ($row1["id_criterio"] == 3) {
            $notas_por_semana[$semana]['criterio_3'][] = $row1["nota"];
        }
    }
} else {
    echo "No se encontraron notas para el mes de julio.";
}


$query = "SELECT 
            DATE_FORMAT(`fecha_fin_semana`, '%Y-%m-%d') AS week_date,
            AVG(`nota`) AS average_grade
          FROM
            `grades`
          WHERE
            `employee_id` = $employeeId
          GROUP BY
            week_date
          ORDER BY
            week_date";

$result2 = $conn->query($query);

$notaCounter = 1; // Inicializar notaCounter con el valor de inicio

/*if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
      $semana = explode("-",$row["week_date"]);
        if ($semana[1]== $mes_a_mostrar) {
         echo "semana $notaCounter - Promedio de nota: " . $row["average_grade"] . "<br>";
        }
        $notaCounter++;
    }
} else {
    echo "No se encontraron resultados para el historial de notas.";
}*/
$conn->close();
?>