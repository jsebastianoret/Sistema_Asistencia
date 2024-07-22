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

$sql_distinct_months = "SELECT DISTINCT DATE_FORMAT(fecha_fin_semana, '%Y-%m-01') AS month FROM grades WHERE employee_id = $employeeId ORDER BY month ASC";
$result_distinct_months = $conn->query($sql_distinct_months);

if ($result_distinct_months->num_rows > 0) {
    while ($row_month = $result_distinct_months->fetch_assoc()) {
        $mes_actual = $row_month['month'];

        $primer_dia_mes_actual = date('Y-m-01', strtotime($mes_actual));
        $primer_dia_mes_siguiente = date('Y-m-01', strtotime('+1 month', strtotime($mes_actual)));

        $sql = "SELECT * FROM grades WHERE employee_id = $employeeId AND fecha_fin_semana >= '$primer_dia_mes_actual' AND fecha_fin_semana < '$primer_dia_mes_siguiente' ORDER BY fecha_fin_semana ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $notas_por_semana = array();
            $semana_actual = null;
            $semanaN = 1;
            $fecha_inicio_semana = null;
            $fecha_fin_semana = null;

            while ($row1 = $result->fetch_assoc()) {
                $semana = date('W', strtotime($row1['fecha_fin_semana']));

                if ($semana != $semana_actual) {
                    if ($fecha_inicio_semana === null) {
                        $fecha_inicio_semana = $row1['fecha_inicio_semana'];
                    }
                    $fecha_fin_semana = $row1['fecha_fin_semana'];

                    $notas_por_semana[$semana] = array(
                        'criterio_1' => array(),
                        'criterio_2' => array(),
                        'criterio_3' => array(),
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

            $promedios_semanales = array();
            foreach ($notas_por_semana as $semana => $notas) {
                $promedioNota1 = count($notas['criterio_1']) > 0 ? round(array_sum($notas['criterio_1']) / count($notas['criterio_1']), 0) : '-';
                $promedioNota2 = count($notas['criterio_2']) > 0 ? round(array_sum($notas['criterio_2']) / count($notas['criterio_2']), 0) : '-';
                $promedioNota3 = count($notas['criterio_3']) > 0 ? round(array_sum($notas['criterio_3']) / count($notas['criterio_3']), 0) : '-';
                $promedioSemanal = $promedioNota1 !== '-' && $promedioNota2 !== '-' && $promedioNota3 !== '-' ? round(($promedioNota1 + $promedioNota2 + $promedioNota3) / 3, 1) : '-';

                $promedios_semanales[] = $promedioSemanal;
            }

            $promedioMensual = count($promedios_semanales) > 0 ? round(array_sum($promedios_semanales) / count($promedios_semanales), 0) : '-';

            $mes = $meses_en_espanol[date('F', strtotime($mes_actual))];

            $circlebar = (round($promedioMensual, 0) * 360) / 20;
            $fechaInicioMes = $fecha_inicio_semana;
            $parts = explode("-", $fechaInicioMes);
            $fechaFinMes = $fecha_fin_semana;
            $parts2 = explode("-", $fechaFinMes);

            $dicSemanaN = 1;
            $sumaNotas = 0; // Inicializar la suma de notas
            foreach ($promedios_semanales as $promedio_semanal) {
                $barDinamic = (round($promedio_semanal, 0) * 100) / 20;
                if ($barDinamic > 100) {
                    $barDinamic = 100;
                }

                if (round($promedio_semanal, 0) >= 0 && round($promedio_semanal, 0) <= 10) {
                    $barDinamic = $barDinamic / 2;
                    $colorBar = '#FF0000';
                } elseif (round($promedio_semanal, 0) >= 11 && round($promedio_semanal, 0) <= 14) {
                    $colorBar = '#FF9900';
                    $barDinamic = $barDinamic / 1.4;
                } elseif (round($promedio_semanal, 0) >= 15 && round($promedio_semanal, 0) <= 17) {
                    $colorBar = '#69C736';
                    $barDinamic = $barDinamic / 1.15;
                } elseif (round($promedio_semanal, 0) >= 18) {
                    $colorBar = '#1E4DA9';
                }
                $sumaNotas += round($promedio_semanal, 0);
            }

            // Mostrar la suma de todas las notas
            if ($promedioTotal >= 5 && $promedioTotal < 10) {
                echo '<div class="circle-logro" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/bronce-insignia.webp"></img></div>';
            } elseif ($promedioTotal >= 10 && $promedioTotal < 15) {
                echo '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/plata-insignia_1.webp"></div>';
            } elseif ($promedioTotal >= 15 && $promedioTotal < 20) {
                echo '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/oro-insignia_1.webp"></div>';
            } elseif ($promedioTotal >= 20) {
                echo '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/maxima-insignia.webp"></div>';
            } else {
                echo '';
            }

        } else {
            echo "";
        }
    }
} else {
    echo '';
}

$conn->close();
?>