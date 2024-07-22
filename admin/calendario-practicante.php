<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
   <?php $calendario_click = "clicked" ?>
   <?php include 'includes/fecha_actual.php' ?>
   <?php include 'includes/navbar-sidebar-practicante.php' ?>

   <div class="container-fluid" id="calendario-agenda">
      <div class="buttons">
         <form action="includes/eventos-calendar-practicante.php" method="post">
            <input type="hidden" id="idPracticanteActividad" name="idPracticanteActividad"
               value="<?php echo $row['id'] ?>">
         </form>

         <form method="post" action="calendario-practicante.php" class="form__calendar">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="MIS TAREAS" class="btn__calendar--active letraNavBar text-light">
         </form>
         <form method="post" action="calendario-eventos-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="EVENTOS" class="btn__calendar letraNavBar text-light ">
         </form>
         <form method="post" action="calendario-general-practicante.php" class="form__calendar calendar-button-color">
            <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
            <input type="submit" value="GENERAL" class="btn__calendar letraNavBar text-light">
         </form>

      </div>
      <div class="card" id="calendar">
         <div class="calendar_info">
            <div class="calendar_prev" id="prev-month"><img src="../img/flecha-izquierda.webp"
                  style="width: 10px; height:10px;"></div>
            <div class="letraNavBar colorletraperfil calendar_month" id="month"></div>
            <div class="calendar_next" id="next-month"><img src="../img/flecha-derecha.webp"
                  style="width: 10px; height:10px;"></div>
            <div class="letraNavBar colorletraperfil calendar_year" id="year"></div>
         </div>
         <div>
            <div id="daysN" class="days__n"></div>
            <div class="letraNavBar calendar_date" id="dates"></div>
         </div>
      </div>
      <br>

      <!-- Modal add -->
      <div class="modal" tabindex="-1" role="dialog" id="eventoModal">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal__calendar">

               <button type="button" class="close close-button-2" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <br>
               <h3 class="modal-title title__calendar letraNavBar">Programar mi actividad</h3>
               <div class="modal-body">
                  <!-- Campos del formulario -->
                  <form action="includes/guardar_evento.php" method="post">
                     <div class="contendModal-tf">
                        <div class="contendModal-tf1 contend-descripcion">
                           <div class="fechasModal">
                              <label class="lavel-form letraNavBar">Título</label>
                              <input type="text" class="form-control calendario-imput TituloModal letraNavBar"
                                 id="titulo" name="titulo" placeholder="Ingrese el título del evento">
                           </div>
                           <div class="fechasModal">
                              <label class="lavel-form letraNavBar">Desde</label>
                              <input type="date" class="calendario-imput form-control fechaModal letraNavBar"
                                 name="fechaDesde" id="fechaDesde" readonly>
                              <span class="separadorFecha"></span>
                              <label class="lavel-form letraNavBar">Hasta</label>
                              <input type="date" class="calendario-imput form-control fechaModal letraNavBar"
                                 name="fechaHasta" id="fechaHasta">
                           </div>
                        </div>
                        <div class="contendModal-tf2">
                           <div class="form__color-calendar2">
                              <input type="color" class="form__color-calendar-container coloModal-edit" name="color"
                                 id="color">
                           </div>
                           <label class="lavel-form letraNavBar">Color</label>
                        </div>
                     </div>
                     <div class="form-group letraNavBar">
                        <textarea placeholder=" Coloque la descripcion aquí"
                           class="form-control calendario-imput letraNavBar" name="detalles" id="detalles" rows="6"
                           style="margin-top: 13px;"></textarea>
                     </div>
                     <div class="form-group">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                        <input type="hidden" class="form-control" id="idPracticante" name="idPracticante"
                           value="<?php echo $row['id'] ?>" readonly>
                     </div>
                     <div class="modal-footer modal-text-center">
                        <button type="submit" class="btn btn-primary letraNavBar" id="reiniciar">Guardar</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="eventoModalEdit">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal__calendar">
               <div class="modal-header" style="background-color: #54af0c;">
                  <button type="button" class="close close-button-2" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  <h3 class="modal-title title__calendar title-md letraNavBar"
                     style="color: white; margin-inline-start: auto; top:auto; letraNavBar">Mi actividad</h3>
               </div>

               <div class="modal-body">
                  <form action="includes/Editar-eliminar-actividades.php" method="post">
                     <input readonly type="hidden" class="form-control" id="idModal" name="idModal">
                     <div class="contendModal-tf">
                        <div class="contendModal-tf1 contend-descripcion">
                           <div class="fechasModal">
                              <label class="lavel-form">Título</label>
                              <input readonly type="text" class="calendario-imput form-control TituloModal"
                                 id="TituloModal" name="TituloModal" placeholder="Ingrese el título del evento">
                           </div>
                           <div class="fechasModal">
                              <label class="lavel-form">Desde</label>
                              <input readonly type="date" class="calendario-imput form-control fechaModal"
                                 id="desdeModal" name="desdeModal" placeholder="Ingrese el título del evento">
                              <span class="separadorFecha"></span>
                              <label class="lavel-form">Hasta</label>
                              <input readonly type="date" class="calendario-imput form-control fechaModal"
                                 id="hastaModal" name="hastaModal" placeholder="Ingrese el título del evento">
                           </div>
                        </div>
                        <div class="contendModal-tf2">
                           <div class="form__color-calendar2">
                              <input disabled type="color"
                                 class="form__color-calendar-container coloModal-edit letraNavBar" id="colorModal"
                                 name="colorModal" placeholder="Ingrese el título del evento">
                           </div>
                           <label class="lavel-form">Color</label>
                        </div>
                     </div>
                     <div class="form-group">
                        <textarea readonly class="calendario-imput form-control detallesModal" name="detallesModal"
                           id="detallesModal" rows="6"></textarea>
                     </div>
                     <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                     <div class="modalEditButtons">
                        <button type="button" class="btn btn-success btnMotalEdit letraNavBar"
                           id="editButton">Editar</button>
                        <button type="submit" class="btn btn-danger btnMotalEdit letraNavBar" name="eliminar"
                           id="elimButton">Eliminar</button>
                        <button type="submit" class="btn btn-primary btnMotalEdit letraNavBar" name="guardar"
                           id="guardarButton" style="display: none;">Guardar</button>
                        <button type="button" class="btn btn-secondary btnMotalEdit letraNavBar" id="cancelarButton"
                           style="display: none;">Cancelar</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <script>
         $(document).ready(function () {
            $("#editButton").click(function () {
               $("#TituloModal, #desdeModal, #hastaModal, #colorModal, #detallesModal").removeAttr("readonly disabled");
               $("#editButton, #elimButton").hide();
               $("#guardarButton, #cancelarButton").show();
            });
            $("#cancelarButton").click(function () {
               $("#TituloModal, #desdeModal, #hastaModal, #colorModal, #detallesModal").attr("readonly", "readonly").attr("disabled", "disabled");
               $("#editButton, #elimButton").show();
               $("#guardarButton, #cancelarButton").hide();
            });
         });
         $(document).ready(function () {
            $("form").submit(function (event) { });
         });
      </script>
      <script>
         let idPracticante = document.getElementById("idPracticante");
         if (idPracticante.value.length > 15) {
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
      <script src="../js/calendarioMisTareas.js"></script>


      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>