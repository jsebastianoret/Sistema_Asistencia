<?php include 'includes/header-practicante.php'; ?>
<?php include 'includes/notas-ultimo-mes-vermas.php' ?>
<?php
$sumaPromedios = 0;
$cantidadSemanas = 0;
$promedioTotal = 0;

foreach ($notas_por_semana as $semana => $notas) {
   $promedioNota1 = count($notas['criterio_1']) > 0 ? round(array_sum($notas['criterio_1']) / count($notas['criterio_1']), 0) : '-';
   $promedioNota2 = count($notas['criterio_2']) > 0 ? round(array_sum($notas['criterio_2']) / count($notas['criterio_2']), 0) : '-';
   $promedioNota3 = count($notas['criterio_3']) > 0 ? round(array_sum($notas['criterio_3']) / count($notas['criterio_3']), 0) : '-';
   $promedioSemanal = $promedioNota1 !== '-' && $promedioNota2 !== '-' && $promedioNota3 !== '-' ? round(($promedioNota1 + $promedioNota2 + $promedioNota3) / 3, 1) : '-';
   $fecha_inicio_semana = date('Y-m-d', strtotime('monday this week', strtotime($notas['fecha_promedio'])));
   $fecha_fin_semana = date('Y-m-d', strtotime('sunday this week', strtotime($notas['fecha_promedio'])));
   $fecha_inicio_semana_format = date('d/m/Y', strtotime($fecha_inicio_semana));
   $fecha_fin_semana_format = date('d/m/Y', strtotime($fecha_fin_semana));

   if ($promedioSemanal !== '-') {
      $sumaPromedios += $promedioSemanal;
      $cantidadSemanas++;
   }
}

if ($cantidadSemanas > 0) {
   $promedioTotal = round($sumaPromedios / $cantidadSemanas, 1);
} else {
   echo "";
}
?>
<?php include 'includes/logros-medallas.php' ?>

<body class="bg-white">
   <?php $estadisticas_click = "clicked" ?>
   <?php include 'includes/fecha_actual.php' ?>
   <?php include 'includes/navbar-sidebar-practicante.php' ?>

   <?php if (isset($row['employee_id'])) { ?>
      <div class="container-fluid" id="grid-estadistica-general">
         <div>
            <!-- PROGRESO LOGROS INICIO -->
            <div class="card" id="logros-semanal">
               <div class="circle-logro-semanal-1"></div>
               <div class="line-logro-semanal-1"></div>
               <div class="line-logro-semanal-1-1" style="width: <?php echo $barraMedalla ?>px;"></div>
               <div class="circle-logro-semanal-2" style="<?php echo $colorcircle ?>"><img class="insignia-logro"
                     src="../img/bronce-insignia.webp"></div>
               <div class="line-logro-semanal-2"></div>
               <div class="line-logro-semanal-2-1" style="width: <?php echo $barraMedalla2 ?>px;"></div>
               <div class="circle-logro-semanal-3" style="<?php echo $colorcircle2 ?>"><img class="insignia-logro"
                     src="../img/plata-insignia_1.webp"></div>
               <div class="line-logro-semanal-3"></div>
               <div class="line-logro-semanal-3-1" style="width: <?php echo $barraMedalla3 ?>px;"></div>
               <div class="circle-logro-semanal-4" style="<?php echo $colorcircle3 ?>"><img class="insignia-logro"
                     src="../img/oro-insignia_1.webp"></div>
               <div class="line-logro-semanal-4"></div>
               <div class="line-logro-semanal-4-1" style="width: <?php echo $barraMedalla4 ?>px;"></div>
               <div class="circle-logro-semanal-5" style="<?php echo $colorcircle4 ?>"><img class="insignia-logro"
                     src="../img/maxima-insignia.webp"></div>
            </div>
            <!-- PROGRESO LOGROS FIN -->
            <!-- BOTONES DE NAVEGACIÓN INICIO -->
            <div class="buttons-estadistica">
               <form method="post" action="estadisticas-y-logros-practicante.php"
                  class="form__calendar calendar-button-color">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="GENERAL" class="btn__calendar letraNavBar letraNavBar text-light">
               </form>
               <form method="post" action="estadisticas-logros-ultimo-mes.php" class="form__calendar ">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="ÚLTIMO MES" class="btn__calendar--active letraNavBar text-light ">
               </form>
               <form method="post" action="estadisticas-logros-ultima-semana.php"
                  class="form__calendar calendar-button-color">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="ÚLTIMA SEMANA" class="btn__calendar letraNavBar text-light">
               </form>
            </div>
            <!-- BOTONES DE NAVEGACIÓN FIN -->
            <!-- RESUMEN SEMANAL INICIO -->
            <div class="statistics">


               <div class="weekly-summary">
                  <div>
                     <p class="summary-month letraNavBar">RESUMEN SEMANAL
                        <?php echo ucfirst($mes) ?>
                     </p>
                  </div>
                  <div class="grid">

                     <?php
                     $semanaN = 1;
                     foreach ($notas_por_semana as $semana => $notas) {
                        $promedioNota1 = count($notas['criterio_1']) > 0 ? round(array_sum($notas['criterio_1']) / count($notas['criterio_1']), 0) : '-';
                        $promedioNota2 = count($notas['criterio_2']) > 0 ? round(array_sum($notas['criterio_2']) / count($notas['criterio_2']), 0) : '-';
                        $promedioNota3 = count($notas['criterio_3']) > 0 ? round(array_sum($notas['criterio_3']) / count($notas['criterio_3']), 0) : '-';
                        $promedioSemanal = $promedioNota1 !== '-' && $promedioNota2 !== '-' && $promedioNota3 !== '-' ? round(($promedioNota1 + $promedioNota2 + $promedioNota3) / 3, 1) : '-';

                        echo '
                        <div class="container-week">
                           <div class="week-number letraNavBar">Semana ';


                        while ($row2 = $result2->fetch_assoc()) {
                           $semana = explode("-", $row2["week_date"]);
                           if ($semana[1] == $mes_a_mostrar) {
                              echo "$notaCounter";
                              $notaCounter++;
                              break;
                           }
                           $notaCounter++;
                        }

                        echo '</div>
                           <div class="card">
                              <div class="card-title">
                                    <div class="card-title-text">
                                       <p class="letraNavBar">Estadísticas de desempeño</p>
                                       <span class="letraNavBar">Última semana</span>
                                    </div>
                                    <img src="../img/exclamacion.png" alt="mas información" />
                              </div>
                              <hr class="card-divider" style="border:none; border-top: 2px solid #1e4da9; opacity: 1;" />
                              <div id="flower-graphic">
                                    <div id="flower-body">
                                       <div>
                                          <h3 class="letraNavBar text-light estatics-nota-flower1">' . $promedioNota2 . '</h3>
                                          <div class="estatics-flower-body-1">
                                                <div class="estatics-petal-1-1"></div>
                                                <div class="estatics-petal-1-2"></div>
                                                <div class="estatics-petal-1-3"></div>
                                          </div>
                                       </div>
                                       <div>
                                          <h3 class="letraNavBar text-light estatics-nota-flower2">' . $promedioNota1 . '</h3>
                                          <div class="estatics-flower-body-2">
                                                <div class="estatics-petal-2-1"></div>
                                                <div class="estatics-petal-2-2"></div>
                                                <div class="estatics-petal-2-3"></div>
                                          </div>
                                       </div>
                                       <div>
                                          <h3 class="letraNavBar text-light estatics-nota-flower3">' . $promedioNota3 . '</h3>
                                          <div class="estatics-flower-body-3">
                                                <div class="estatics-petal-3-1"></div>
                                                <div class="estatics-petal-3-2"></div>
                                                <div class="estatics-petal-3-3"></div>
                                          </div>
                                       </div>
                                    </div>
                                    <div id="graph-legend">
                                       <div class="d-flex legend card-summary-legend">
                                          <div class="square-legend-1 "></div>
                                          <p class="letraNavBar colorletraperfil letra-size-legend">Aspectos Individuales</p>
                                       </div>
                                       <div class="d-flex legend card-summary-legend">
                                          <div class="square-legend-2"></div>
                                          <p class="letraNavBar colorletraperfil letra-size-legend">Aspectos Grupales</p>
                                       </div>
                                       <div class="d-flex legend card-summary-legend">
                                          <div class="square-legend-3"></div>
                                          <p class="letraNavBar colorletraperfil letra-size-legend">Aspectos profesionales</p>
                                       </div>
                                    </div>
                              </div>
                              <div class="card-footer-estats">
                                    <div class="card-footer-estats-average letraNavBar">Promedio = ' . $promedioSemanal . '</div>
                                    <form method="post" action="estadisticas-logros-ultima-semana-vermas.php" class="form_ver-mas">
                                       <input type="hidden" name="semanN" value="' . ($notaCounter - 1) . '">
                                       <input type="hidden" name="mes_a_mostrar" value="' . $notas['fecha_promedio'] . '">
                                       <input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">
                                       <button type="submit" class="enlaces__btn" id="button1">
                                          <div class="card-footer-estats-more letraNavBar">Ver más>></div>
                                       </button>
                                    </form>
                              </div>
                           </div>
                        </div>
                        ';
                        $semanaN++;
                     }
                     ?>
                  </div>
               </div>
            </div>
            <!-- RESUMEN SEMANAL FIN -->
         </div>
         <div class="card" id="logros-obtenidos-practicante">
            <h6 class="letraNavBar colorletraperfil">LOGROS</h6>
            <div>
               <div class="circle-logros-a-obtener-1" style="<?php echo $colorcircle ?>"><img
                     src="../img/bronce-insignia.webp"></div>
               <p class="letraNavBar colorletraperfil">
                  <?php echo $obtenido ?>
               </p>
               <div class="circle-logros-a-obtener-2" style="<?php echo $colorcircle2 ?>"><img
                     src="../img/plata-insignia_1.webp"></div>
               <p class="letraNavBar colorletraperfil">
                  <?php echo $obtenido2 ?>
               </p>
               <div class="circle-logros-a-obtener-3" style="<?php echo $colorcircle3 ?>"><img
                     src="../img/oro-insignia_1.webp"></div>
               <p class="letraNavBar colorletraperfil">
                  <?php echo $obtenido3 ?>
               </p>
               <div class="circle-logros-a-obtener-4" style="<?php echo $colorcircle4 ?>"><img
                     src="../img/maxima-insignia.webp"></div>
               <p class="letraNavBar colorletraperfil">
                  <?php echo $obtenido4 ?>
               </p>
            </div>
         </div>
      </div>

      <?php
   } else {
      echo "";
   }
   ?>
   <script>
      let idPracticante = document.getElementById("idPracticante");
      if (idPracticante.value.length == 0) {
         window.location.href = "../index.php";
      }
   </script>
   <script>
      function salirMiPerfil() {
         Swal.fire({
            title: '¿Estás seguro de que quieres salir de tu perfil?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Salir de perfil'
         }).then((result) => {
            if (result.isConfirmed) {
               window.location.href = "../index.php";
            }
         })
      }
   </script>
   <script>
      function toggleButtonColor(event, buttonId) {
         event.preventDefault();
         const buttons = document.getElementsByClassName("enlaces");
         for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("clicked");
         }
         const button = document.getElementById(buttonId);
         button.classList.add("clicked");
      }
   </script>
</body>