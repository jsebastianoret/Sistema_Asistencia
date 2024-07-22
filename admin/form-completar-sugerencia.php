<?php include 'includes/header-practicante.php'; ?>

<?php
include 'includes/conn.php';

if (isset($_POST['employee_id']) && isset($_POST['data'])) {
    $employeeId = $_POST['employee_id'];
    $userData = json_decode(urldecode($_POST['data']), true);

    $id = $userData['id'];
    $nombre = $userData['nombre'];
    $asunto = $userData['asunto'];
    $tipo = $userData['tipo'];
    $unidad = $userData['unidad'];
    $sugerencia = $userData['sugerencia'];
}
?>

<body class="bg-white">
   <?php include 'includes/fecha_actual.php' ?>
   <nav class="navbar navbar-expand-lg bg-nav nav-modelo">
      <div class="container-fluid">
         <div class="input-group mb-3 diseño-escribir-aqui">
            <input type="text" class="form-control" placeholder="Escribe aqui...">
            <span class="ps-5"></span>
         </div>
         <div class="d-flex posicion">
            <h6 class="pe-3 letraNavBar posicion-fecha">
               <?php echo $diaActual . " de " . $mesActual; ?>
            </h6>
            <img src="../img/notificacion.webp" alt="notificacion" height="40" width="40">
         </div>
         <div class="circle-container d-flex me-5 posicion-perfil">
            <?php include 'includes/fotoperfil.php'; ?>
            <h6 class="ps-3 letraNavBar posicion-fecha"><?php if (isset($row['firstname'])) {echo $row['firstname'];} else {echo "";}?>
            </h6>
         </div>
      </div>
   </nav>
   <aside class="main-sidebar color-menubar-practicante aside-modelo">
      <div class="siderbar-practicantes">
         <?php include 'includes/cambio_logo.php' ?>
      </div>
      <br>
      <div class="nav-items">
         <div class="enlaces" href="home-practicante.php" id="button1">
            <form method="post" action="home-practicante.php" class="form__ver-perfil">
               <input id="idPracticante" type="hidden" name="employee_id"
                  value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1">
                     <img class="icono-centrar" src="../img/icono-home.webp">
                     <h6 class="text-center text-light letraNavBar">INICIO</h6>
                  </a>
               </button>
            </form>
         </div>
         <br>
         <div class="enlaces clicked" href="perfil-practicante.php" id="button1">
            <form method="post" action="perfil-practicante.php" class="form__ver-perfil">
               <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1">
                     <img class="icono-centrar" src="../img/icono-perfil.webp">
                     <h6 class="text-center text-light letraNavBar">MI PERFIL</h6>
                  </a>
               </button>
            </form>
         </div>
         <br>
         <div class="enlaces" href="estadisticas-y-logros-practicante.php" id="button1" >
            <form method="post" action="estadisticas-y-logros-practicante.php" class="form__ver-perfil">
               <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1" >
                     <img class="icono-centrar" src="../img/icono-estadistica.webp" >
                     <h6 class="text-center text-light letraNavBar" style="width: 120px; margin-left: 15px;">ESTADISTICAS Y LOGROS</h6>
                  </a>
               </button>
            </form>
         </div>
         <br>
         <div class="enlaces" href="calendario-practicante.php" id="button1">
            <form method="post" action="calendario-practicante.php" class="form__ver-perfil">
               <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1">
                     <img class="icono-centrar" src="../img/icono-calendario.webp">
                     <h6 class="text-center text-light letraNavBar" style="width: 110px; margin-left: 20px;">
                        CALENDARIO O AGENDA
                     </h6>
                  </a>
               </button>
            </form>
         </div>
         <br>
         <div class="enlaces" id="button1">
            <form method="post" action="buzon.php" class="form__ver-perfil">
               <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1">
                     <img class="icono-centrar" src="../img/icono-buzon-sugerencia.webp">
                     <h6 class="text-center text-light letraNavBar" style="width: 110px; margin-left: 20px;">
                        BUZON DE SUGERENCIAS
                     </h6>
                  </a>
               </button>
            </form>
         </div>
         <br>
         <div class="enlaces" id="button1">
            <form method="post" action="archivos-practicante.php" class="form__ver-perfil">
               <input type="hidden" name="employee_id" value="<?php if (isset($row['employee_id'])) {echo $row['employee_id'];} else {echo "";}?>">
               <button type="submit" class="enlaces__btn" id="button1">
                  <a class="enlaces" href="#" id="button1">
                     <img class="icono-centrar" src="../img/archivo.png">
                     <h6 class="text-center text-light letraNavBar" style="width: 110px; margin-left: 20px;">
                        ARCHIVOS
                     </h6>
                  </a>
               </button>
            </form>
         </div>
      </div>
      <br>
      <div class="mb-3 salir">
         <a class="enlaces" onclick="salirMiPerfil()">
            <img class="icono-centrar" src="../img/icono-salir.webp">
            <h6 class="text-center text-light letraNavBar">SALIR</h6>
         </a>
      </div>
   </aside>

    <main class="buzon-container">
        <div class="regresar">
            <form method="post" action="buzon.php">
                <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                <input class="volver" type="submit" value="< VOLVER">
            </form>
        </div>
        <div class="form-container">
            <p>¡Adelante! Queremos escucharte :)</p>
            <div>
                <form method="post" action="" id="sugerencia-form">
                    <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php
                    date_default_timezone_set('America/Lima');
                    $fechaActual = date('Y-m-d')
                    ?>
                    <input type="hidden" name="fecha" value="<?php echo $fechaActual; ?>">

                    <div class="form-inputs">
                        <select name="nombre">
                            <option value="">¿Cómo te llamas?</option>
                            <option value="Prefiero no decirlo" <?php if ($nombre === "Prefiero no decirlo") echo 'selected'; ?>>Prefiero no decirlo</option>
                            <option value="<?php echo $row['firstname']; ?>" <?php if ($nombre === $row['firstname']) echo 'selected'; ?>><?php echo $row['firstname']; ?></option>
                        </select>
                        <input name="asunto" type="text" placeholder="Nombre del asunto (Título)" value="<?php echo $asunto; ?>" />
                        <select name="tipo">
                            <option value="">¿Para qué usaras el buzón?</option>
                            <option value="Sugerencia de mejora" <?php if ($tipo == 'Sugerencia de mejora') echo 'selected'; ?>>Sugerencia de mejora</option>
                            <option value="Observación" <?php if ($tipo == 'Observación') echo 'selected'; ?>>Observación</option>
                            <option value="Reclamo" <?php if ($tipo == 'Reclamo') echo 'selected'; ?>>Reclamo</option>
                        </select>
                        <select name="unidad">
                            <option value="">¿A qué unidad perteneces?</option>
                            <option value="NHL Decoraciones" <?php if ($unidad == 'NHL Decoraciones') echo 'selected'; ?>>NHL Decoraciones</option>
                            <option value="Vaping Cloud" <?php if ($unidad == 'Vaping Cloud') echo 'selected'; ?>>Vaping Cloud</option>
                            <option value="Yuntas Producciones" <?php if ($unidad == 'Yuntas Producciones') echo 'selected'; ?>>Yuntas Producciones</option>
                            <option value="Digimedia Marketing" <?php if ($unidad == 'Digimedia Marketing') echo 'selected'; ?>>Digimedia Marketing</option>
                        </select>
                    </div>
                    <textarea name="sugerencia" class="contenido-sugerencia" placeholder="Escribe aquí..."><?php echo $sugerencia; ?></textarea>
                    <div class="form-btns">
                        <div class="button-container">
                            <button class="guardar" type="submit" name="guardar" formaction="guardarJSON.php" style="font-size: 20px;">Guardar</button>
                        </div>
                        <div class="button-container">
                            <button class="enviar" type="submit" name="enviar" formaction="enviar-sugerencia.php" style="font-size: 20px;">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
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