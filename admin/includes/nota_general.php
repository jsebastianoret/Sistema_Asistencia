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


         echo '
               <div class="card_contend-estadisticas">
                  <div class="card card-color" id="estadistica-desempeño-1">
                     <h6 class="letraNavBar text-light text-center">Estadísticas de desempeño</h6>
                     <hr style="border: none; border-top: 2px solid white; opacity: 1; margin-bottom: 28px;">
                     <div class="d-flex">
                        <div>
                           <h3 class="letraNavBar text-light mes__notas">' . ucfirst($mes) . '</h3>
                           <p class="letraNavBar text-light mes__notas-mes">' . $parts[2] . '/' . $parts[1] . ' al ' . $parts2[2] . '/' . $parts2[1] . '</p>
                        </div>
                        <div class="progress-circular-desempeño" style="background: conic-gradient(#00d7c9 ' . $circlebar . 'deg, #1e4da9 0deg);">
                           <div class="circular-progress-desempeño">
                              <div class="letraNavBar value-desempeño-1 text-light">' . round($promedioMensual, 0) . '</div>
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="card" id="resumen-estadistica-1">
                     <div class="title-estadistica d-flex">
                        <p class="colorletraperfil letraNavBar">RESUMEN TOTAL DE ' . ucfirst($mes) . '</p>
                        <img class="img-exclamacion" src="../img/exclamacion.png" alt="mas información" />
                     </div>
                     <hr style="margin-bottom: 0px; border: none; border-top: 2px solid #1e4da9; opacity: 1;">
                     <div class="grafico-barra">
                        <div class="intervals">
                           <div class="div_bar-1"></div>
                           <p class="colorletraperfil letraNavBar">18-20</p>
                           <div class="div_bar-2"></div>
                           <p class="colorletraperfil letraNavBar">15-17</p>
                           <div class="div_bar-3"></div>
                           <p class="colorletraperfil letraNavBar">11-14</p>
                           <div class="div_bar-4"></div>
                           <p class="colorletraperfil letraNavBar">0-10</p>
                        </div>
                        <div class="bars__conted2">';
         $dicSemanaN = 1;
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

            echo '<div class="bar" style="height: ' . $barDinamic . '%; background-color: ' . $colorBar . ';"><p class="letraNavBar">' . round($promedio_semanal, 0) . '</p></div>                  
                              ';
         }
         echo '<div class="interval-rect-1"></div>
                              <div class="interval-rect-2"></div>
                              <div class="interval-rect-3"></div>  
                              <div class="interval-rect-4"></div>
                        </div>
                     </div>
                     <form method="post" action="estadisticas-logros-ultimo-mes-vermas.php" class="form_ver-mas">
                        <input type="hidden" name="mes_a_mostrar" value="' . $parts2[1] . '">
                        <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
                        <button type="submit" class="enlaces__btn" id="button1">
                           <div class="ver-mas-estadistica">
                                 <a class="letraNavBar ver-estadistica-general">Ver más >></a>
                           </div>
                        </button>
                     </form>
                  </div>
               </div>
               ';

      } else {
         echo "No se encontraron resultados para el mes de " . ucfirst($mes) . ".<br><br>";
      }
   }
} else {
   echo '';
}

$conn->close();
?>