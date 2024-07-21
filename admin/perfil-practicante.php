<?php include 'includes/header-practicante.php'; ?>
<?php include 'includes/notas-logros-ultimo-mes.php' ?>
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
}
?>

<body class="bg-white">
   <?php $perfil_click = "clicked" ?>
   <?php include 'includes/fecha_actual.php' ?>
   <?php include 'includes/navbar-sidebar-practicante.php' ?>

   <div class="container-fluid d-flex align-items-start gap-5" id="grid-perfil">
      <div class="d-flex flex-column gap-4">
         <div class="d-flex estilo-card-perfil" id="perfil">
            <div class="tarjeta-perfil">
               <div class="target-perfil">
                  <?php
                  $cadena = $row['firstname'];
                  $separador = " ";
                  $array = explode($separador, $cadena);
                  ?>
                  <h2 class="letraNavBar colorletraperfil">
                     <?php
                     if ($row['gender'] == 'Female') {
                        echo 'Bienvenida, ';
                     } else {
                        echo 'Bienvenido, ';
                     }
                     ?>
                     <?php echo $array[0]; ?>
                  </h2>
                  <p class="letraNavBar colorletraperfil  text-wraper">Aquí encontrarás información necesaria sobre tus
                     estadísticas y desempeño.</p>
               </div>
               <div class="d-flex perfil-presentacion">
                  <h6 class="letraNavBar  colorletraperfil fw-normal" style="margin-left: 30px;">
                     <?php echo $row['position']; ?>
                  </h6>
                  <h6 class="letraNavBar colorletraperfil fw-normal tipo-job" style="margin-left: 70px;">
                     <?php echo $row['type_practice']; ?>
                  </h6>
               </div>
               <h6 class="letraNavBar perfil-presentacion2 colorletraperfil fw-normal" style="margin-left: 30px;">
                  <?php echo $row['negocio']; ?>
               </h6>
               <div class="d-block perfil-contrato">
                  <div class="horarios">
                     <h6 class="letraNavBar diseñoFechaIngreso">Ingreso:</h6>
                     <div class="ps-1 d-flex contenedor-fecha ms-2">
                        <?php
                        $cadena2 = $row['date_in'];
                        $separador2 = "-";
                        $array2 = explode($separador2, $cadena2);
                        ?>
                        <h6 class="letraNavBar posicion-border3 diseñofecha text-center">
                           <?php echo $array2[2]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border1 diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array2[1]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border2 diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array2[0][2] . $array2[0][3]; ?>
                        </h6>
                     </div>
                     <h6 class="letraNavBar diseñoFechaSalida">Salida:</h6>
                     <div class="ps-1 d-flex contenedor-fecha ms-2">
                        <?php
                        $cadena3 = $row['date_out'];
                        $separador3 = "-";
                        $array3 = explode($separador3, $cadena3);
                        ?>
                        <h6 class="letraNavBar posicion-border3  diseñofecha text-center">
                           <?php echo $array3[2]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border1  diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array3[1]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border2  diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array3[0][2] . $array3[0][3]; ?>
                        </h6>
                     </div>
                     <h6 class="letraNavBar diseñoFechaSalida">Finaliza:</h6>
                     <div class="ps-1 d-flex contenedor-fecha ms-2">
                        <?php
                        $cadena4=$row['date_out_new'];
                        $separador4 = "-";
                        $array4 = explode($separador4, $cadena4);
                        ?>
                        <h6 class="letraNavBar posicion-border3  diseñofecha text-center">
                           <?php echo $array4[2]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border1  diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array4[1]; ?>
                        </h6>
                        <h6 class="letraNavBar posicion-border2  diseñofecha text-center" style="margin-left: 10px;">
                           <?php echo $array4[0][2] . $array4[0][3]; ?>
                        </h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="perfil-yuntas">
               <?php include 'includes/perfil_hombre-mijer.php' ?>
            </div>
         </div>

         <div class="card perfil-estado-perfil" id="estado">
            <h5 class="letraNavBar colorletraperfil">Estado del Perfil</h5>
            <hr class="mt-0 colorlinea">
            <div id="estados-evaluados">
               <div id="estado-1">
                  <?php include "includes/horas_realizadas.php"; ?>
                  <div class="d-flex">
                     <img src="../img/horas-realizadas.webp">
                     <p class="letraNavBar colorletraperfil">Total horas realizadas</p>
                  </div>
                  <?php
                  if ($percentage < 100) {
                     echo '<div class="progress-circular">
                              <div class="circular-progress" style="background: conic-gradient(#D9D9D9 ' . ($percentageDeg * 3.6) . 'deg, #00D7C9 0deg);">
                                  <div class="letraNavBar value">' . $percentage . ' <span class="letraNavBar letra-pequena">Horas</span></div>
                              </div>
                          </div>';
                  } else {
                     echo '<div class="progress-circular">
                              <div class="circular-progress" style="background: conic-gradient(#D9D9D9 ' . ($percentageDeg * 3.6) . 'deg, #00D7C9 0deg);">
                                  <div class="letraNavBar value-container">' . $percentage . ' <span class="letraNavBar letra-pequena">Horas</span></div>
                              </div>
                          </div>';
                  }
                  ?>
               </div>
               <div id="estado-2">
                  <div class="d-flex">
                     <img class="icono-estado" src="../img/dias-agregados.webp">
                     <p class="letraNavBar colorletraperfil">Días agregados</p>
                  </div>
                  <div class="progress-circular">
                     <span class="letraNavBar value2">0<span class="letraNavBar letra-pequena">Días</span></span>
                  </div>
               </div>
               <div id="estado-3">
                  <?php include "includes/faltas_injustificadas.php"; ?>
                  <div class="d-flex">
                     <img src="../img/icono-faltas-injustificadas.webp">
                     <p class="letraNavBar colorletraperfil">Faltas injustificadas</p>
                  </div>
                  <?php
                  echo '<div class="progress-circular2">
                        <div class="circular-progress" style="background: conic-gradient(#D9D9D9 ' . ($percentageDeg * 3.6) . 'deg, #ff0000 0deg);">
                                 <div class="letraNavBar value">' . $percentage . ' <span class="letraNavBar letra-pequena">Días</span></div>
                           </div>
                        </div>';
                  ?>
               </div>
               <div id="estado-4">
                  <?php include "includes/horas-pendientes.php"; ?>
                  <div class="d-flex">
                     <img src="../img/icono-horas-pendientes.webp">
                     <p class="letraNavBar colorletraperfil">Horas pendientes de recuperación</p>
                  </div>
                  <?php
                  echo '<div class="progress-circular2">
                        <div class="circular-progress" style="background: conic-gradient(#D9D9D9 ' . ($percentageDeg * 3.6) . 'deg, #ff0000 0deg);">
                              <div class="letraNavBar value">' . $percentage . ' <span class="letraNavBar letra-pequena">Horas</span></div>
                        </div>
                     </div>';
                  ?>
               </div>
            </div>
         </div>

         <div class="card perfil-comunicacion" id="comunicacion">
            <h5 class="letraNavBar colorletraperfil">Comunicación</h5>
            <hr class="mt-0 colorlinea">
            <div id="estados-comunicacion">
               <div id="estado-4">
                  <?php include "includes/horas_realizadas.php"; ?>
                  <div class="d-flex">
                     <img src="../img/icono-horas-pendientes.webp">
                     <p class="letraNavBar colorletraperfil">Comunicación</p>
                  </div>
                  <div class="progress-circular">
                     <div class="circular-progress" style="background: conic-gradient(#D9D9D9 180deg, #00D7C9 0deg);">
                        <span class="letraNavBar value2">2</span>
                     </div>
                  </div>
               </div>
               <div id="estado-3">
                  <div class="d-flex">
                     <img src="../img/icono-faltas-injustificadas.webp">
                     <form method="post" action="memorandums.php" >
                        <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {
                           echo $row['employee_id'];
                        } else {
                           echo "";
                        } ?>">
                        <button type="submit" class="enlaces__btn text-light" id="button1">
                           <p class="letraNavBar colorletraperfil">Memoramdun</p>
                        </button>
                     </form>
                  </div>
                  <div class="progress-circular2">
                     <div class="circular-progress" style="background: conic-gradient(#D9D9D9 180deg, #ff0000 0deg);">
                        <span class="letraNavBar value2">2</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="d-flex flex-column gap-4">
         <div class="card perfil-estadistica-desempeño" id="estadistica-desempeño">
            <div class="d-flex encabezado" id="encabezado-estadistica">
               <div>
                  <h6 class="letraNavBar colorletraperfil">Estadísticas de desempeño</h6>
                  <p class="letraNavBar colorletraperfil">Última semana</p>
               </div>
               <form method="post" action="estadisticas-logros-ultima-semana.php" class="form_ver-mas">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <button type="submit" class="enlaces__btn" id="button1">
                     <div class="ver-mas">
                        <a class="letraNavBar text-light">Ver más >></a>
                     </div>
                  </button>
               </form>
            </div>
            <hr class="mt-0 colorlinea">
            <div id="flower-graphic">
               <?php include 'includes/nota_ultima-semana.php' ?>
               <div id="flower-body">
                  <div>
                     <h3 class="letraNavBar text-light nota-flower1">
                        <?php echo $promedioNota2; ?>
                     </h3>
                     <div class="flower-body-1">
                        <div class="petal-1-1"></div>
                        <div class="petal-1-2"></div>
                        <div class="petal-1-3"></div>
                     </div>
                  </div>
                  <div>
                     <h3 class="letraNavBar text-light nota-flower2">
                        <?php echo $promedioNota1; ?>
                     </h3>
                     <div class="flower-body-2">
                        <div class="petal-2-1"></div>
                        <div class="petal-2-2"></div>
                        <div class="petal-2-3"></div>
                     </div>
                  </div>
                  <div>
                     <h3 class="letraNavBar text-light nota-flower3">
                        <?php echo $promedioNota3; ?>
                     </h3>
                     <div class="flower-body-3">
                        <div class="petal-3-1"></div>
                        <div class="petal-3-2"></div>
                        <div class="petal-3-3"></div>
                     </div>
                  </div>
               </div>
               <div id="graph-legend">
                  <div class="d-flex legend">
                     <div class="square-legend-1"></div>
                     <p class="letraNavBar colorletraperfil">Aspectos Individuales</p>
                  </div>
                  <div class="d-flex legend">
                     <div class="square-legend-2"></div>
                     <p class="letraNavBar colorletraperfil">Aspectos Grupales</p>
                  </div>
                  <div class="d-flex legend">
                     <div class="square-legend-3"></div>
                     <p class="letraNavBar colorletraperfil">Aspectos profesionales</p>
                  </div>
               </div>
               <div id="average-note">
                  <h6 class="letraNavBar text-light">Promedio =
                     <?php echo $promidioSemanal; ?>
                  </h6>
               </div>
            </div>
         </div>

         <div class="card perfil-logros" id="logros">
            <div class="d-flex encabezado">
               <h6 class="letraNavBar colorletraperfil">Logros</h6>
               <a class="letraNavBar colorletraperfil">Ver más >></a>
            </div>
            <div class="logros-logrados_2">
               <?php include 'includes/notas-ultimo-mes-medalla.php' ?>
            </div>
            <hr class=" colorlinea">
            <div class="d-flex encabezado">
               <h6 class="letraNavBar colorletraperfil">Recordatorio Semanal</h6>
               <form method="post" action="calendario-general-practicante.php">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <button type="submit" class="enlaces__btn enlaces__btn-v2" id="button1">
                     <a class="letraNavBar colorletraperfil">Ver más >></a>
                  </button>
               </form>
            </div>
            <div class="mt-3">
               <?php include 'includes/recordatorio-semanal.php'; ?>
               <?php
               if ($result->num_rows > 0) {
                  $registros = [];

                  while ($row = $result->fetch_assoc()) {
                     $registros[] = $row;
                  }

                  for ($i = count($registros) - 1; $i >= 0; $i--) {
                     echo '<div class="d-flex">
                  <img src="../img/icono-recordatorio.webp">
                  <p class="letraNavBar colorletraperfil">';
                     $fecha = date("d", strtotime($registros[$i]["fecha"])) . " de " . $meses[date("n", strtotime($registros[$i]["fecha"])) - 1]; // Formatear la fecha en español
                     echo $dias_semana[date("w", strtotime($registros[$i]["fecha"]))] . " " . $fecha . " - " . $registros[$i]["titulo"] . "<br>";
                     echo '</p>
                  </div>';
                  }
               } else {
                  echo "No se encontraron eventos.";
               }
               ?>
            </div>
         </div>
      </div>
   </div>

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