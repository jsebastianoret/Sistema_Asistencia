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

            <div class="buttons-estadistica">
               <form method="post" action="estadisticas-y-logros-practicante.php" class="form__calendar">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="GENERAL" class="btn__calendar--active letraNavBar text-light">
               </form>
               <form method="post" action="estadisticas-logros-ultimo-mes.php"
                  class="form__calendar calendar-button-color">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="ÚLTIMO MES" class="btn__calendar letraNavBar text-light ">
               </form>
               <form method="post" action="estadisticas-logros-ultima-semana.php"
                  class="form__calendar calendar-button-color">
                  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                  <input type="submit" value="ÚLTIMA SEMANA" class="btn__calendar letraNavBar text-light">
               </form>
            </div>
            <div id="estadistica-logro-practicante">

               <?php include 'includes/nota_general.php'; ?>

            </div>
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