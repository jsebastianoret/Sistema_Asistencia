<?php
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

$sql = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana >= '$primer_dia_mes_actual' AND fecha_fin_semana < '$primer_dia_mes_siguiente' ORDER BY fecha_fin_semana ASC";
$result = $conn->query($sql);

$notas_por_semana = array();
$mes = '';

if ($result->num_rows > 0) {
    $semana_actual = null;

    while ($row1 = $result->fetch_assoc()) {
        $semana = date('W', strtotime($row1['fecha_fin_semana']));
        $mes = $meses_en_espanol[date('F', strtotime($row1['fecha_fin_semana']))];

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
    echo "";
}

$conn->close();
?>